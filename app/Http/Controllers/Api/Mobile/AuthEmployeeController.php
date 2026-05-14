<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Helpers\ModelFileUploadHelper;
use App\Helpers\TokenHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiMobileAuthEmployeeChangePasswordRequest;
use App\Http\Requests\ApiMobileAuthEmployeeUpdateRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthEmployeeController extends Controller
{
    public function update(ApiMobileAuthEmployeeUpdateRequest $request)
    {
        $employeeJwt = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $employee = Employee::find($employeeJwt->id);

        $employee->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'photo' => ModelFileUploadHelper::modelFileUpdate($employee, 'photo', $request->file('photo'))
        ]);

        return response()->json([
            'msg' => 'Profile, successfully updated',
            'data' => $employee
        ], 200);
    }

    public function changePassword(ApiMobileAuthEmployeeChangePasswordRequest $request)
    {
        $employeeJwt = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $employee = Employee::find($employeeJwt->id);

        if (!Hash::check($request->old_password, $employee->password)) {
            return response()->json([
                'code' => 422,
                'msg' => 'Error Validations',
                'error' => 'Old Password is invalid / not match'
            ], 422);
        } else {
            $employee->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'msg' => 'Password, successfully updated',
                'data' => $employee
            ], 200);
        }
    }
}
