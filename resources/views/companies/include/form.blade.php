<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="company-name">{{ __('Company Name') }}</label>
            <input type="text" name="company_name" id="company-name"
                class="form-control @error('company_name') is-invalid @enderror"
                value="{{ isset($company) ? $company->company_name : old('company_name') }}"
                placeholder="{{ __('Company Name') }}" required />
            @error('company_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="company-name">{{ __('App Name') }}</label>
            <input type="text" name="app_name" id="app-name"
                class="form-control @error('app_name') is-invalid @enderror"
                value="{{ isset($company) ? $company->app_name : old('app_name') }}" placeholder="{{ __('App Name') }}"
                required />
            @error('app_name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                placeholder="{{ __('Address') }}" required>{{ isset($company) ? $company->address : old('address') }}</textarea>
            @error('address')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">{{ __('Phone') }}</label>
            <input type="tel" name="phone" id="phone"
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ isset($company) ? $company->phone : old('phone') }}" placeholder="{{ __('Phone') }}"
                required />
            @error('phone')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    @isset($company)
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($company->logo == null)
                        <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="Logo"
                            class="rounded mb-2 mt-2" style="width: 100px" alt="Logo" style="object-fit: cover">
                    @else
                        <img style="width: 200px" src="{{ asset('storage/uploads/logos/' . $company->logo) }}"
                            alt="Logo" class="rounded mb-2 mt-2" style="object-fit: cover">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="form-group ms-3">
                        <label for="logo">{{ __('Logo') }}</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                            id="logo">

                        @error('logo')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                        <div id="logoHelpBlock" class="form-text">
                            {{ __('Leave the logo blank if you don`t want to change it.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="form-group">
                <label for="logo">{{ __('Logo') }}</label>
                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                    id="logo">

                @error('logo')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    @endisset
    <div class="col-md-6">
        <div class="form-group">
            <label for="email-remainder-one">{{ __('Email Remainder First') }}</label>
            <input type="email" name="email_remainder_first" id="email-remainder-one"
                class="form-control @error('email_remainder_first') is-invalid @enderror"
                value="{{ isset($company) ? $company->email_remainder_first : old('email_remainder_first') }}"
                placeholder="{{ __('Email Remainder First') }}" required />
            @error('email_remainder_first')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email-remainder-two">{{ __('Email Remainder Second') }}</label>
            <input type="email" name="email_remainder_second" id="email-remainder-two"
                class="form-control @error('email_remainder_second') is-invalid @enderror"
                value="{{ isset($company) ? $company->email_remainder_second : old('email_remainder_second') }}"
                placeholder="{{ __('Email Remainder Second') }}" required />
            @error('email_remainder_second')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="start_clock_in">{{ __('Start Clock In') }}</label>
            <input type="time" name="start_clock_in" id="start_clock_in"
                class="form-control @error('start_clock_in') is-invalid @enderror"
                value="{{ isset($company) ? $company->start_clock_in : old('start_clock_in') }}"
                placeholder="{{ __('Start Clock In') }}" required />
            @error('start_clock_in')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="start_clock_out">{{ __('Start Clock Out General') }}</label>
            <input type="time" name="start_clock_out" id="start_clock_out"
                class="form-control @error('start_clock_out') is-invalid @enderror"
                value="{{ isset($company) ? $company->start_clock_out : old('start_clock_out') }}"
                placeholder="{{ __('Start Clock Out') }}" required />
            @error('start_clock_out')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="start_clock_out_saturday">{{ __('Start Clock Out Saturday') }}</label>
            <input type="time" name="start_clock_out_saturday" id="start_clock_out_saturday"
                class="form-control @error('start_clock_out_saturday') is-invalid @enderror"
                value="{{ isset($company) ? $company->start_clock_out_saturday : old('start_clock_out_saturday') }}"
                placeholder="{{ __('Start Clock Out Saturday') }}" required />
            @error('start_clock_out_saturday')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>



    <div class="col-md-6">
        <div class="form-group">
            <label for="late_absence">{{ __('Late Absence') }}</label>
            <input type="number" name="late_absence" id="phone"
                class="form-control @error('late_absence') is-invalid @enderror"
                value="{{ isset($company) ? $company->late_absence : old('late_absence') }}"
                placeholder="{{ __('Late Absence') }}" required />
            @error('late_absence')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
