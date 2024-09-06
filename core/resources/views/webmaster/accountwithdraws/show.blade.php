
    <div>
            <label class="text-gray-600">Withdraw Info</label>
            <p class="invoice-info-row"><span>Account:</span><span>{{ $withdraw->memberAccount->account_no }}</span>
            </p>
            <p class="invoice-info-row"><span>Amount Withdrawn:</span><span>{!! showAmount($withdraw->amount) !!}</span></p>
            <p class="invoice-info-row"><span>Withdrawer:</span><span>{{ $withdraw->withdrawer }}</span></p>
            <p class="invoice-info-row"><span>Payment Type:</span><span>{{ $withdraw->paymenttype->name}}</span></p>
            <p class="invoice-info-row"><span>Description:</span><span>{{ $withdraw->description}}</span></p>
            <p class="invoice-info-row"><span>Date:</span><span>{{ dateFormat($withdraw->date) }}</span></p>
    </div>
