<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
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
			'clock_in' => 'nullable',
			'clock_out' => 'nullable',
			'latitude' => 'nullable|string|max:255',
			'longitude' => 'nullable|string|max:255',
			'file_attachment' => 'nullable|image|max:3000',
			'is_present' => 'required|in:Yes,No',
			'description' => 'required|in:Tepat Waktu,Terlambat,Izin,Sakit',
        ];
    }
}
