@extends('layouts.app')

@section('title', __('Detail of Leave Requests'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Leave Requests') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of leave request.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('leave-requests.index') }}">{{ __('Leave Requests') }}</a>
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
                                        <td class="fw-bold">{{ __('Employee') }}</td>
                                        <td>{{ $leaveRequest->employee ? $leaveRequest->employee->employee_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Start Date') }}</td>
                                        <td>{{ isset($leaveRequest->start_date) ? $leaveRequest->start_date->format('d/m/Y') : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('End Date') }}</td>
                                        <td>{{ isset($leaveRequest->end_date) ? $leaveRequest->end_date->format('d/m/Y') : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Reason') }}</td>
                                        <td>{{ $leaveRequest->reason }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('File Attachment') }}</td>
                                        <td>
                                            @if ($leaveRequest->file_attachment == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="File Attachment" class="rounded" width="200" height="150" style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/file-attachment/file-attachment/' . $leaveRequest->file_attachment) }}" alt="File Attachment" class="rounded" width="200" height="150" style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $leaveRequest->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $leaveRequest->updated_at->format('d/m/Y H:i') }}</td>
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
