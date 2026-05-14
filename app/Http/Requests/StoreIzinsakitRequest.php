<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIzinsakitRequest extends FormRequest
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
			'description' => 'required|in:Izin,Sakit',
			'detailed_description' => 'nullable|string',
			'status' => 'required|in:Waiting,Approved,Rejected',
			'file_attachment' => 'nullable|image|max:3000',
        ];
    }
}
