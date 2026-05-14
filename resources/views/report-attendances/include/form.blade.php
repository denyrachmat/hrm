<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group">
            <label for="departenment-id">{{ __('Department') }}</label>
            <select class="form-select @error('departenment_id') is-invalid @enderror" name="departenment_id"
                id="departenment-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select department') }} --</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ isset($reportAttendance) && $reportAttendance->departenment_id == $department->id ? 'selected' : (old('departenment_id') == $department->id ? 'selected' : '') }}>
                        {{ $department->department_name }}
                    </option>
                @endforeach
            </select>
            @error('departenment_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="month">{{ __('Month') }}</label>
            <input type="month" name="month" id="month"
                class="form-control @error('month') is-invalid @enderror"
                value="{{ isset($reportAttendance) && $reportAttendance->month ? $reportAttendance->month->format('Y-m') : old('month') }}"
                placeholder="{{ __('Month') }}" required />
            @error('month')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
