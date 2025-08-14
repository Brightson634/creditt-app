@php
    $lastDueDate = null;
    if (!empty($repaymentSchedule)) {
        $lastDueDate = end($repaymentSchedule)['due_date'];
    }

    $totalPaid = collect($repaymentSchedule)->sum('amount_paid');
    $tenant = session('tenant');
    $companyName = $tenant->company_name ?? 'Company Name';
    $companyAddress = $tenant->physical_location ?? 'Company Address';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Loan Repayment Schedule - {{ ucfirst($repaymentPeriod) }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #343a40;
            background-color: #f8f9fa;
            padding: 30px;
        }

        h3 {
            text-align: left;
            font-size: 22px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .subtitle {
            text-align: left;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 25px;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        thead th {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: #fff;
            font-weight: 600;
            text-align: center;
            padding: 10px;
        }

        tbody td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }

        /* Stripe rows */
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Totals row */
        tfoot td {
            background-color: #343a40;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            padding: 10px;
            border-top: 2px solid #212529;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
            font-weight: 600;
            border-radius: 4px;
            padding: 2px 6px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            font-weight: 600;
            border-radius: 4px;
            padding: 2px 6px;
        }

        .status-partial {
            background-color: #d1ecf1;
            color: #0c5460;
            font-weight: 600;
            border-radius: 4px;
            padding: 2px 6px;
        }

        .status-unknown {
            background-color: #e2e3e5;
            color: #6c757d;
            font-weight: 600;
            border-radius: 4px;
            padding: 2px 6px;
        }

        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            h3 {
                font-size: 20px;
            }

            .subtitle {
                font-size: 12px;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Company Name as Heading -->
    <h2 style="text-align:left; font-weight:700; margin-bottom:5px;">{{ $companyName }}</h2>

    <!-- Address as Subtitle -->
    <div style="text-align:left; font-size:14px; color:#6c757d; margin-bottom:15px;">
        {{ $companyAddress }}
    </div>
    <h3>Loan Repayment Schedule</h3>
    <div class="subtitle">
        {{ ucwords(strtolower($member)) }} | {{ ucfirst($repaymentPeriod) }} Repayment Schedule | Generated on
        {{ date('d M Y') }}
    </div>

    <!-- Loan Summary -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Disbursed Date</th>
                <th>End Date</th>
                <th>Repayment Frequency</th>
                <th>Principal</th>
                <th>Total Interest</th>
                <th>Total Repayment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $releaseDate }}</td>
                <td>{{ $lastDueDate }}</td>
                <td>{{ ucfirst($repaymentPeriod) }}</td>
                <td>{{ number_format($loanAmount, 2) }}</td>
                <td>{{ number_format($totalInterest, 2) }}</td>
                <td>{{ number_format($totalRepayment, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Schedule Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Due Date</th>
                <th>Principal</th>
                <th></th>
                <th>Interest</th>
                <th></th>
                <th>Installment</th>
                @if (isset($repaymentSchedule[0]['principal_balance']))
                    <th>Balance</th>
                @endif
                <th>Paid</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repaymentSchedule as $schedule)
                @php
                    $statusClass = 'status-unknown';
                    switch ($schedule['payment_status'] ?? 'unknown') {
                        case 'paid':
                            $statusClass = 'status-paid';
                            break;
                        case 'pending':
                            $statusClass = 'status-pending';
                            break;
                        case 'partial':
                            $statusClass = 'status-partial';
                            break;
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $schedule['due_date'] ?? '' }}</td>
                    <td>{{ number_format($schedule['principal'], 2) }}</td>
                    <td>+</td>
                    <td>{{ number_format($schedule['interest'], 2) }}</td>
                    <td>=</td>
                    <td>{{ number_format($schedule['total_payment'], 2) }}</td>
                    @if (isset($schedule['principal_balance']))
                        <td>{{ number_format($schedule['principal_balance'], 2) }}</td>
                    @endif
                    <td>{{ number_format($schedule['amount_paid'] ?? 0, 2) }}</td>
                    <td class="{{ $statusClass }}">{{ ucfirst($schedule['payment_status'] ?? 'Unknown') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td>{{ number_format($loanAmount, 2) }}</td>
                <td></td>
                <td>{{ number_format($totalInterest, 2) }}</td>
                <td></td>
                <td>{{ number_format($totalRepayment, 2) }}</td>
                @if (isset($repaymentSchedule[0]['principal_balance']))
                    <td></td>
                @endif
                <td>{{ number_format($totalPaid, 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
