<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\{StoreDepartmentRequest, UpdateDepartmentRequest};
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:department view')->only('index', 'show');
        $this->middleware('permission:department create')->only('create', 'store');
        $this->middleware('permission:department edit')->only('edit', 'update');
        $this->middleware('permission:department delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $departments = Department::query();

            return DataTables::of($departments)
                ->addColumn('action', 'departments.include.action')
                ->toJson();
        }

        return view('departments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {

        Department::create($request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', __('The department was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $availablePayrollTypes = collect([
            'monthly',
            'daily'
        ]);
        return view('departments.edit', compact('department', 'availablePayrollTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update([
            'default_payroll_type' => $request->default_payroll_type
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', __('The department was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $department->delete();

            return redirect()
                ->route('departments.index')
                ->with('success', __('The department was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('departments.index')
                ->with('error', __("The department can't be deleted because it's related to another table."));
        }
    }
}
