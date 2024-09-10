<div class="modal-header">
    <h6 class="modal-title">Update Deposit</h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="row">
    <div class='col-md-5' id="member_profile_update">

    </div>
    <div class="col-md-7">
        <form action="{{ route('webmaster.accountdeposit.update', $deposit->id) }}" method="POST"
            id="accountdepositupdate_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            @php
                                $accounts_array = AllChartsOfAccounts();
                            @endphp
                            <label for="account_id">Account</label>
                            <select name="account_id" id="accUpdate" class="form-control accounts-dropdown account_id"
                                style="width: 100%;">
                                <option value="">Select Account</option>
                                @foreach ($accounts_array as $account)
                                    <option value="{{ $account['id'] }}" data-currency="{{ $account['currency'] }}"
                                        @if ($deposit->account_id == $account['id']) selected @endif>
                                        {{ $account['name'] }}
                                        -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="paymenttype_id">Payment Type</label>
                            <select class="form-control" name="paymenttype_id" id="paymenttype_id">
                                <option value="">select payment type </option>
                                @foreach ($payments as $data)
                                    <option value="{{ $data->id }}"
                                        @if ($deposit->paymenttype_id == $data->id) selected @endif>{{ $data->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" id="amount" value="{{ $deposit->amount }}"
                                class="form-control">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="depositor">Depositor</label>
                            <input type="text" name="depositor" value="{{ $deposit->depositor }}"
                                id="depositorUpdate" class="form-control">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date" class="form-label">Transaction
                                Date</label>
                            <input type="text" name="date" class="form-control" data-provide="datepicker"
                                data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="date"
                                value="{{ $deposit->date ?? now()->format('Y-m-d') }}" autocomplete="off">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="3">{{ $deposit->description }}</textarea>
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-indigo updateDepositBtn">Update Deposit</button>
                <button type="button" data-dismiss="modal" class="btn btn-outline-light">Dismiss</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#accUpdate").select2({
            placeholder: "Select an account",
            allowClear: true,
            dropdownParent: $('#editDeposit')
        })
        //showing account holder details
        $('.account_id').on('change', function() {

            var accountId = $(this).val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{ route('webmaster.member.profile') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    accId: accountId,
                },
                success: function(response) {

                    if (response.status == 200) {
                        $('#member_profile_update').html(response.html);
                        $('#depositorUpdate').val($('#memberName').val())
                    } else {
                        $('#member_profile_update').html('');
                        $('#depositorUpdate').val('');
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#member_profile_update').html('');
                    $('#depositorUpdate').val('');
                }
            });

        })
    });
</script>
