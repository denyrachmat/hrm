<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Employee ID') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Full Name') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Department Name') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Gender') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Date of Birth') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Martial Status') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('ID Type') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('National Id No') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Start contract date') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('End contract date') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Job position') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Branch Office') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Bpjs tk no') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Bpjs health no') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Medical insurance') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Work status') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Currency') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Salary') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Address') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Email') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Tax ID') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Use GPS Location') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->employee_id }}</td>
                <td>{{ $dt->full_name }}</td>
                <td>{{ $dt->department_name }}</td>
                <td>{{ $dt->gender }}</td>
                <td>{{ $dt->date_of_birth }}</td>
                <td>{{ $dt->martial_status }}</td>
                <td>{{ $dt->id_type }}</td>
                <td>{{ $dt->national_id_no }}</td>
                <td>{{ $dt->start_contract_date }}</td>
                <td>{{ $dt->end_contract_date }}</td>
                <td>{{ $dt->job_position }}</td>
                <td>{{ $dt->branch_office_name }}</td>
                <td>{{ $dt->bpjs_tk_no }}</td>
                <td>{{ $dt->bpjs_health_no }}</td>
                <td>{{ $dt->medical_insurance }}</td>
                <td>{{ $dt->work_status }}</td>
                <td>{{ $dt->currency }}</td>
                <td>{{ $dt->salary }}</td>
                <td>{{ $dt->address }}</td>
                <td>{{ $dt->email }}</td>
                <td>{{ $dt->tax_id }}</td>
                <td>{{ $dt->use_gps_location }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
