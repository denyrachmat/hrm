<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'title' => 'required|string|max:255',
			'categorynews_id' => 'required|exists:App\Models\Categorynews,id',
			'thumbnail' => 'required|image|max:3000',
			'user_id' => 'required|exists:App\Models\User,id',
			'date' => 'required|date',
			'description' => 'required|string',
			'file_attachment' => 'nullable|max:5000',
        ];
    }
}
