<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonthlyRequest extends FormRequest
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
            'employee_id' => 'required|exists:App\Models\Employee,id',
			'period' => 'required',
			'salary' => 'required|numeric',
			'bpjs_jht_earnings' => 'required|numeric',
			'bpjs_jkk_earnings' => 'required|numeric',
			'bpjs_jp_earnings' => 'required|numeric',
			'bpjs_healt_earnings' => 'required|numeric',
            'medical_insurance_earnings' => 'required|numeric',
			'transport_earnings' => 'required|numeric',
			'reward_earnings' => 'required|numeric',
			'overtime_earnings' => 'required|numeric',
			'balance_earnings' => 'required|numeric',
			'bpjs_jht_deductions' => 'required|numeric',
			'bpjs_jkk_jkm_deductions' => 'required|numeric',
			'bpjs_jp_deductions' => 'required|numeric',
			'bpjs_healt_deductions' => 'required|numeric',
            'insurance_deductions' => 'required|numeric',
			'other_deduction' => 'required|numeric',
            'pph' => 'required|numeric',
        ];
    }
}
