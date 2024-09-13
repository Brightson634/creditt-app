<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title }}</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .otp-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .otp-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .otp-container button {
            width: 100%;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="otp-container">
            <h2>Two-Factor Authentication</h2>
            <p class="text-center">Please enter the code from your authenticator app:</p>

            <form action="{{ route('webmaster.2fa.verify') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="fa_code" class="form-label">Enter 2FA code:</label>
                    <input type="number" class="form-control" name="fa_code" id="fa_code" required>
                </div>

                @if ($errors->has('fa_code'))
                    <p class="error">{{ $errors->first('fa_code') }}</p>
                @endif

                <button type="submit" class="btn btn-primary">Verify</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
