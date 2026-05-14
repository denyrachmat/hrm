<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');
        return view('employees.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.required' => 'The password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters long.',
        ]);

        $isValidToken = DB::table('employees')
            ->where('reset_token', $request->token)
            ->where('email', $request->email)
            ->exists();

        if (!$isValidToken) {
            return redirect()->back()->with('error', 'Invalid token. Please send the password reset link again from the mobile app.');
        }

        $password = Hash::make($request->password);
        DB::table('employees')
            ->where('reset_token', $request->token)
            ->update(['password' => $password, 'reset_token' => null]);
        return redirect()->route('password-reset-success');
    }

    public function successReset()
    {
        return view('employees.password-reset-success');
    }
}
