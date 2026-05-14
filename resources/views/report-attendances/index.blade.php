@extends('layouts.app')

@section('title', __('Report'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Report Attendances') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('For generate Report Attendances') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('report-attendances.index') }}">{{ __('Report Attendances') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Create') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('report-attendances.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('report-attendances.include.form')
                                <button type="submit" class="btn btn-primary">{{ __('Generate Report') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
