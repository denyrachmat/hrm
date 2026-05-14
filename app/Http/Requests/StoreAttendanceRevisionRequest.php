<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRevisionRequest extends FormRequest
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
			'date' => 'required|date',
			'clock_in' => 'required|string|max:20',
			'clock_out' => 'required|string|max:20',
			'reason' => 'required|string',
        ];
    }
}
