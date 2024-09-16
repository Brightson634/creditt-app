<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Receipt</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for the print icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
        }

        .receipt-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }

        .logo {
            max-width: 90px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            position: relative;
        }

        .header h5 {
            margin-top: 10px;
            font-size: 24px;
            font-weight: bold;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        /* Print Icon Style */
        .print-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #333;
            cursor: pointer;
            transition: color 0.3s;
        }

        .print-icon:hover {
            color: #007bff;
        }

        .info-table {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .info-table th {
            width: 50%;
            text-align: left;
            padding-right: 15px;
            font-weight: normal;
            color: #333;
        }

        .info-table td {
            text-align: right;
            font-weight: bold;
        }

        .total-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #f0f0f0;
            padding-top: 15px;
        }

        .footer small {
            display: block;
            margin-top: 5px;
        }

        .print-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #fff;
            background-color: #007bff;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .print-icon:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
    </style>

    <script>
        function printReceipt() {
            document.querySelector('.print-icon').style.display = 'none';
            window.print();

            setTimeout(function() {
                document.querySelector('.print-icon').style.display = 'block';
            }, 1000);
        }
    </script>
</head>

<body>
    @php
        $systemInfo = getSystemInfo();
    @endphp

    <div class="receipt-container">
        <!-- Header Section -->
        <div class="header">
            <img src="{{ asset('assets/uploads/generals/' . $systemInfo->logo) }}" alt="Microfinance Logo"
                class="logo mb-3">
            <h5>{{ $systemInfo->company_name }}</h5>
            <p>{{ $systemInfo->post_office }}</p>
            <p>{{ $systemInfo->physical_location }}</p>
            <p>{{ $systemInfo->phone_contact_one . ' | ' . $systemInfo->phone_contact_two }}</p>
            <p>{{ $systemInfo->email_address_one . ' | ' . $systemInfo->email_address_two }}</p>

            <!-- Print Icon -->
            <i class="fas fa-print print-icon" onclick="printReceipt()" title="Print"></i>
        </div>
