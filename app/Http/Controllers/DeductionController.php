<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use App\Http\Requests\{StoreDeductionRequest, UpdateDeductionRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Models\Department;
use App\Models\EmployeeHasDeduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeductionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:deduction view')->only('index', 'show');
        $this->middleware('permission:deduction create')->only('create', 'store');
        $this->middleware('permission:deduction edit')->only('edit', 'update');
        $this->middleware('permission:deduction delete')->only('destroy');
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
            $employees = $employees->orderBy('employees.id', 'DESC')->get();

            return DataTables::of($employees)
                ->addColumn('department', function ($row) {
                    return $row->department_name;
                })->addColumn('total', function ($row) {
                    return  EmployeeHasDeduction::where('employee_id', $row->id)->sum('amount');
                })->addColumn('deductions', function ($row) {
                    return  EmployeeHasDeduction::where('employee_id', $row->id)->get();
                })
                ->addColumn('action', 'deductions.include.action')
                ->toJson();
        }
        $departement = Department::all();
        return view('deductions.index', [
            'departement' => $departement
        ]);
    }


    public function edit($id)
    {
        $employee = DB::table('employees')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->select(
                'employees.*',
                'departments.department_name'
            )
            ->where('employees.id', '=', $id)
            ->first();

        $deductions = EmployeeHasDeduction::where('employee_id', $employee->id)->get();

        return view('deductions.edit', compact('employee', 'deductions'));
    }

    public function update(Request $request, $id)
    {
        $result = DB::table('deductions')
            ->where('employee_id', '=', $id) // Replace $yourId with the actual ID you are looking for
            ->first();
        if ($result) {
            DB::table('deductions')
                ->where('employee_id', $id)
                ->update([
                    'bpjs_jht' => $request->bpjs_jht,
                    'bpjs_jkk_jkm' => $request->bpjs_jkk_jkm,
                    'bpjs_jp' => $request->bpjs_jp,
                    'bpjs_healt' => $request->bpjs_healt,
                    'pph' => $request->pph
                ]);
        } else {
            DB::table('deductions')->insert([
                'employee_id' => $id,
                'bpjs_jht' => $request->bpjs_jht,
                'bpjs_jkk_jkm' => $request->bpjs_jkk_jkm,
                'bpjs_jp' => $request->bpjs_jp,
                'bpjs_healt' => $request->bpjs_healt,
                'pph' => $request->pph
            ]);
        }
        return redirect()
            ->route('deductions.index')
            ->with('success', __('The deduction was updated successfully.'));
    }
}
