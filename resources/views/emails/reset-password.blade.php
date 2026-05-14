<!-- resources/views/emails/reset-password.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <p>Hello!</p>
    <p>You can reset your password by clicking the following link:</p>
    <a href="{{ $data['resetLink'] }}">Reset Password</a>
    <p>If you didn't request a password reset, you can ignore this email.</p>
    <p>Thank you!</p>
</body>

</html>
