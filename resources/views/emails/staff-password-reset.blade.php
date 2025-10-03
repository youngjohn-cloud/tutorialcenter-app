<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset - Tutorial Center</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="20" cellspacing="0" style="background: #ffffff; border-radius: 10px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="background: #1A4D2B; color: #fff; border-radius: 10px 10px 0 0;">
                            <h2 style="margin: 0; padding: 10px;">Tutorial Center</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dear {{ $firstname }} {{ $lastname }},</p>

                            <p>We received a request to reset your password for your staff account. Click the button below to set a new password:</p>

                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ $reset_link }}" 
                                   style="background: #FFD700; color: #1A4D2B; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                                    Reset Password
                                </a>
                            </p>

                            <p>If the button above does not work, copy and paste this link into your browser:</p>
                            <p style="word-break: break-all; color: #1A4D2B;">
                                {{ $reset_link }}
                            </p>

                            <p>This password reset link will expire soon. If you did not request a password reset, please ignore this email.</p>

                            <p>Best regards,  
                            <br><strong>Tutorial Center Team</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="background: #f1f1f1; border-radius: 0 0 10px 10px; font-size: 12px; color: #666;">
                            <p>&copy; {{ date('Y') }} Tutorial Center. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
