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
                    <th style="background-color:#D3D3D3 ">{{ __('Employee') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Departement') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Date') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Clock In') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Clock Out') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Is Present') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Description') }}</th>
                    <th style="background-color:#D3D3D3 ">{{ __('Difference') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $dt)
                    <tr>
                        <td>{{ $dt->full_name }}</td>
                        <td>{{ $dt->department_name }}</td>
                        <td>{{ $dt->date }}</td>
                        <td>{{ $dt->clock_in }}</td>
                        <td>{{ $dt->clock_out }}</td>
                        <td>{{ $dt->is_present }}</td>
                        <td>{{ $dt->description }}</td>
                        <td>{{ $dt->selisih }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
