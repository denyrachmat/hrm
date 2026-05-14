<!DOCTYPE html>
<html>

<head>
    <title>{{ $data['type'] }} Notification</title>
</head>

<body>
    <p>Dear {{ $data['app_name'] }},</p>
    <p>An Employee have submitted an application for {{ $data['description'] }} . Here are the details:</p>

    <b>Employee Details</b>
    <p>FullName: {{ $data['employee_fullname'] }}</p>
    <p>Email: {{ $data['employee_email'] }}</p>
    <br>
    <b>Application Details</b>
    <p>Date: {{ $data['date'] }}</p>
    <p>Description: {{ $data['description'] }}</p>
    <p>Detailed Description: {{ $data['detailed_description'] }}</p>
    <p>Status: {{ $data['status'] }}</p>
    <p>File Attachment: {{ $data['file_attachment'] }}</p>
    <br>
    <p>Best regards,</p>
    <p>{{ $data['company_name'] }}</p>
</body>

</html>
