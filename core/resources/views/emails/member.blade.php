<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $saccoName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #005222;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }
        .button {
            background-color: #005222;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to {{ $saccoName }}</h1>
        </div>
        <div class="content">
            <p>Dear Member,</p>
            <p>We are excited to welcome you to {{ $saccoName }}. As part of our SACCO, you are joining a community dedicated to achieving financial growth and security together.</p>
            
            <p><strong>Your login details are as follows:</strong></p>
            <p>MemberID: {{ $memberID }}</p>
            <p>Password: <strong>{{ $password }}</strong></p>
            
            <p>Please use the button below to log in to your member dashboard:</p>
            <p><a href="{{ $loginUrl }}" class="button">Login to Member Dashboard</a></p>
            
            <p>For your security, we strongly advise you to reset your password after logging in.</p>
            
            <p>Thank you for being a part of {{ $saccoName }}. We look forward to achieving great success together!</p>
            
            <p>Best regards,</p>
            <p>{{ $saccoName }} Team</p>
        </div>
        <div class="footer">
            <p>If you have any questions, feel free to contact us!</p>
        </div>
    </div>
</body>
</html>
