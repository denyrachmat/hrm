<?php

namespace App\Rules;

use App\Helpers\TokenHelper;
use App\Models\Employee;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LongitudeRuleValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken(request()->bearerToken());
        $employee = Employee::find($employeeTokenObj->id);

        if (!$value && $employee->use_gps_location == 'Yes') {
            $fail(':attribute is required');
        }
    }
}
