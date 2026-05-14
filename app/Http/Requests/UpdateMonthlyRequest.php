<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonthlyRequest extends FormRequest
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
            'daily_salary' => 'required|numeric',
            'craft_incentives' => 'required|numeric',
        ];
    }
}
