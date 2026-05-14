<?php

namespace App\Http\Requests;

use App\Rules\LatitudeRuleValidation;
use App\Rules\LongitudeRuleValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiMobileAttendanceClockOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'latitude' => [new LatitudeRuleValidation()],
            // 'longitude' => [new LongitudeRuleValidation()],
            'photo' => 'required|mimes:jpg,jpeg,png',
            // 'activity' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'code'  => 422,
            'msg'   => "Error Validations",
            'error' => $validator->errors()->first(),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
