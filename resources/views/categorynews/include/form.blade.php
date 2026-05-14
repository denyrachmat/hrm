<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="category-name">{{ __('Category Name') }}</label>
            <input type="text" name="category_name" id="category-name" class="form-control @error('category_name') is-invalid @enderror" value="{{ isset($categorynews) ? $categorynews->category_name : old('category_name') }}" placeholder="{{ __('Category Name') }}" required />
            @error('category_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>