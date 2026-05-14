<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="employee-id">{{ __('Employee') }}</label>
            <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" id="employee-id"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select employee') }} --</option>

                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}"
                        {{ isset($attendance) && $attendance->employee_id == $employee->id ? 'selected' : (old('employee_id') == $employee->id ? 'selected' : '') }}>
                        {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="date">{{ __('Date') }}</label>
            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                value="{{ isset($attendance) && $attendance->date ? $attendance->date->format('Y-m-d') : old('date') }}"
                placeholder="{{ __('Date') }}" required />
            @error('date')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="clock-in">{{ __('Clock In') }}</label>
            <input type="time" name="clock_in" id="clock-in"
                class="form-control @error('clock_in') is-invalid @enderror"
                value="{{ isset($attendance) && $attendance->clock_in ? $attendance->clock_in->format('Y-m-d\TH:i') : old('clock_in') }}"
                placeholder="{{ __('Clock In') }}" />
            @error('clock_in')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="clock-out">{{ __('Clock Out') }}</label>
            <input type="time" name="clock_out" id="clock-out"
                class="form-control @error('clock_out') is-invalid @enderror"
                value="{{ isset($attendance) && $attendance->clock_out ? $attendance->clock_out->format('Y-m-d\TH:i') : old('clock_out') }}"
                placeholder="{{ __('Clock Out') }}" />
            @error('clock_out')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="is-present">{{ __('Is Present') }}</label>
            <select class="form-select @error('is_present') is-invalid @enderror" name="is_present" id="is-present"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select is present') }} --</option>
                <option value="Yes"
                    {{ isset($attendance) && $attendance->is_present == 'Yes' ? 'selected' : (old('is_present') == 'Yes' ? 'selected' : '') }}>
                    Yes</option>
                <option value="No"
                    {{ isset($attendance) && $attendance->is_present == 'No' ? 'selected' : (old('is_present') == 'No' ? 'selected' : '') }}>
                    No</option>
            </select>
            @error('is_present')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <select class="form-select @error('description') is-invalid @enderror" name="description" id="description"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select description') }} --</option>
                <option value="Tepat Waktu"
                    {{ isset($attendance) && $attendance->description == 'Tepat Waktu' ? 'selected' : (old('description') == 'Tepat Waktu' ? 'selected' : '') }}>
                    Tepat Waktu</option>
                <option value="Terlambat"
                    {{ isset($attendance) && $attendance->description == 'Terlambat' ? 'selected' : (old('description') == 'Terlambat' ? 'selected' : '') }}>
                    Terlambat</option>
                <option value="Izin"
                    {{ isset($attendance) && $attendance->description == 'Izin' ? 'selected' : (old('description') == 'Izin' ? 'selected' : '') }}>
                    Izin</option>
                <option value="Sakit"
                    {{ isset($attendance) && $attendance->description == 'Sakit' ? 'selected' : (old('description') == 'Sakit' ? 'selected' : '') }}>
                    Sakit</option>
            </select>
            @error('description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
