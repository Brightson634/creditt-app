<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Disbursement Notification</title>
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
            border-radius: 5px 5px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }

        .content p {
            margin-bottom: 1em;
        }

        .loan-details {
            margin-bottom: 20px;
        }

        .loan-details p {
            margin: 5px 0;
        }

        .officer-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .officer-table th,
        .officer-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .officer-table th {
            background-color: #005222;
            color: white;
        }

        .button {
            background-color: #005222;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
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
            <h1>Loan Disbursement Notification</h1>
        </div>
        <div class="content">
            <p>Dear {{ $loan->member->fname }} {{ $loan->member->lname }},</p>
            <p>We are pleased to inform you that your loan has been successfully disbursed. Below are the details of
                your loan:</p>

            <div class="loan-details">
                <p><strong>Loan Number:</strong> {{ $loan->loan_no }}</p>
                <p><strong>Loan Amount:</strong> {{ number_format($loan->principal_amount, 2) }} {{ $loan->currency }}
                </p>
                <p><strong>Disbursement Amount:</strong> {{ number_format($loan->disbursment_amount, 2) }}
                    {{ $loan->currency }}</p>
                <p><strong>Disbursement Date:</strong> {{ dateFormat($loan->disbursement_date) }}</p>
            </div>

            <p>If you have any questions or need further assistance, please feel free to reach out to our loan officers
                listed below:</p>
            @php
                $officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)
                    ->whereNotNull('comment')
                    ->get();
            @endphp
            <table class="officer-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($officers as $officer)
                        <tr>
                            <td>{{ ucwords($officer->staff->title . ' ' . $officer->staff->fname . ' ' . $officer->staff->lname) }}
                            </td>
                            <td>{{ $officer->staff->email }}</td>
                            <td>{{ $officer->staff->telephone }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p>We value your membership and look forward to helping you achieve your financial goals with
                {{ $saccoName }}.</p>

            <p>Best regards,</p>
            <p>{{ $saccoName }} Team</p>
        </div>

        <div class="footer">
            <p>If you have any questions, feel free to contact us at {{ $saccoEmail }} or {{ $saccoTel }}.</p>
        </div>
    </div>
</body>

</html>
