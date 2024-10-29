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
            <th>Amount Paid</th>
            <th>Repayment Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($repaymentSchedule as $schedule)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><a href='#' class='repayment_date' data-due-date="{{ $schedule['due_date'] }}"
                        data-payment-proof="{{ $schedule['proof_of_payment'] }}"
                        data-amount-paid={{ $schedule['amount_paid'] }}
                        data-payment_type='{{ $schedule['payment_status'] }}' data-payment_mode={{$schedule['payment_mode']}}>{{ $schedule['due_date'] }}</a></td>
                <td>{{ number_format($schedule['principal'], 2) }}</td>
                <td>+</td>
                <td>{{ number_format($schedule['interest'], 2) }}</td>
                <td>=</td>
                <td>{{ number_format($schedule['total_payment'], 2) }}</td>
                <td>{{ number_format($schedule['principal_balance'], 2) }}</td>
                <td>{{ number_format($schedule['amount_paid'], 2) }}</td>
                <td>@php
                    $status = $schedule['payment_status'];
                    $badgeClass = '';
                    switch ($status) {
                        case 'pending':
                            $badgeClass = 'badge badge-warning';
                            $icon = '';
                            break;
                        case 'partial':
                            $badgeClass = 'badge badge-info';
                            $icon = '';
                            break;
                        case 'paid':
                            $badgeClass = 'badge badge-success';
                            if ($schedule['is_verified_payment'] === 0) {
                                $status = 'waiting verification';
                            } else {
                                $icon = '&check;';
                            }
                            break;
                        default:
                            $badgeClass = 'badge badge-secondary';
                            $icon = '';
                            break;
                    }
                @endphp

                    <span class="{{ $badgeClass }}">
                        @if (!empty($icon))
                            <span style='font-size:25px;'>{!! $icon !!}</span>
                        @endif{{ ucfirst($status) }}
                    </span>
                </td>
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
