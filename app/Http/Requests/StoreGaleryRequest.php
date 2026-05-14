<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGaleryRequest extends FormRequest
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
            'photo' => 'required|image|max:3000',
			'photo_category_id' => 'required|exists:App\Models\CategoryGalery,id',
			'title' => 'required|string|max:255',
			'desciption' => 'required|string|max:255',
        ];
    }
}
