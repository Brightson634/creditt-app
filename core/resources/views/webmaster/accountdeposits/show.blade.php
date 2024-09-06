
    <div>
            <label class="text-gray-600">Deposit Info</label>
            <p class="invoice-info-row"><span>Account:</span><span>{{ $deposit->memberAccount->account_no }}</span>
            </p>
            <p class="invoice-info-row"><span>Amount:</span><span>{!! showAmount($deposit->amount) !!}</span></p>
            <p class="invoice-info-row"><span>Depositor:</span><span>{{ $deposit->depositor }}</span></p>
            <p class="invoice-info-row"><span>Payment Type:</span><span>{{ $deposit->paymenttype->name}}</span></p>
            <p class="invoice-info-row"><span>Description:</span><span>{{ $deposit->description}}</span></p>
            <p class="invoice-info-row"><span>Date:</span><span>{{ dateFormat($deposit->date) }}</span></p>
    </div>
