<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="employee-id">{{ __('Employee') }}</label>
            <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" id="employee-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select employee') }} --</option>
                
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ isset($leaveRequest) && $leaveRequest->employee_id == $employee->id ? 'selected' : (old('employee_id') == $employee->id ? 'selected' : '') }}>
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
            <label for="start-date">{{ __('Start Date') }}</label>
            <input type="date" name="start_date" id="start-date" class="form-control @error('start_date') is-invalid @enderror" value="{{ isset($leaveRequest) && $leaveRequest->start_date ? $leaveRequest->start_date->format('Y-m-d') : old('start_date') }}" placeholder="{{ __('Start Date') }}" required />
            @error('start_date')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end-date">{{ __('End Date') }}</label>
            <input type="date" name="end_date" id="end-date" class="form-control @error('end_date') is-invalid @enderror" value="{{ isset($leaveRequest) && $leaveRequest->end_date ? $leaveRequest->end_date->format('Y-m-d') : old('end_date') }}" placeholder="{{ __('End Date') }}" required />
            @error('end_date')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="reason">{{ __('Reason') }}</label>
            <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" placeholder="{{ __('Reason') }}" required>{{ isset($leaveRequest) ? $leaveRequest->reason : old('reason') }}</textarea>
            @error('reason')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($leaveRequest)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($leaveRequest->file_attachment == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="File Attachment" class="rounded mb-2 mt-2" alt="File Attachment" width="200" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/file_attachments/' . $leaveRequest->file_attachment) }}" alt="File Attachment" class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="file_attachment">{{ __('File Attachment') }}</label>
                        <input type="file" name="file_attachment" class="form-control @error('file_attachment') is-invalid @enderror" id="file_attachment">

                        @error('file_attachment')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="file_attachmentHelpBlock" class="form-text">
                            {{ __('Leave the file attachment blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="file_attachment">{{ __('File Attachment') }}</label>
                <input type="file" name="file_attachment" class="form-control @error('file_attachment') is-invalid @enderror" id="file_attachment" required>

                @error('file_attachment')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
</div>