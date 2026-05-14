<?php

namespace App\Http\Controllers;

use App\Models\EmployeeFamily;
use Illuminate\Http\Request;

class EmployeeFamilyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'employee_id' => 'required|exists:employees,id',
        ]);

        EmployeeFamily::create($request->all());

        return redirect()->back()->with('success', 'Family member added successfully.');
    }

    public function destroy($id)
    {
        $family = EmployeeFamily::findOrFail($id);
        $family->delete();

        return redirect()->back()->with('success', 'Family member deleted successfully.');
    }
}
