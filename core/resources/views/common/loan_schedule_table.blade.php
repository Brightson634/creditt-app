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
                <td>
                    <a href="#" class="repayment_date" data-due-date="{{ $schedule['due_date'] ?? '' }}"
                        data-payment-proof="{{ $schedule['proof_of_payment'] ?? '' }}"
                        data-amount-paid="{{ $schedule['amount_paid'] ?? '' }}"
                        data-payment_type="{{ $schedule['payment_status'] ?? '' }}"
                        data-total_payment="{{$schedule['total_payment'] ?? '' }}"
                        data-payment_mode="{{ $schedule['payment_mode'] ?? '' }}"
                        data-member-id="{{ $schedule['member_id'] ?? '' }}"
                        data-is-verified="{{ $schedule['is_verified_payment'] ?? '' }}">
                        {{ $schedule['due_date'] ?? '' }}
                    </a>
                </td>

                <td>{{ number_format($schedule['principal'], 2) }}</td>
                <td>+</td>
                <td>{{ number_format($schedule['interest'], 2) }}</td>
                <td>=</td>
                <td>{{ number_format($schedule['total_payment'], 2) }}</td>
                <td>{{ number_format($schedule['principal_balance'], 2) }}</td>
                <td>{{ number_format($schedule['amount_paid'] ?? 0, 2) }}</td>
                @php
                    $status = $schedule['payment_status'] ?? 'unknown';
                    $isVerified = $schedule['is_verified_payment'] ?? null;
                    $badgeClass = '';
                    $icon = '';

                    switch ($status) {
                        case 'pending':
                            $badgeClass = 'badge badge-warning';
                            break;
                        case 'partial':
                            $badgeClass = 'badge badge-info';
                            break;
                        case 'paid':
                            $badgeClass = 'badge badge-success';
                            $status = $isVerified === 0 || is_null($isVerified) ? 'waiting verification' : $status;
                            $icon = $isVerified ? '&check;' : '';
                            break;
                        default:
                            $badgeClass = 'badge badge-secondary';
                            break;
                    }
                @endphp

                <td>
                    <span class="{{ $badgeClass }}">
                        @if (!empty($icon))
                            <span style="font-size:25px;">{!! $icon !!}</span>
                        @endif
                        {{ ucfirst($status) }}
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
