<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="description">{{ __('Employee Name') }}</label>
            <input readonly type="text" name="description" id="description"
                class="form-control @error('description') is-invalid @enderror"
                value="{{ isset($employee) ? $employee->full_name : old('full_name') }}"
                placeholder="{{ __('Full Name') }}" required />
            @error('description')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bpjs_jht">{{ __('BPJS JHT - 3,7%') }}</label>
            <input type="number" name="bpjs_jht" id="bpjs_jht"
                class="form-control @error('bpjs_jht') is-invalid @enderror"
                value="{{ isset($employee) ? $employee->bpjs_jht : old('bpjs_jht') }}"
                placeholder="{{ __('bpjs_jht') }}" required />
            @error('bpjs_jht')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bpjs_jkk_jkm">{{ __('BPJS JKK/JKM - 0,54%') }}</label>
            <input type="number" name="bpjs_jkk_jkm" id="bpjs_jkk_jkm"
                class="form-control @error('bpjs_jkk_jkm') is-invalid @enderror"
                value="{{ isset($employee) ? $employee->bpjs_jkk_jkm : old('bpjs_jkk_jkm') }}"
                placeholder="{{ __('bpjs_jkk_jkm') }}" required />
            @error('bpjs_jkk_jkm')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bpjs_jp">{{ __('BPJS JP - 2%') }}</label>
            <input type="number" name="bpjs_jp" id="bpjs_jp"
                class="form-control @error('bpjs_jp') is-invalid @enderror"
                value="{{ isset($employee) ? $employee->bpjs_jp : old('bpjs_jp') }}"
                placeholder="{{ __('bpjs_jp') }}" required />
            @error('bpjs_jp')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bpjs_healt">{{ __('BPJS Health - 4%') }}</label>
            <input type="number" name="bpjs_healt" id="bpjs_healt"
                class="form-control @error('bpjs_healt') is-invalid @enderror"
                value="{{ isset($employee) ? $employee->bpjs_healt : old('bpjs_healt') }}"
                placeholder="{{ __('bpjs_healt') }}" required />
            @error('bpjs_healt')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="pph">{{ __('PPH 21') }}</label>
            <input type="number" name="pph" id="pph"
                class="form-control @error('pph') is-invalid @enderror"
                value="{{ isset($employee) ? $employee->pph : old('pph') }}"
                placeholder="{{ __('pph') }}" required />
            @error('pph')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
