<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Models\Employee;
use App\Http\Requests\{StoreEmployeeRequest, UpdateEmployeeRequest, ImportEmployeeRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\FormatImport\GenerateEmployeeFormat;
use App\Helpers\ModelFileUploadHelper;
use App\Imports\EmployeeImport;
use App\Models\Bank;
use App\Models\BranchOffice;
use App\Models\Gpslocation;
use PDF;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:employee view')->only('index', 'show');
        $this->middleware('permission:employee create')->only('create', 'store');
        $this->middleware('permission:employee edit')->only('edit', 'update');
        $this->middleware('permission:employee delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $departementFilter = intval($request->query('departement'));
            $statusFilter = $request->query('work_status');
            $useGpsFilter = $request->query('use_gps_location');
            $employees = DB::table('employees')
                ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
                ->leftJoin('branch_offices', 'employees.branch_office_id', '=', 'branch_offices.id')
                ->leftJoin('banks', 'employees.bank_id', '=', 'banks.id')
                ->select(
                    'employees.*',
                    'departments.department_name',
                    'branch_offices.name as branch_office_name',
                    'banks.name as bank_name',
                );
            if (isset($departementFilter) && !empty($departementFilter)) {
                if ($departementFilter != 'All') {
                    $employees = $employees->where('employees.department_id', $departementFilter);
                }
            }

            if (isset($useGpsFilter) && !empty($useGpsFilter)) {
                if ($useGpsFilter != 'All') {
                    $employees = $employees->where('employees.use_gps_location', $useGpsFilter);
                }
            }

            if (isset($statusFilter) && !empty($statusFilter)) {
                if ($statusFilter != 'All') {
                    $employees = $employees->where('employees.work_status', $statusFilter);
                }
            }
            $employees = $employees->orderBy('employees.id', 'DESC')->get();

            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    return $row->department_name;
                })->addColumn('salary', function ($row) {
                    return  $row->currency . ' ' . currency($row->salary);
                })
                ->addColumn('daily_salary', function ($row) {
                    return  $row->currency . ' ' . currency($row->daily_salary);
                })
                ->addColumn('action', 'employees.include.action')
                ->toJson();
        }
        $departement = Department::all();

        return view('employees.index', [
            'departement' => $departement
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gpslocations = Gpslocation::orderBy('gpc_location_name', 'asc')->get();
        $branch = BranchOffice::get();
        $banks = Bank::get();
        $availablePayrollTypes = ['monthly', 'daily', 'monthly_and_daily'];
        $arr_departments = Department::get();

        return view('employees.create', [
            'gpslocations' => $gpslocations,
            'branch' => $branch,
            'banks' => $banks,
            'availablePayrollTypes' => $availablePayrollTypes,
            'arr_departments' => $arr_departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $attr = $request->validated();
        $attr['password'] = bcrypt($request->password);

        if ($request->file('photo')) {
            $attr['photo'] = ModelFileUploadHelper::modelFileStore('employees', 'photo', $request->file('photo'));
        }

        if ($request->payroll_type == 'daily') {
            unset($attr['salary']);
        } else if ($request->payroll_type == 'monthly') {
            unset($attr['daily_salary']);
            unset($attr['craft_incentives']);
        }

        if ($request->department_id == '5') {
            unset($attr['meal_allowance']);
        }

        $employee = Employee::create($attr);
        $employeeId = $employee->id;
        $locations =  $request->location_id;
        if (!is_null($locations) && count($locations) > 0) {
            foreach ($locations as $locationId) {
                DB::table('location_attendance_employee')->insert([
                    'employee_id' => $employee->id,
                    'location_id' => $locationId,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        return redirect()
            ->route('employees.index')
            ->with('success', __('The employee was created successfully.'));
    }

    public function show(Employee $employee)
    {
        try {
            // Fetch employee data with related department, branch office, bank details
            $employee = DB::table('employees')
                ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
                ->leftJoin('branch_offices', 'employees.branch_office_id', '=', 'branch_offices.id')
                ->leftJoin('banks', 'employees.bank_id', '=', 'banks.id')
                ->select(
                    'employees.*',
                    'departments.department_name',
                    'branch_offices.name as branch_office_name',
                    'banks.name as bank_name'
                )
                ->where('employees.id', '=', $employee->id)
                ->first(); // Get the first (and only) result
            // Fetch employee files related to the employee
            $employee_files = DB::table('employee_files')
                ->where('employee_id', '=', $employee->id)
                ->get();

            // Fetch families related to the employee
            $families = DB::table('employee_families')
                ->where('employee_id', '=', $employee->id)
                ->get();

            // Return the view with the fetched data
            return view('employees.show', compact('employee', 'employee_files', 'families'));
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the query execution
            return redirect()->back()->with('error', 'Failed to fetch employee data: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $employee->load('department:id,department_name');
        $locationIds = DB::table('location_attendance_employee')
            ->where('employee_id', $employee->id)
            ->pluck('location_id')
            ->toArray();
        $branch = BranchOffice::get();
        $banks = Bank::get();
        $availablePayrollTypes = ['monthly', 'daily', 'monthly_and_daily'];
        $arr_departments = Department::get();

        return view('employees.edit', compact('employee', 'locationIds', 'branch', 'banks', 'availablePayrollTypes', 'arr_departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $attr = $request->validated();
        switch (is_null($request->password)) {
            case true:
                unset($attr['password']);
                break;
            default:
                $attr['password'] = bcrypt($request->password);
                break;
        }

        if ($request->file('photo')) {
            $attr['photo'] = ModelFileUploadHelper::modelFileUpdate($employee, 'photo', $request->file('photo'));
        } else {
            $attr['photo'] = $employee->photo;
        }

        if ($request->payroll_type == 'daily') {
            $attr['salary'] = null;
        } else if ($request->payroll_type == 'monthly') {
            $attr['daily_salary'] = null;
            $attr['craft_incentives'] = null;
        }

        if ($request->department_id == '5') {
            $attr['meal_allowance'] = null;
        }

        $employee->update($attr);
        // hapus data lama
        DB::table('location_attendance_employee')->where('employee_id', $employee->id)->delete();
        // insert yang baru
        $locations =  $request->location_id;
        if (!is_null($locations) && count($locations) > 0) {
            foreach ($locations as $locationId) {
                DB::table('location_attendance_employee')->insert([
                    'employee_id' => $employee->id,
                    'location_id' => $locationId,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        return redirect()
            ->route('employees.index')
            ->with('success', __('The employee was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            ModelFileUploadHelper::modelFileDelete($employee, 'photo');
            $employee->delete();

            return redirect()
                ->route('employees.index')
                ->with('success', __('The employee was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('employees.index')
                ->with('error', __("The employee can't be deleted because it's related to another table."));
        }
    }

    public function exportEmployees($departement, $work_status, $use_gps_location)
    {
        $date = date('d-m-Y');
        $nameFile = 'Employee-List' . $date;
        return Excel::download(new EmployeeExport($departement, $work_status, $use_gps_location), $nameFile . '.xlsx');
    }

    public function downloadFormat()
    {
        $date = date('d-m-Y');
        $nameFile = 'format_import_employee' . $date;
        return Excel::download(new GenerateEmployeeFormat(), $nameFile . '.xlsx');
    }

    public function import(ImportEmployeeRequest $request)
    {
        try {
            Excel::import(new EmployeeImport, $request->file('import_employees'));
            return redirect()
                ->route('employees.index')
                ->with('success', __("Employee has been successfully imported."));
        } catch (\Throwable $th) {
            return redirect()
                ->route('employees.index')
                ->with('error', __("Employee has been Failed imported."));
        }
    }

    public function printPdf($departementFilter, $statusFilter, $useGpsFilter)
    {
        $employees = DB::table('employees')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->select(
                'employees.*',
                'departments.department_name'
            );
        if (isset($departementFilter) && !empty($departementFilter)) {
            if ($departementFilter != 'All') {
                $employees = $employees->where('employees.department_id', $departementFilter);
            }
        }

        if (isset($useGpsFilter) && !empty($useGpsFilter)) {
            if ($useGpsFilter != 'All') {
                $employees = $employees->where('employees.use_gps_location', $useGpsFilter);
            }
        }

        if (isset($statusFilter) && !empty($statusFilter)) {
            if ($statusFilter != 'All') {
                $employees = $employees->where('employees.work_status', $statusFilter);
            }
        }
        $employees = $employees->orderBy('employees.id', 'DESC')->get();

        $pdf = PDF::loadview('employees.pdf', ['employees' => $employees]);
        return $pdf->download('Employee-List-Pdf');
    }


    public function employeeFile(Request $request)
    {

        if ($request->file('file')) {
            $file = ModelFileUploadHelper::modelFileStore('employee_file', 'file', $request->file('file'));
        }

        DB::table('employee_files')->insert([
            'file_name' => $request->file_name,
            'file' => $file,
            'employee_id' => $request->employee_id
        ]);
        return back()->with('success', __("Success save data contract no"));
    }

    public function delFile($id)
    {
        $getData =  DB::table('employee_files')->where('id', $id)->first();
        // delete
        if ($getData) {
            $filePath = public_path('storage/employee-file/file/' . $getData->file);
            if (file_exists($filePath)) {
                unlink($filePath);
                echo "File berhasil dihapus.";
            } else {
                echo "File tidak ditemukan.";
            }
            DB::table('employee_files')->where('id', $id)->delete();
            return back()->with('success', __("Success delete data contract no"));
        } else {
            return back()->with('success', __("Data not Found"));
        }
    }

    public function resetDevice($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->update([
                'device_id' => null,
                'token_fcm' => null,
            ]);

            return back()->with('success', __("Success reset device for employee"));
        } else {
            return back()->with('error', __("Data not found"));
        }
    }
}
