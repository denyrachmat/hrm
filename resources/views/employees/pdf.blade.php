<!DOCTYPE html>
<html>

<head>
    <title>List Employees</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div>
        <table class='table table-bordered table-sm' style="font-size: 10px">
            <thead>
                <tr>
                    <th style="background-color:#D3D3D3 ">{{ __('Employee ID') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Full Name') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Department Name') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Work status') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Use GPS Location') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Start contract date') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('End contract date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $dt)
                    <tr>
                        <td>{{ $dt->employee_id }}</td>
                        <td>{{ $dt->full_name }}</td>
                        <td>{{ $dt->department_name }}</td>
                        <td>{{ $dt->work_status }}</td>
                        <td>{{ $dt->use_gps_location }}</td>
                        <td>{{ $dt->start_contract_date }}</td>
                        <td>{{ $dt->end_contract_date }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
