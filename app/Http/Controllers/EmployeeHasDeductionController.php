<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeHasDeductionRequest;
use App\Http\Requests\UpdateEmployeeHasDeductionRequest;
use App\Models\EmployeeHasDeduction;
use Illuminate\Http\Request;

class EmployeeHasDeductionController extends Controller
{
    public function store(StoreEmployeeHasDeductionRequest $request, $employeeId)
    {
        EmployeeHasDeduction::create([
            'employee_id' => $employeeId,
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Employee Deduction ' . $request->name . ' has been created');
    }

    public function update(UpdateEmployeeHasDeductionRequest $request, $employeeHasDeductionId)
    {
        EmployeeHasDeduction::where('id', $employeeHasDeductionId)->update([
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Employee Deduction ' . $request->name . ' has been updated');
    }

    public function destroy($employeeHasDeductionId)
    {
        EmployeeHasDeduction::destroy($employeeHasDeductionId);

        return back()->with('success', 'Employee Deduction has been deleted');
    }
}
