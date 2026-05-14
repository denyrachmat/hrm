<div class="row mb-2">
    @isset($banner)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($banner->image == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Image" class="rounded mb-2 mt-2" alt="Image" width="200" height="150" style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/images/' . $banner->image) }}" alt="Image" class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="image">{{ __('Image') }}</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image">

                        @error('image')
                          <span class="text-danger">
                                {{ $message }}
                           </span>
                        @enderror
                        <div id="imageHelpBlock" class="form-text">
                            {{ __('Leave the image blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="image">{{ __('Image') }}</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" required>

                @error('image')
                   <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="position">{{ __('Position') }}</label>
            <input type="number" name="position" id="position" class="form-control @error('position') is-invalid @enderror" value="{{ isset($banner) ? $banner->position : old('position') }}" placeholder="{{ __('Position') }}" required />
            @error('position')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>