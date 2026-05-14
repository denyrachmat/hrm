<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($branchOffice) ? $branchOffice->name : old('name') }}" placeholder="{{ __('Name') }}" required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="location">{{ __('Location') }}</label>
            <textarea name="location" id="location" class="form-control @error('location') is-invalid @enderror" placeholder="{{ __('Location') }}" required>{{ isset($branchOffice) ? $branchOffice->location : old('location') }}</textarea>
            @error('location')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>