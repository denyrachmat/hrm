<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="employee-id">{{ __('Employee') }}</label>
            <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" id="employee-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select employee') }} --</option>

                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ isset($izinsakit) && $izinsakit->employee_id == $employee->id ? 'selected' : (old('employee_id') == $employee->id ? 'selected' : '') }}>
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
            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ isset($izinsakit) && $izinsakit->date ? $izinsakit->date->format('Y-m-d') : old('date') }}" placeholder="{{ __('Date') }}" required />
            @error('date')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <select class="form-select @error('description') is-invalid @enderror" name="description" id="description" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select description') }} --</option>
                <option value="Izin" {{ isset($izinsakit) && $izinsakit->description == 'Izin' ? 'selected' : (old('description') == 'Izin' ? 'selected' : '') }}>Izin</option>
		<option value="Sakit" {{ isset($izinsakit) && $izinsakit->description == 'Sakit' ? 'selected' : (old('description') == 'Sakit' ? 'selected' : '') }}>Sakit</option>
            </select>
            @error('description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="detailed-description">{{ __('Detailed Description') }}</label>
            <textarea name="detailed_description" id="detailed-description" class="form-control @error('detailed_description') is-invalid @enderror" placeholder="{{ __('Detailed Description') }}">{{ isset($izinsakit) ? $izinsakit->detailed_description : old('detailed_description') }}</textarea>
            @error('detailed_description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">{{ __('Status') }}</label>
            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select status') }} --</option>
                <option value="Waiting" {{ isset($izinsakit) && $izinsakit->status == 'Waiting' ? 'selected' : (old('status') == 'Waiting' ? 'selected' : '') }}>Waiting</option>
		<option value="Approved" {{ isset($izinsakit) && $izinsakit->status == 'Approved' ? 'selected' : (old('status') == 'Approved' ? 'selected' : '') }}>Approved</option>
		<option value="Rejected" {{ isset($izinsakit) && $izinsakit->status == 'Rejected' ? 'selected' : (old('status') == 'Rejected' ? 'selected' : '') }}>Rejected</option>
            </select>
            @error('status')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($izinsakit)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($izinsakit->file_attachment == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="File Attachment" class="rounded mb-2 mt-2" alt="File Attachment" width="200" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/file_attachments/' . $izinsakit->file_attachment) }}" alt="File Attachment" class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
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
                <input type="file" name="file_attachment" class="form-control @error('file_attachment') is-invalid @enderror" id="file_attachment">

                @error('file_attachment')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
</div>
