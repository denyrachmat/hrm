<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use App\Http\Requests\{StoreEarningRequest, UpdateEarningRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Models\Department;
use App\Models\EmployeeHasEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:earning view')->only('index', 'show');
        $this->middleware('permission:earning create')->only('create', 'store');
        $this->middleware('permission:earning edit')->only('edit', 'update');
        $this->middleware('permission:earning delete')->only('destroy');
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
                })
                ->addColumn('total', function ($row) {
                    return  EmployeeHasEarning::where('employee_id', $row->id)->sum('amount');
                })
                ->addColumn('earnings', function ($row) {
                    return  EmployeeHasEarning::where('employee_id', $row->id)->get();
                })
                ->addColumn('action', 'earnings.include.action')
                ->toJson();
        }
        $departement = Department::all();
        return view('earnings.index', [
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

        $earnings = EmployeeHasEarning::where('employee_id', $employee->id)->get();
        return view('earnings.edit', compact('employee', 'earnings'));
    }

    public function update(Request $request, $id)
    {

        $result = DB::table('earnings')
            ->where('employee_id', '=', $id) // Replace $yourId with the actual ID you are looking for
            ->first();
        if ($result) {
            DB::table('earnings')
                ->where('employee_id', $id)
                ->update([
                    'bpjs_jht' => $request->bpjs_jht,
                    'bpjs_jkk_jkm' => $request->bpjs_jkk_jkm,
                    'bpjs_jp' => $request->bpjs_jp,
                    'bpjs_healt' => $request->bpjs_healt
                ]);
        } else {
            DB::table('earnings')->insert([
                'employee_id' => $id,
                'bpjs_jht' => $request->bpjs_jht,
                'bpjs_jkk_jkm' => $request->bpjs_jkk_jkm,
                'bpjs_jp' => $request->bpjs_jp,
                'bpjs_healt' => $request->bpjs_healt
            ]);
        }
        return redirect()
            ->route('earnings.index')
            ->with('success', __('The earning was updated successfully.'));
    }
}
