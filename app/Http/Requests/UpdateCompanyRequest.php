<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'app_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|max:15',
            'logo' => 'nullable|image|max:4000',
            'email_remainder_first' => 'required|email',
            'email_remainder_second' => 'required|email',
            'start_clock_in' => 'required',
            'start_clock_out' => 'required',
            'start_clock_out' => 'required',
            'late_absence' => 'required',
        ];
    }
}
