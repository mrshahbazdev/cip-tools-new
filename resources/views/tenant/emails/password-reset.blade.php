<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover { background-color: #0056b3; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>

        <p>Hello {{ $user->name }},</p>

        <p>You are receiving this email because we received a password reset request for your account.</p>

        <p>
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        </p>

        <p>If you did not request a password reset, no further action is required.</p>

        <p>This password reset link will expire in 60 minutes.</p>

        <div class="footer">
            <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
            <p><a href="{{ $resetUrl }}">{{ $resetUrl }}</a></p>
        </div>
    </div>
</body>
</html>
