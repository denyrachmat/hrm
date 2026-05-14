<!DOCTYPE html>
<html>

<head>
    <title>{{ $data['type'] }} Notification</title>
</head>

<body>
    <p>Dear {{ $data['name'] }},</p>
    <p>You have submitted a {{ $data['type'] }} request on {{ array_key_exists('date', $data) ? $data['date'] : $data['start_date'] . ' until ' . $data['end_date'] }}. Here are the details:</p>
    <p>Status: {{ $data['status'] }}</p>
    <p>Note: {{ $data['note'] }}</p>
    <p>Description: {{ $data['description'] }}</p>
    <p>Detail Description: {{ $data['detail_description'] }}</p>
    <br>
    <p>Best regards,</p>
    <p>{{ $data['company_name'] }}</p>
</body>

</html>
