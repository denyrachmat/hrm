@extends('layouts.app')

@section('title', __('Detail of News'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('News') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of news.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('news.index') }}">{{ __('News') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('Title') }}</td>
                                        <td>{{ $news->title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Categorynews') }}</td>
                                        <td>{{ $news->categorynews ? $news->categorynews->created_at : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Thumbnail') }}</td>
                                        <td>
                                            @if ($news->thumbnail == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                    alt="Thumbnail" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/thumbnails/' . $news->thumbnail) }}"
                                                    alt="Thumbnail" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('User') }}</td>
                                        <td>{{ $news->user ? $news->user->created_at : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Date') }}</td>
                                        <td>{{ isset($news->date) ? $news->date->format('d/m/Y') : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Description') }}</td>
                                        <td>{!! $news->description !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('File Attachment') }}</td>
                                        <td>
                                            @if ($news->file_attachment == null)
                                                <p>No file attachment available</p>
                                            @else
                                                <a href="{{ asset('storage/uploads/file_attachments/' . $news->file_attachment) }}" target="_blank">
                                                    <i class="bi bi-folder-fill"></i> View File Attachment
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $news->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $news->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
