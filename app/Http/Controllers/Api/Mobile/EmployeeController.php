<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'code' => 200,
            'msg' => 'Successfully getting employees data',
            'data' => Employee::selectRaw("employees.*, CONCAT('" . url('/') . "', '/storage/employees/photo/', employees.photo) as photo_formatted")->with('department')
                ->when($request->name, function ($q) use ($request) {
                    $q->where('full_name', 'LIKE', '%' . $request->name . '%');
                })
                ->simplePaginate(10)
        ]);
    }
}
