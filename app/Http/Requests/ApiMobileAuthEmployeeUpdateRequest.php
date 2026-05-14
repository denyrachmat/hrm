<?php

namespace App\Http\Requests;

use App\Helpers\TokenHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiMobileAuthEmployeeUpdateRequest extends FormRequest
{
    private $employee;

    public function __construct()
    {
        $employee = TokenHelper::decodeJWTBearerToken(request()->bearerToken());

        $this->employee = $employee;
    }

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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email,' . $this->employee->id,
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|mimes:jpg,jpeg,png'
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
