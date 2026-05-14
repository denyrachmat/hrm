<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="employee-id">{{ __('Employee') }}</label>
            <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" id="employee-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select employee') }} --</option>
                
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ isset($attendanceRevision) && $attendanceRevision->employee_id == $employee->id ? 'selected' : (old('employee_id') == $employee->id ? 'selected' : '') }}>
                                {{ $employee->employee_id }}
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
            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ isset($attendanceRevision) && $attendanceRevision->date ? $attendanceRevision->date->format('Y-m-d') : old('date') }}" placeholder="{{ __('Date') }}" required />
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
            <input type="text" name="clock_in" id="clock-in" class="form-control @error('clock_in') is-invalid @enderror" value="{{ isset($attendanceRevision) ? $attendanceRevision->clock_in : old('clock_in') }}" placeholder="{{ __('Clock In') }}" required />
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
            <input type="text" name="clock_out" id="clock-out" class="form-control @error('clock_out') is-invalid @enderror" value="{{ isset($attendanceRevision) ? $attendanceRevision->clock_out : old('clock_out') }}" placeholder="{{ __('Clock Out') }}" required />
            @error('clock_out')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="reason">{{ __('Reason') }}</label>
            <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" placeholder="{{ __('Reason') }}" required>{{ isset($attendanceRevision) ? $attendanceRevision->reason : old('reason') }}</textarea>
            @error('reason')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>