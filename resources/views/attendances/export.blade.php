<table>
    <thead>
        <tr>
            <th style="background-color:#D3D3D3 ">{{ __('Employee') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Departement') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Date') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Clock In') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Istirahat In') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Istirahat Out') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Clock Out') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Is Present') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Description') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Difference') }}</th>
            <th style="background-color:#D3D3D3 ">{{ __('Activity') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->full_name }}</td>
                <td>{{ $dt->department_name }}</td>
                <td>{{ $dt->date }}</td>
                <td>{{ $dt->clock_in }}</td>
                <td>{{ $dt->clock_istirahat }}</td>
                <td>{{ $dt->clock_istirahat_out }}</td>
                <td>{{ $dt->clock_out }}</td>
                <td>{{ $dt->is_present }}</td>
                <td>{{ $dt->description }}</td>
                <td>{{ $dt->selisih }}</td>
                <td>{{ $dt->activity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
