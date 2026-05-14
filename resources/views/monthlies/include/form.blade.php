<div class="row mb-2">
    <input type="hidden" value="{{ $monthly->employee_id }}" name="employee_id">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">{{ __('Employee Name') }}</label>
            <input readonly type="text" name="" id="" class="form-control" value="{{ getNameEmployee($monthly->employee_id)->full_name }}" placeholder="" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="period">{{ __('Period') }}</label>
            <input readonly type="month" name="period" id="period" class="form-control @error('period') is-invalid @enderror" value="{{ isset($monthly) && $monthly->period ? $monthly->period : old('period') }}" placeholder="{{ __('Period') }}" required />
            @error('period')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="payroll_type">{{ __('Payroll Type') }}</label>
            <input readonly type="text" name="payroll_type" id="payroll_type" class="form-control" value="{{ $monthly->payroll_type }}" placeholder="" required readonly />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="currency">{{ __('Currency') }}</label>
            <input readonly type="text" name="currency" id="currency" class="form-control" value="{{ $monthly->currency }}" placeholder="" required readonly />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="salary">{{ __('Salary') }}</label>
            <input type="number" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ isset($monthly) ? $monthly->salary : old('salary') }}" placeholder="{{ __('Salary') }}" required />
            @error('salary')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="daily_salary">{{ __('Daily Salary') }}</label>
            <input type="number" name="daily_salary" id="daily_salary" class="form-control @error('daily_salary') is-invalid @enderror" value="{{ isset($monthly) ? $monthly->daily_salary : old('daily_salary') }}" placeholder="{{ __('Daily Salary') }}" required />
            @error('daily_salary')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="craft_incentives">{{ __('Craft Incentives') }}</label>
            <input type="number" name="craft_incentives" id="craft_incentives" class="form-control @error('craft_incentives') is-invalid @enderror" value="{{ isset($monthly) ? $monthly->craft_incentives : old('craft_incentives') }}" placeholder="{{ __('Craft Incentives') }}" required />
            @error('craft_incentives')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

</div>
