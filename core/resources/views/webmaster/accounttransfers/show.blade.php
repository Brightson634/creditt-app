
<div>
    <label class="text-gray-600">Transfer Info</label>
    <p class="invoice-info-row"><span>Transfer Account:</span><span>{{ $transfer->debitaccount->account_no }}</span>
    </p>
    <p class="invoice-info-row"><span>Receiving Account:</span><span>{{ $transfer->creditaccount->account_no }}</span></p>
    <p class="invoice-info-row"><span>Transfered Amount:</span><span>{!! showAmount($transfer->amount) !!}</span></p>
    <p class="invoice-info-row"><span>Description:</span><span>{{$transfer->description}}</span></p>
    <p class="invoice-info-row"><span>Date:</span><span>{{ dateFormat($transfer->date) }}</span></p>
</div>
