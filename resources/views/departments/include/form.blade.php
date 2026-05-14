<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="code">{{ __('Code') }}</label>
            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ isset($department) ? $department->code : old('code') }}" placeholder="{{ __('Department Name') }}" required readonly />
            @error('code')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="department-name">{{ __('Department Name') }}</label>
            <input type="text" name="department_name" id="department-name" class="form-control @error('department_name') is-invalid @enderror" value="{{ isset($department) ? $department->department_name : old('department_name') }}" placeholder="{{ __('Department Name') }}" required readonly />
            @error('department_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="default-payroll-type">{{ __('Default Payroll Type') }}</label>
            <select class="form-select @error('default_payroll_type') is-invalid @enderror" name="default_payroll_type" id="default-payroll-type" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select Payroll Type') }} --</option>
                @foreach ($availablePayrollTypes as $row)
                    <option value="{{ $row }}" {{ isset($department) && $department->default_payroll_type == $row ? 'selected' : (old('default_payroll_type') == $row ? 'selected' : '') }}>
                        {{ ucfirst($row) }}
                    </option>
                @endforeach
            </select>
            @error('default_payroll_type')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
