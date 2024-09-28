<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Repayment Schedule</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            border-top: 5px solid #3b4863; /* Thick top border */
            padding-top: 20px; /* Space between border and content */
            margin-bottom: 30px; /* Space below the tables */
        }

        .table-title {
            text-align: center; /* Center the heading */
            font-size: 24px; /* Increase font size */
            font-weight: bold; /* Make the heading bold */
            color: #3b4863; /* Color for the heading */
            margin-bottom: 20px; /* Space below the heading */
        }

        .table thead th {
            color: #fff !important;
            background-color: #3b4863 !important;
            border-color: #49597b !important;
        }

        .totals {
            color: #fff !important;
            background-color: #3b4863 !important;
            border-color: #49597b !important;
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $lastDueDate = null;
            if (!empty($repaymentSchedule)) {
                $lastDueDate = end($repaymentSchedule)['due_date']; // Get the last due date
            }
        @endphp

        <div class="table-container">
            <div class="table-title">Loan Repayment Schedule Using {{$method}} Interest Method</div>

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
                        <th></th>
                        <th>Interest Amount</th>
                        <th></th>
                        <th>Periodic Installment</th>
                        <th>Principal Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($repaymentSchedule as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule['due_date'] }}</td>
                            <td>{{ number_format($schedule['principal'], 2) }}</td>
                            <td>+</td>
                            <td>{{ number_format($schedule['interest'], 2) }}</td>
                            <td>=</td>
                            <td>{{ number_format($schedule['total_payment'], 2) }}</td>
                            <td>{{ number_format($schedule['principal_balance'], 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class='totals'>
                        <td colspan="2">Total</td>
                        <td>{{ number_format($loanAmount) }}</td>
                        <td></td>
                        <td>{{ number_format($totalInterest) }}</td>
                        <td></td>
                        <td>{{ number_format($totalRepayment) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
