<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Tutorial Center</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #ffffff;
            width: 600px;
            margin: 40px auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            background: #1A4D2B;
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 30px 40px;
            color: #333;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
        }
        .details {
            margin: 20px 0;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e3e8ef;
        }
        .details p {
            margin: 5px 0;
            font-size: 15px;
        }
        .footer {
            background: #f1f3f6;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            color: #888;
        }
        .highlight {
            font-weight: 600;
            color: #1A4D2B;
        }
        .btn {
            display: inline-block;
            background: #FFD700;
            color: #1A4D2B;
            padding: 12px 20px;
            margin-top: 20px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Welcome to Tutorial Center</h1>
        </div>
        <!-- Content -->
        <div class="content">
            <p>Dear <span class="highlight">{{ $firstname }} {{ $lastname }}</span>,</p>
            <p>
                We are excited to officially welcome you to the <strong>Tutorial Center</strong> team! 
                Your role as a <span class="highlight">{{ $role }}</span> is vital to our mission, and we look forward to the great impact you'll make.
            </p>

            <div class="details">
                <p><strong>Staff ID:</strong> {{ $staff_id }}</p>
                <p><strong>Email Address:</strong> {{ $email }}</p>
                <p><strong>Email Password:</strong> {{ $staff_id }}</p>
                <p><strong>Role:</strong> {{ $role }}</p>
            </div>

            <p>Please use the above credentials to access your official staff email and internal resources. For security, ensure you update your password immediately after your first login.</p>

            <a href="{{ $login_link }}" class="btn">Access Staff Portal</a>

            <p>If you have any questions, feel free to reach out to the HR team. We're here to support you every step of the way.</p>

            <p>Welcome aboard and let’s achieve greatness together!</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Tutorial Center. All Rights Reserved.
        </div>
    </div>
</body>
</html>
