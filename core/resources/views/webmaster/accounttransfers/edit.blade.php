<div class="modal-header">
    <h6 class="modal-title">Update Transfer</h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('webmaster.accounttransfer.update', $transfer->id) }}" method="POST" id="accounttransferUpdate_form">
    @csrf
    <div class="modal-body">
    <div class="form-group">
        <label for="debit_account">Transfer From</label>
        @php
        $accounts_array = AllChartsOfAccounts();
    @endphp
        <select name="debit_account"
            class="form-control accounts-dropdown debit_account"
            style="width: 100%;" id='debit_account'>
            <option value=''>Select Account</option>
            @foreach ($accounts_array as $account)
                <option value="{{ $account['id'] }}"
                    data-currency="{{ $account['currency'] }}"  @if ($debitAcc == $account['id']) selected @endif>
                    {{ $account['name'] }}
                    -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                </option>
            @endforeach
        </select>

        <span class="invalid-feedback"></span>
    </div>
    <div class="form-group">
        <label for="credit_account">Transfer To</label>
        <select name="credit_account"
            class="form-control accounts-dropdown credit_account"
            style="width: 100%;" id="credit_account">
            <option value=''>Select Account</option>
            @foreach ($accounts_array as $account)
                <option value="{{ $account['id'] }}"
                    data-currency="{{ $account['currency'] }}"  @if ($creditAcc == $account['id']) selected @endif>
                    {{ $account['name'] }}
                    -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                </option>
            @endforeach
        </select>
        <span class="invalid-feedback"></span>
    </div>
    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="text" name="amount" value="{{$transfer->amount}}"id="amount"
            class="form-control">
        <span class="invalid-feedback"></span>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" id="description" rows="3">{{$transfer->description}}</textarea>
        <span class="invalid-feedback"></span>
    </div>
    <div class="form-group">
        <label for="date" class="form-label">Transaction Date</label>
        <input type="text" name="date" class="form-control"
            data-provide="datepicker" data-date-autoclose="true"
            data-date-format="yyyy-mm-dd" id="date"
            value="{{$transfer->date ?? now()->format('Y-m-d') }}" autocomplete="off">
        <span class="invalid-feedback"></span>
    </div>
</div><!-- modal-body -->
<div class="modal-footer">
    <button type="button" class="btn btn-indigo updateTransferBtn">Update Transfer</button>
    <button type="button" data-dismiss="modal" class="btn btn-outline-light">Dismiss</button>
</div>
</form>