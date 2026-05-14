<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ isset($news) ? $news->title : old('title') }}" placeholder="{{ __('Title') }}" required />
            @error('title')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="categorynews-id">{{ __('Categorynews') }}</label>
            <select class="form-select @error('categorynews_id') is-invalid @enderror" name="categorynews_id"
                id="categorynews-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select categorynews') }} --</option>

                @foreach ($categorynews as $categorynews)
                    <option value="{{ $categorynews->id }}"
                        {{ isset($news) && $news->categorynews_id == $categorynews->id ? 'selected' : (old('categorynews_id') == $categorynews->id ? 'selected' : '') }}>
                        {{ $categorynews->category_name }}
                    </option>
                @endforeach
            </select>
            @error('categorynews_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($news)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($news->thumbnail == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Thumbnail"
                            class="rounded mb-2 mt-2" alt="Thumbnail" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <img src="{{ asset('storage/uploads/thumbnails/' . $news->thumbnail) }}" alt="Thumbnail"
                            class="rounded mb-2 mt-2" width="200" height="150" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="thumbnail">{{ __('Thumbnail') }}</label>
                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                            id="thumbnail">

                        @error('thumbnail')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                        <div id="thumbnailHelpBlock" class="form-text">
                            {{ __('Leave the thumbnail blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="thumbnail">{{ __('Thumbnail') }}</label>
                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                    id="thumbnail" required>

                @error('thumbnail')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-id">{{ __('User') }}</label>
            <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user-id"
                class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select user') }} --</option>

                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                        {{ isset($news) && $news->user_id == $user->id ? 'selected' : (old('user_id') == $user->id ? 'selected' : '') }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
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
                value="{{ isset($news) && $news->date ? $news->date->format('Y-m-d') : old('date') }}"
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
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" id="description" class="form-control ckeditor @error('description') is-invalid @enderror" style="height: 200px;"
                placeholder="{{ __('Description') }}">{{ isset($news) ? $news->description : old('description') }}</textarea>
            @error('description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    @isset($news)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($news->file_attachment == null)
                        <img src="https://via.placeholder.com/350?text=No+File+Avaiable" alt="File Attachment"
                            class="rounded mb-2 mt-2" alt="File Attachment" width="200" height="150"
                            style="object-fit: cover">
                    @else
                        <a href="{{ asset('storage/uploads/file_attachments/' . $news->file_attachment) }}"
                            target="_blank"> <img src="https://cdn-icons-png.flaticon.com/512/1091/1091169.png"
                                alt="File Attachment" width="130" height="130"
                                style="object-fit: cover">
                        </a>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="file_attachment">{{ __('File Attachment') }}</label>
                        <input type="file" name="file_attachment"
                            class="form-control @error('file_attachment') is-invalid @enderror" id="file_attachment">

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
                <input type="file" name="file_attachment"
                    class="form-control @error('file_attachment') is-invalid @enderror" id="file_attachment">
                <div id="passwordHelpBlock" class="form-text">
                    {{ __('Note : (Optional)') }}
                </div>
                @error('file_attachment')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
</div>
