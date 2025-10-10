<!DOCTYPE html>
<html>

<head>
    <title>Loan Payment Receipt</title>
    <style>
        /* Reset & base */
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            padding: 20px;
            color: #333;
            background: #f5f5f5;
        }

        .receipt {
            background: #fff;
            max-width: 700px;
            margin: auto;
            padding: 30px 40px;
            /* border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); */
        }

        /* Header */
        .header {
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header img {
            max-height: 80px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            font-size: 13px;
            color: #555;
        }

        /* Title */
        h3 {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 18px;
            letter-spacing: 1px;
            color: #444;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }

        th,
        td {
            padding: 12px 10px;
        }

        th {
            background: #f7f7f7;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        td {
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        .text-right {
            text-align: right;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }

        .footer em {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="receipt">

        <!-- Header -->
        <div class="header">
            @if (!empty($settings->company_logo))
                <img src="{{ public_path('uploads/business_logos/' . $settings->company_logo) }}" alt="Company Logo">
            @endif
            <h1>{{ $settings->company_name }}</h1>
            <p>{{ $settings->post_office }}</p>
            <p>{{ $settings->physical_location }}</p>
            <p>{{ $settings->phone_contact_one }} | {{ $settings->phone_contact_two }}</p>
            <p>{{ $settings->email_address_one }} | {{ $settings->email_address_two }}</p>
        </div>

        <!-- Receipt Body -->
        <h3>Loan Payment Receipt</h3>
        <p><strong>Loan No:</strong> {{ $loan->loan_no }}</p>
        <p><strong>Member:</strong> {{ $loan->member->fname . ' ' . $loan->member->lname }}</p>
        <p><strong>Due Date:</strong> {{ $dueDate }}</p>
        <p><strong>Payment Date:</strong> {{ $paymentDate }}</p>

        <table>
            <tr>
                <th>Description</th>
                <th class="text-right">Amount (UGX)</th>
            </tr>
            <tr>
                <td>Loan Repayment</td>
                <td class="text-right">{{ number_format($amount, 2) }}</td>
            </tr>
        </table>

        <p class="text-right" style="margin-top: 15px; font-size: 16px;"><strong>Total Paid:</strong>
            {{ number_format($amount, 2) }}</p>

        <div class="footer">
            Thank you for your payment!
            <em>Generated on {{ now()->format('Y-m-d H:i:s') }}</em>
        </div>
    </div>
</body>

</html>
