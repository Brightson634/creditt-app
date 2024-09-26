<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Due Date</th>
            <th>Principal Amount</th>
            <th>Interest Amount</th>
            <th>Due Amount</th>
            <th>Principal Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($repaymentSchedule as $schedule)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $schedule['due_date'] }}</td>
                <td>{{ number_format($schedule['principal'], 2) }}</td>
                <td>{{ number_format($schedule['interest'], 2) }}</td>
                <td>{{ number_format($schedule['total_payment'], 2) }}</td>
                <td>{{ number_format($schedule['principal_balance'], 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">Total</td>
            <td>{{number_format($loanAmount)}}</td>
            <td>{{number_format($totalInterest)}}</td>
            <td>{{number_format($totalRepayment)}}</td>
        </tr>
    </tbody>
</table>
