<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <tr>
            <td>
                <h2 style="color: #333333; margin-bottom: 20px;">Hello {{ $student->firstname }},</h2>

                <p style="font-size: 16px; color: #555555; margin-bottom: 10px;">
                    Thank you for registering at our <strong>Tutorial Center</strong>.
                </p>

                <p style="font-size: 16px; color: #555555; margin-bottom: 10px;">
                    Please click the button below to verify your email address:
                </p>

                <p style="text-align: center; margin: 30px 0;">
                    <a href="{{ $url }}" target="_blank" 
                       style="background-color: #007bff; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold;">
                        Verify Email
                    </a>
                </p>

                <p style="font-size: 16px; color: #555555; margin-bottom: 10px;">
                    Or use this verification code:
                </p>

                <p style="font-size: 24px; color: #007bff; font-weight: bold; text-align: center; margin: 20px 0;">
                    {{ $student->verification_code }}
                </p>

                <p style="font-size: 14px; color: #999999; margin-top: 20px;">
                    If you did not initiate this request, you can safely ignore this message.
                </p>

                <p style="font-size: 16px; color: #555555; margin-top: 30px;">
                    Regards,<br>
                    <strong>Tutorial Center Team</strong>
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
