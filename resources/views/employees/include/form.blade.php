<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="employee-id">{{ __('Employee Id') }}</label>
            <input type="text" name="employee_id" id="employee-id" class="form-control @error('employee_id') is-invalid @enderror" value="{{ isset($employee) ? $employee->employee_id : old('employee_id') }}" placeholder="{{ __('Employee Id') }}" required />
            @error('employee_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="full-name">{{ __('Full Name') }}</label>
            <input type="text" name="full_name" id="full-name" class="form-control @error('full_name') is-invalid @enderror" value="{{ isset($employee) ? $employee->full_name : old('full_name') }}" placeholder="{{ __('Full Name') }}" required />
            @error('full_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ isset($employee) ? $employee->email : old('email') }}" placeholder="{{ __('Email') }}" required />
            @error('email')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="gender">{{ __('Gender') }}</label>
            <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender" class="form-control">
                <option value="" selected disabled>-- {{ __('Select gender') }} --</option>
                <option value="Male" {{ isset($employee) && $employee->gender == 'Male' ? 'selected' : (old('gender') == 'Male' ? 'selected' : '') }}>
                    Male</option>
                <option value="Female" {{ isset($employee) && $employee->gender == 'Female' ? 'selected' : (old('gender') == 'Female' ? 'selected' : '') }}>
                    Female</option>
            </select>
            @error('gender')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="date-of-birth">{{ __('Date Of Birth') }}</label>
            <input type="date" name="date_of_birth" id="date-of-birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ isset($employee) && $employee->date_of_birth ? $employee->date_of_birth->format('Y-m-d') : old('date_of_birth') }}" placeholder="{{ __('Date Of Birth') }}" />
            @error('date_of_birth')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="martial-status">{{ __('Martial Status') }}</label>
            <select class="form-select @error('martial_status') is-invalid @enderror" name="martial_status" id="martial-status" class="form-control">
                <option value="" selected disabled>-- {{ __('Select martial status') }} --</option>
                <option value="Single" {{ isset($employee) && $employee->martial_status == 'Single' ? 'selected' : (old('martial_status') == 'Single' ? 'selected' : '') }}>
                    Single</option>
                <option value="Married" {{ isset($employee) && $employee->martial_status == 'Married' ? 'selected' : (old('martial_status') == 'Married' ? 'selected' : '') }}>
                    Married</option>
                <option value="Divorced" {{ isset($employee) && $employee->martial_status == 'Divorced' ? 'selected' : (old('martial_status') == 'Divorced' ? 'selected' : '') }}>
                    Divorced</option>
                <option value="Widowed" {{ isset($employee) && $employee->martial_status == 'Widowed' ? 'selected' : (old('martial_status') == 'Widowed' ? 'selected' : '') }}>
                    Widowed</option>
            </select>
            @error('martial_status')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="id-type">{{ __('Id Type') }}</label>
            <select class="form-select @error('id_type') is-invalid @enderror" name="id_type" id="id-type" class="form-control">
                <option value="" selected disabled>-- {{ __('Select id type') }} --</option>
                <option value="KTP" {{ isset($employee) && $employee->id_type == 'KTP' ? 'selected' : (old('id_type') == 'KTP' ? 'selected' : '') }}>
                    KTP</option>
            </select>
            @error('id_type')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="national-id-no">{{ __('National Id No') }}</label>
            <input type="text" name="national_id_no" id="national-id-no" class="form-control @error('national_id_no') is-invalid @enderror" value="{{ isset($employee) ? $employee->national_id_no : old('national_id_no') }}" placeholder="{{ __('National Id No') }}" />
            @error('national_id_no')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="start-contract-date">{{ __('Start Contract Date') }}</label>
            <input type="date" name="start_contract_date" id="start-contract-date" class="form-control @error('start_contract_date') is-invalid @enderror" value="{{ isset($employee) && $employee->start_contract_date ? $employee->start_contract_date->format('Y-m-d') : old('start_contract_date') }}" placeholder="{{ __('Start Contract Date') }}" />
            @error('start_contract_date')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end-contract-date">{{ __('End Contract Date') }}</label>
            <input type="date" name="end_contract_date" id="end-contract-date" class="form-control @error('end_contract_date') is-invalid @enderror" value="{{ isset($employee) && $employee->end_contract_date ? $employee->end_contract_date->format('Y-m-d') : old('end_contract_date') }}" placeholder="{{ __('End Contract Date') }}" />
            @error('end_contract_date')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="job-position">{{ __('Job Position') }}</label>
            <input type="text" name="job_position" id="job-position" class="form-control @error('job_position') is-invalid @enderror" value="{{ isset($employee) ? $employee->job_position : old('job_position') }}" placeholder="{{ __('Job Position') }}" />
            @error('job_position')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="branch_office_id">{{ __('Branch Office') }}</label>
            <select class="form-select @error('branch_office_id') is-invalid @enderror" name="branch_office_id" id="branch_office_id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select Branch Office') }} --</option>
                @foreach ($branch as $row)
                    <option value="{{ $row->id }}" {{ isset($employee) && $employee->branch_office_id == $row->id ? 'selected' : (old('branch_office_id') == $row->id ? 'selected' : '') }}>
                        {{ $row->name }}
                    </option>
                @endforeach
            </select>
            @error('branch_office_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="department-id">{{ __('Department') }}</label>
            <select class="form-select @error('department_id') is-invalid @enderror" name="department_id" id="department-id" class="form-control" required onchange="listenChangedSelectDepartment(this)">
                <option value="" selected disabled>-- {{ __('Select department') }} --</option>
                @foreach ($arr_departments as $department)
                    <option value="{{ $department->id }}" data-code="{{ $department->code }}" data-default_payroll_type="{{ $department->default_payroll_type }}" {{ isset($employee) && $employee->department_id == $department->id ? 'selected' : (old('department_id') == $department->id ? 'selected' : '') }}>
                        {{ $department->department_name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="bpjs-tk-no">{{ __('Bpjs Tk No') }}</label>
            <input type="text" name="bpjs_tk_no" id="bpjs-tk-no" class="form-control @error('bpjs_tk_no') is-invalid @enderror" value="{{ isset($employee) ? $employee->bpjs_tk_no : old('bpjs_tk_no') }}" placeholder="{{ __('Bpjs Tk No') }}" />
            @error('bpjs_tk_no')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bpjs-health-no">{{ __('Bpjs Health No') }}</label>
            <input type="text" name="bpjs_health_no" id="bpjs-health-no" class="form-control @error('bpjs_health_no') is-invalid @enderror" value="{{ isset($employee) ? $employee->bpjs_health_no : old('bpjs_health_no') }}" placeholder="{{ __('Bpjs Health No') }}" />
            @error('bpjs_health_no')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tax_id">{{ __('Tax ID') }}</label>
            <input type="text" name="tax_id" id="tax_id" class="form-control @error('tax_id') is-invalid @enderror" value="{{ isset($employee) ? $employee->tax_id : old('tax_id') }}" placeholder="{{ __('Tax ID') }}" />
            @error('tax_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="medical-insurance">{{ __('Medical Insurance') }}</label>
            <input type="text" name="medical_insurance" id="medical-insurance" class="form-control @error('medical_insurance') is-invalid @enderror" value="{{ isset($employee) ? $employee->medical_insurance : old('medical_insurance') }}" placeholder="{{ __('Medical Insurance') }}" />
            @error('medical_insurance')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="work-status">{{ __('Work Status') }}</label>
            <select class="form-select @error('work_status') is-invalid @enderror" name="work_status" id="work-status" class="form-control">
                <option value="" selected disabled>-- {{ __('Select work status') }} --</option>
                <option value="Active" {{ isset($employee) && $employee->work_status == 'Active' ? 'selected' : (old('work_status') == 'Active' ? 'selected' : '') }}>
                    Active</option>
                <option value="Non Active" {{ isset($employee) && $employee->work_status == 'Non Active' ? 'selected' : (old('work_status') == 'Non Active' ? 'selected' : '') }}>
                    Non Active</option>
            </select>
            @error('work_status')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="currency">{{ __('Currency') }}</label>
            <select class="form-select @error('currency') is-invalid @enderror" name="currency" id="currency" class="form-control">
                <option value="" selected disabled>-- {{ __('Select currency') }} --</option>
                <option value="IDR" {{ isset($employee) && $employee->currency == 'IDR' ? 'selected' : (old('currency') == 'IDR' ? 'selected' : '') }}>
                    IDR</option>
                <option value="USD" {{ isset($employee) && $employee->currency == 'USD' ? 'selected' : (old('currency') == 'USD' ? 'selected' : '') }}>
                    USD</option>
            </select>
            @error('currency')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ isset($employee) ? $employee->address : old('address') }}" placeholder="{{ __('Address') }}" />
            @error('address')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>



    <div class="col-md-3">
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" {{ empty($employee) ? 'required' : '' }}>
            @error('password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
            @isset($employee)
                <div id="passwordHelpBlock" class="form-text">
                    {{ __('Leave the password & password confirmation blank if you don`t want to change them.') }}
                </div>
            @endisset
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="password-confirmation">{{ __('Password Confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password-confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" {{ empty($employee) ? 'required' : '' }}>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="photo">{{ __('Photo') }}</label>
            <input type="file" accept="image/*" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror">
            @error('photo')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="meal_allowance">{{ __('Meal Allowance/Day') }}</label>
            <input type="number" name="meal_allowance" id="meal_allowance" class="form-control @error('meal_allowance') is-invalid @enderror" @if (old('meal_allowance')) {{ old('meal_allowance') == '5' ? 'disabled' : '' }}
            @else
                @if (isset($employee))
                    {{ $employee->meal_allowance == '5' ? 'disabled' : '' }} @endif @endif

            value="{{ isset($employee) ? $employee->meal_allowance : old('meal_allowance') }}" placeholder="{{ __('Meal Allowance/Day') }}" />
            @error('meal_allowance')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="use_gps_location">{{ __('Use GPS Location') }}</label>
            <select class="form-select mb-3 @error('use_gps_location') is-invalid @enderror" name="use_gps_location" id="use_gps_location" class="form-control">
                <option value="" selected disabled>-- {{ __('Select martial status') }} --</option>
                <option value="Yes" {{ isset($employee) && $employee->use_gps_location == 'Yes' ? 'selected' : (old('use_gps_location') == 'Yes' ? 'selected' : '') }}>
                    Yes</option>
                <option value="No" {{ isset($employee) && $employee->use_gps_location == 'No' ? 'selected' : (old('use_gps_location') == 'No' ? 'selected' : '') }}>
                    No</option>
            </select>
            @error('use_gps_location')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
            <div class="card" style="border: 2px solid #3490dc;">
                <div class="card-body">
                    <div class="row">
                        @foreach ($gpslocations as $row)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="location_id[]" value="{{ $row->id }}" {{ isset($employee) && in_array($row->id, $locationIds) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="use_gps_location">{{ $row->gpc_location_name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="payroll_type">{{ __('Payroll Type') }}</label>
            <select class="form-select @error('payroll_type') is-invalid @enderror" name="payroll_type" id="payroll_type" class="form-control" required onchange="listenChangedPayrollType(this)">
                <option value="" selected disabled>-- {{ __('Select Payroll Type') }} --</option>
                @foreach ($availablePayrollTypes as $row)
                    <option value="{{ $row }}" {{ isset($employee) && $employee->payroll_type == $row ? 'selected' : (old('payroll_type') == $row ? 'selected' : '') }}>
                        {{ ucwords(join(' ', explode('_', $row))) }}
                    </option>
                @endforeach
            </select>
            @error('payroll_type')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group

        @if (old('payroll_type') == 'monthly' || old('payroll_type') == 'monthly_and_daily') @else
            @if (isset($employee))
            {{ $employee->payroll_type == 'monthly' || $employee->payroll_type == 'monthly_and_daily' ? '' : 'd-none' }}
                @else
                d-none @endif
        @endif

        " id="form-group-payroll_type-monthly">
            <label for="salary">{{ __('Monthly Salary') }}</label>
            <input type="number" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ isset($employee) ? $employee->salary : old('salary') }}" placeholder="{{ __('Monthly Salary') }}" />
            @error('salary')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group
        @if (old('payroll_type') == 'daily' || old('payroll_type') == 'monthly_and_daily') @else
            @if (isset($employee))
            {{ $employee->payroll_type == 'daily' || $employee->payroll_type == 'monthly_and_daily' ? '' : 'd-none' }}
                @else
                d-none @endif
        @endif
        " id="form-group-payroll_type-daily">
            <label for="daily_salary">{{ __('Daily Salary') }}</label>
            <input type="number" name="daily_salary" id="daily_salary" class="form-control @error('daily_salary') is-invalid @enderror" value="{{ isset($employee) ? $employee->daily_salary : old('daily_salary') }}" placeholder="{{ __('Daily Salary') }}" />
            @error('daily_salary')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror

            <div class="form-group mt-2">
                <label for="craft_incentives">{{ __('Craft Incentives') }}</label>
                <input type="number" name="craft_incentives" id="craft_incentives" class="form-control @error('craft_incentives') is-invalid @enderror" value="{{ isset($employee) ? $employee->craft_incentives : old('craft_incentives') }}" placeholder="{{ __('Craft Incentives') }}" />
                @error('craft_incentives')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="bank_id">{{ __('Bank') }}</label>
            <select class="form-select @error('bank_id') is-invalid @enderror" name="bank_id" id="bank_id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select bank') }} --</option>
                @foreach ($banks as $row)
                    <option value="{{ $row->id }}" {{ isset($employee) && $employee->bank_id == $row->id ? 'selected' : (old('bank_id') == $row->id ? 'selected' : '') }}>
                        {{ $row->name }}
                    </option>
                @endforeach
            </select>
            @error('bank_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="bank-account-name">{{ __('Bank Account Name') }}</label>
            <input type="text" name="bank_account_name" id="bank-account-name" class="form-control @error('bank_account_name') is-invalid @enderror" value="{{ isset($employee) ? $employee->bank_account_name : old('bank_account_name') }}" placeholder="{{ __('Bank Account Name') }}" />
            @error('bank_account_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="bank-account-number">{{ __('Bank Account Number') }}</label>
            <input type="number" name="bank_account_number" id="bank-account-number" class="form-control @error('bank_account_number') is-invalid @enderror" value="{{ isset($employee) ? $employee->bank_account_number : old('bank_account_number') }}" placeholder="{{ __('Bank Account Number') }}" />
            @error('bank_account_number')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

@push('js')
    <script>
        function listenChangedPayrollType(selectPayrollTypeElement) {
            const selectedPayrollType = selectPayrollTypeElement.value
            const availablePayrollTypes = ['monthly', 'daily', 'monthly_and_daily'];

            availablePayrollTypes.forEach((availablePayrollType) => {
                const elementFormGroupSalaryByPayrollTypeElement = document.getElementById('form-group-payroll_type-' + availablePayrollType);

                if (elementFormGroupSalaryByPayrollTypeElement) {
                    !elementFormGroupSalaryByPayrollTypeElement.classList.contains('d-none') ? elementFormGroupSalaryByPayrollTypeElement.classList.add('d-none') : ''

                    if (selectedPayrollType == 'monthly_and_daily') {
                        availablePayrollTypes.forEach((e) => {
                            if (document.getElementById('form-group-payroll_type-' + e)) {
                                document.getElementById('form-group-payroll_type-' + e).classList.remove('d-none')
                            }
                        })
                    } else if (availablePayrollType == selectedPayrollType) {
                        elementFormGroupSalaryByPayrollTypeElement.classList.remove('d-none')
                    }
                }
            })
        }

        function listenChangedSelectDepartment(selectBranchElement) {

            /**
             * Dynamic Payroll
             *
             */
            const selectedPayrollTypeValue = selectBranchElement.options[selectBranchElement.selectedIndex].getAttribute('data-default_payroll_type')
            const selectPayrollTypeElement = document.getElementById('payroll_type')
            selectPayrollTypeElement.value = selectedPayrollTypeValue
            listenChangedPayrollType(selectPayrollTypeElement)

            /**
             * Dynamic Meal Allowance
             *
             */
            // const selectedDepartmentCodeValue = selectBranchElement.options[selectBranchElement.selectedIndex].getAttribute('data-code')
            // const inputMealAllowanceElement = document.getElementById('meal_allowance')

            // // DEP-005 == Genset
            // if (selectedDepartmentCodeValue == 'DEP-005') {
            //     inputMealAllowanceElement.value = ''
            //     inputMealAllowanceElement.setAttribute('disabled', true)
            // } else {
            //     inputMealAllowanceElement.removeAttribute('disabled')
            // }
        }
    </script>
@endpush
