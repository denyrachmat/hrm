<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required|string|max:255|unique:employees,employee_id,' . $this->employee->id,
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'martial_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'id_type' => 'nullable|in:KTP',
            'national_id_no' => 'nullable|string|max:255',
            'start_contract_date' => 'nullable|date',
            'end_contract_date' => 'nullable|date',
            'job_position' => 'nullable|string|max:255',
            'branch_office_id' => 'required',
            'bpjs_tk_no' => 'nullable|string|max:255',
            'bpjs_health_no' => 'nullable|string|max:255',
            'medical_insurance' => 'nullable|string|max:255',
            'work_status' => 'nullable|in:Active,Non Active',
            'currency' => 'nullable|in:IDR,USD',
            'address' => 'nullable|string|max:255',
            'department_id' => 'required|exists:App\Models\Department,id',
            'email' => 'nullable|email|unique:employees,email,' . $this->employee->id,
            'tax_id' => 'nullable|string|max:255',
            'use_gps_location' => 'nullable|in:Yes,No',
            'password' =>  [
                'nullable',
                'confirmed',
                Password::min(8)
            ],
            'photo' => 'nullable|mimes:jpg,jpeg,png',
            'bank_id' => 'required|exists:banks,id',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|digits_between:2,50',
            'payroll_type' => 'required|in:monthly,daily,monthly_and_daily',
            'salary' => [function ($attribute, $value, $fail) {
                if ((request()->payroll_type == 'monthly_and_daily' || request()->payroll_type == 'monthly') && !is_numeric($value)) {
                    if (!$value) {
                        $fail('Err Validation');
                    }
                }
            }],
            'daily_salary' => [function ($attribute, $value, $fail) {
                if ((request()->payroll_type == 'monthly_and_daily' || request()->payroll_type == 'daily') && !is_numeric($value)) {
                    if (!$value) {
                        $fail('Err Validation');
                    }
                }
            }],
            'craft_incentives' => [function ($attribute, $value, $fail) {
                if ((request()->payroll_type == 'monthly_and_daily' || request()->payroll_type == 'daily') && !is_numeric($value)) {
                    if (!$value) {
                        $fail('Err Validation');
                    }
                }
            }],
            'meal_allowance' => [function ($attribute, $value, $fail) {
                // Not Genset
                if (request()->department_id != '5') {
                    if (!$value || !is_numeric($value)) {
                        $fail('Err Validation');
                    }
                }
            }]
        ];
    }
}
