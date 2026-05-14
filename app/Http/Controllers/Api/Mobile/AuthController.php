<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Helpers\TokenHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiMobileLoginRequest;
use App\Mail\ResetPasswordMail;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(ApiMobileLoginRequest $request)
    {
        $employee = Employee::where('employee_id', $request->employee_id)->first();

        if (!Hash::check($request->password, $employee->password)) {
            return $this->validationError("Password incorrect");
        }

        if ($employee->work_status !== 'Active') {
            return $this->validationError("You can't login, your account is not active");
        }

        if ($employee->device_id === null) {
            $employee->update([
                'device_id' => $request->device_id,
                'token_fcm' => $request->token_fcm
            ]);
        } elseif ($employee->device_id !== $request->device_id) {
            return $this->validationError("Already logged in on another device, try contacting the admin");
        } else {
            $employee->update([
                'token_fcm' => $request->token_fcm
            ]);
        }
        $token = TokenHelper::generateJWTToken($employee->id, $employee->employee_id, $employee->email);

        return response()->json([
            'code' => 200,
            'msg'  => "You have successfully logged in",
            'data' => [
                'token' => $token
            ]
        ], 200);
    }

    private function validationError($errorMessage)
    {
        return response()->json([
            'code'  => 422,
            'msg'   => "Error Validations",
            'error' => $errorMessage,
        ], 422);
    }

    public function getCurrentAuthEmployee(Request $request)
    {
        $employeeJWT = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $employee = Employee::find($employeeJWT->id);

        if ($employee->photo) {
            $employee->photo = url('storage/employees/photo/' . $employee->photo);
        }

        return response()->json([
            'code' => 200,
            'msg'  => "Current Auth Employee",
            'data' => $employee
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Periksa apakah email terdaftar di tabel employees
        $employee = DB::table('employees')
            ->where('email', $request->email)
            ->first();

        if (!$employee) {
            // Jika email tidak terdaftar, kembalikan pesan error
            return response()->json([
                'code' => 404,
                'msg' => 'Email not registered'
            ], 200);
        }

        // Generate token reset password
        $token = md5(uniqid(rand(), true));

        // Simpan token di tabel employees
        DB::table('employees')
            ->where('email', $request->email)
            ->update(['reset_token' => $token]);

        // Kirim email reset password
        $resetLink = url('/reset-password') . '?email=' . urlencode($request->email) . '&token=' . $token;
        $data = ['resetLink' => $resetLink];

        Mail::to($request->email)->send(new ResetPasswordMail($data));

        return response()->json([
            'code' => 200,
            'msg'  => 'Password reset link has been sent',
        ], 200);
    }
}
