<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body>
    <p>Hello {{ $student->firstname }},</p>

    <p>Thank you for registering at our Tutorial Center.</p>

    <p>Please click the link below to verify your email:</p>

    <p><a href="{{ $url }}" target="_blank">{{ $url }}</a></p>
    <p>Email Verification Code: {{ $student->verification_code }}</p>

    <p>If you did not initiate this request, you can safely ignore this message.</p>

    <br>
    <p>Regards,<br><strong>Tutorial Center Team</strong></p>
</body>
</html>
