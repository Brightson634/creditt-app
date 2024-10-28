<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Repayment Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            border-top: 5px solid #3b4863;
            padding-top: 20px;
            margin-bottom: 30px;
        }
        
        .table-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #3b4863;
            margin-bottom: 20px;
        }
        
        .table thead th {
            color: #fff;
            background-color: #3b4863;
            border-color: #49597b;
        }
        
        .table td, .table th {
            padding: 10px !important;
            /* Increase padding for more spacing */
            vertical-align: middle;
            /* Center content vertically */
        }
        
        .totals {
            color: #fff;
            background-color: #3b4863;
            border-color: #49597b;
        }
        
        /* Explicit column widths */
        th, td {
            text-align: center;
            font-size: 14px;
        }
        
        td:first-child, th:first-child { width: 5%; }
        td:nth-child(2), th:nth-child(2) { width: 12%; }
        td:nth-child(3), th:nth-child(3) { width: 12%; }
        td:nth-child(5), th:nth-child(5) { width: 12%; }
        td:nth-child(7), th:nth-child(7) { width: 15%; }
        td:nth-child(8), th:nth-child(8) { width: 15%; }
        td:nth-child(9), th:nth-child(9) { width: 15%; }
    </style>
</head>
<body>
    <div class="container">
        @php
            $lastDueDate = null;
            if (!empty($repaymentSchedule)) {
                $lastDueDate = end($repaymentSchedule)['due_date'];
            }
        @endphp
        
        <div class="table-container">
            <div class="table-title">Loan Repayment Schedule</div>
            <table class="table table-striped table-bordered">
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
                        <td>{{ number_format($loanAmount) }}</td>
                        <td>{{ number_format($totalInterest) }}</td>
                        <td>{{ number_format($totalRepayment) }}</td>
                    </tr>
                </tbody>
            </table>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Due Date</th>
                        <th>Principal Amount</th>
                        <th>Interest Amount</th>
                        <th>Periodic Installment</th>
                        <th>Principal Balance</th>
                        <th>Amount Paid</th>
                        <th>Repayment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($repaymentSchedule as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule['due_date'] }}</td>
                            <td>{{ number_format($schedule['principal'], 2) }}</td>
                            <td>{{ number_format($schedule['interest'], 2) }}</td>
                            <td>{{ number_format($schedule['total_payment'], 2) }}</td>
                            <td>{{ number_format($schedule['principal_balance'], 2) }}</td>
                            <td>{{ number_format($schedule['amount_paid'], 2) }}</td>
                            <td>
                                @php
                                    $status = $schedule['payment_status'];
                                    $badgeClass = match($status) {
                                        'pending' => 'badge badge-warning',
                                        'partial' => 'badge badge-info',
                                        'paid' => 'badge badge-success',
                                        default => 'badge badge-secondary'
                                    };
                                    $icon = $status === 'paid' ? '&check;' : '';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $icon }} {{ ucfirst($status) }}</span>
                            </td>
                        </tr>
                    @endforeach
                    <tr class='totals'>
                        <td colspan="2">Total</td>
                        <td>{{ number_format($loanAmount) }}</td>
                        <td>{{ number_format($totalInterest) }}</td>
                        <td>{{ number_format($totalRepayment) }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
