<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeHasEarningRequest;
use App\Http\Requests\UpdateEmployeeHasEarningRequest;
use App\Models\EmployeeHasEarning;
use Illuminate\Http\Request;

class EmployeeEarningController extends Controller
{
    public function store(StoreEmployeeHasEarningRequest $request, $employeeId)
    {
        EmployeeHasEarning::create([
            'employee_id' => $employeeId,
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Employee Earning ' . $request->name . ' has been created');
    }

    public function update(UpdateEmployeeHasEarningRequest $request, $employeeHasEarningId)
    {
        EmployeeHasEarning::where('id', $employeeHasEarningId)->update([
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Employee Earning ' . $request->name . ' has been updated');
    }

    public function destroy($employeeHasEarningId)
    {
        EmployeeHasEarning::destroy($employeeHasEarningId);

        return back()->with('success', 'Employee Earning has been deleted');
    }
}
