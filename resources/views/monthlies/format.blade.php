<table>
    <thead>
        <tr>
            <th style="text-align: center;vertical-align: middle;background-color:#D3D3D3 ">
                {{ __('Employee ID') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:#D3D3D3 ">
                {{ __('Full Name') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:#D3D3D3 ">
                {{ __('Departement Name') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:#D3D3D3 ">
                {{ __('Currency') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:#D3D3D3 ">
                {{ __('Salary') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:#D3D3D3 ">
                {{ __('Period') }}</th>

            <th style="text-align: center;vertical-align: middle;background-color:green ">
                {{ __('Earnings BPJS JHT - 3,7%') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:green ">
                {{ __('Earnings BPJS JKK/JKM - 0,54%') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:green ">
                {{ __('Earnings BPJS JP - 2%') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:green ">
                {{ __('Earnings BPJS Health - 4%') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:green ">
                {{ __('Medical Insurance') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:green ">{{ __('Transport') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:green ">
                {{ __('Miscellaneous Earnings') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:red ">
                {{ __('Deductions BPJS JHT - 3,7%') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:red ">
                {{ __('Deductions BPJS JKK/JKM - 0,54%') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:red ">
                {{ __('Deductions BPJS JP - 2%') }}
            </th>
            <th style="text-align: center;vertical-align: middle;background-color:red ">
                {{ __('BPJS Health - 4%') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:red ">{{ __('PPH 21') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:red ">{{ __('Insurance') }}</th>
            <th style="text-align: center;vertical-align: middle;background-color:red ">
                {{ __('Miscellaneous Deduction') }}
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            @php
                $data = DB::table('monthlies')
                    ->where('employee_id', $dt->id)
                    ->where('period', $month)
                    ->first();
                if ($data) {
                    $bpjs_jht_earnings = $data->bpjs_jht_earnings;
                    $bpjs_jkk_jkm_earnings = $data->bpjs_jkk_earnings;
                    $bpjs_jp_earnings = $data->bpjs_jp_earnings;
                    $bpjs_healt_earnings = $data->bpjs_healt_earnings;
                    $medical_insurance_earnings = $data->medical_insurance_earnings;
                    $transport_earnings = $data->transport_earnings;
                    $miscellaneous_earnings = $data->miscellaneous_earnings;
                    $bpjs_jht_deductions = $data->bpjs_jht_deductions;
                    $bpjs_jkk_jkm_deductions = $data->bpjs_jkk_jkm_deductions;
                    $bpjs_jp_deductions = $data->bpjs_jp_deductions;
                    $bpjs_healt_deductions = $data->bpjs_healt_deductions;
                    $pph = $data->pph;
                    $insurance = $data->insurance_deductions;
                    $miscellaneous_deduction = $data->miscellaneous_deduction;
                } else {
                    $bpjs_jht_earnings = $dt->bpjs_jht_earnings;
                    $bpjs_jkk_jkm_earnings = $dt->bpjs_jkk_jkm_earnings;
                    $bpjs_jp_earnings = $dt->bpjs_jp_earnings;
                    $bpjs_healt_earnings = $dt->bpjs_healt_earnings;
                    $medical_insurance_earnings = '';
                    $transport_earnings = '';
                    $miscellaneous_earnings = '';
                    $bpjs_jht_deductions = $dt->bpjs_jht_deductions;
                    $bpjs_jkk_jkm_deductions = $dt->bpjs_jkk_jkm_deductions;
                    $bpjs_jp_deductions = $dt->bpjs_jp_deductions;
                    $bpjs_healt_deductions = $dt->bpjs_healt_deductions;
                    $pph = $dt->pph;
                    $insurance = '';
                    $miscellaneous_deduction = '';
                }
            @endphp
            <tr>
                <td>{{ $dt->employee_id }}</td>
                <td>{{ $dt->full_name }}</td>
                <td>{{ $dt->department_name }}</td>
                <td>{{ $dt->currency }}</td>
                <td>{{ $dt->salary }}</td>
                <td>{{ $month }}</td>
                <td>{{ $bpjs_jht_earnings }}</td>
                <td>{{ $bpjs_jkk_jkm_earnings }}</td>
                <td>{{ $bpjs_jp_earnings }}</td>
                <td>{{ $bpjs_healt_earnings }}</td>
                <td>{{ $medical_insurance_earnings }}</td>
                <td>{{ $transport_earnings }}</td>
                <td>{{ $miscellaneous_earnings }}</td>
                <td>{{ $bpjs_jht_deductions }}</td>
                <td>{{ $bpjs_jkk_jkm_deductions }}</td>
                <td>{{ $bpjs_jp_deductions }}</td>
                <td>{{ $bpjs_healt_deductions }}</td>
                <td>{{ $pph }}</td>
                <td>{{ $insurance }}</td>
                <td>{{ $miscellaneous_deduction }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
