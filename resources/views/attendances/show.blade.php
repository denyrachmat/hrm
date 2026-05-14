@extends('layouts.app')

@section('title', __('Detail of Attendances'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Attendances') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of attendance.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('attendances.index') }}">{{ __('Attendances') }}</a>
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
                                        <td>{{ $attendance->employee ? $attendance->employee->full_name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Date') }}</td>
                                        <td>{{ isset($attendance->date) ? $attendance->date->format('d/m/Y') : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Clock In') }}</td>
                                        <td>{{ isset($attendance->clock_in) ? $attendance->clock_in : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Masuk Istirahat') }}</td>
                                        <td>{{ isset($attendance->clock_istirahat) ? $attendance->clock_istirahat : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Clock Out') }}</td>
                                        <td>{{ isset($attendance->clock_out) ? $attendance->clock_out : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Latitude') }}</td>
                                        <td>{{ $attendance->latitude ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Longitude') }}</td>
                                        <td>{{ $attendance->longitude ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('File Attachment/Clock In') }}</td>
                                        <td>
                                            @if ($attendance->file_attachment == null)
                                                -
                                            @else
                                                <img src="{{ asset('storage/file-attachment/file-attachment/' . $attendance->file_attachment) }}"
                                                    alt="File Attachment" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('File Masuk Istirahat') }}</td>
                                        <td>
                                            @if ($attendance->image_istirahat == null)
                                                -
                                            @else
                                                <img src="{{ asset('storage/file-attachment/file-attachment/' . $attendance->image_istirahat) }}"
                                                    alt="File Attachment" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('File Clock Out') }}</td>
                                        <td>
                                            @if ($attendance->image_clock_out == null)
                                                -
                                            @else
                                                <img src="{{ asset('storage/file-attachment/file-attachment/' . $attendance->image_clock_out) }}"
                                                    alt="File Attachment" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Is Present') }}</td>
                                        <td>{{ $attendance->is_present }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Description') }}</td>
                                        <td>{{ $attendance->description }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Description Masuk Istirahat') }}</td>
                                        <td>{{ $attendance->description_istirahat ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Difference') }}</td>
                                        <td>{{ $attendance->selisih }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Activity') }}</td>
                                        <td>{{ $attendance->activity ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Point') }}</td>
                                        <td>{{ $attendance->point }} Point</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $attendance->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Updated at') }}</td>
                                        <td>{{ $attendance->updated_at->format('d/m/Y H:i') }}</td>
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
