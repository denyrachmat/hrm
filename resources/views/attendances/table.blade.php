<table class="table">
    <tbody>
        @foreach ($attendancesById as $row)
            <tr>
                <th>{{ $row->description }}</th>
                <th>:</th>
                <td>{{ $row->total_point }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
