<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiMobileLoginRequest extends FormRequest
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
            'employee_id'       => 'required|string|exists:employees,employee_id',
            'password'    => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessage = $validator->errors()->first('employee_id');

        logger('Validation failed for employee_id: ' . $this->employee_id . ' - ' . $errorMessage);

        if ($errorMessage && strpos($errorMessage, 'exists') !== false) {
            $errorMessage = 'Employee ID is not registered';
        }

        $response = new JsonResponse([
            'code'  => 422,
            'msg'   => "Error Validations",
            'error' => $errorMessage,
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
