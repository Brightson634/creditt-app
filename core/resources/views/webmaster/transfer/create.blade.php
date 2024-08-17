<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-content-demo">
        <div class="modal-content modal-content-demo">
            <form action="{{ action([\App\Http\Controllers\Webmaster\TransferController::class, 'store']) }}"
                method="post" id="transfer_form">
                @csrf

                <div class="modal-header">
                    <h6 class="modal-title">Add Transfer</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ref_no">Reference No:</label>
                                <input type="text" name="ref_no" id="ref_no" class="form-control"
                                    placeholder="Leave empty to autogenerate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="operation_date">Date:*</label>
                                <div class="input-group">
                                    <input type="text" name="operation_date" id="operation_date" class="form-control"
                                        placeholder=" Date" required>
                                    <span class="input-group-addon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="from_account">Transfer From:*</label>
                                <select name="from_account" id="from_account" class="form-control accounts-dropdown"
                                    required>
                                    <option value="">Please Select</option>
                                    @foreach ($accounts_array as $account)
                                        <option value="{{ $account['id'] }}" data-currency="{{ $account['currency'] }}">
                                            {{ $account['name'] }}
                                            -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Transfer Amount:*</label>
                                <input type="text" name="amount" id="amount" class="form-control input_number"
                                    required placeholder="Amount">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transfer_currency">Transfer Currency:*</label>
                                <select name="transfer_currency" id="transfer_currency" class="form-control" required>
                                    <option value="">Please Select</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->country }} -
                                            {{ $currency->currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_account">Transfer To:*</label>
                                <select name="to_account" id="to_account" class="form-control accounts-dropdown"
                                    required>
                                    <option value="">Please Select</option>
                                    @foreach ($accounts_array as $account)
                                        <option value="{{ $account['id'] }}"
                                            data-currency="{{ $account['currency'] }}">
                                            {{ $account['name'] }}
                                            -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                        </option>
                                    @endforeach
                                    <!-- Options will be added dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Transfer From Account Exchanged Amount</label>
                                <input type="number" name="exchangedFromAmount" readonly id="exchangedFromAmount"
                                    class="form-control">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Transfer To Account Exchanged Amount</label>
                                <input type="number" name="exchangedToAmount" readonly id="exchangedToAmount"
                                    class="form-control">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea name="note" id="note" class="form-control" placeholder="Note" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="number" class='form-control' name='conversion' id='conversion'>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-content -->

</div><!-- /.modal-dialog -->
<script>
    $(document).ready(function() {
        $('#transfer_currency').select2();
        $('#operation_date').datetimepicker({
            format: 'mm/dd/yyyy hh:ii',
            language: 'en',
            autoclose: true,
        });

        //performing necessary conversions
        // Default system currency and exchange Rates
        var defaultCurrency = @json($default_currency);
        var exchangeRates = @json($exchangeRates);

        function getExchangeRate(fromCurrency, toCurrency) {
            for (var i = 0; i < exchangeRates.length; i++) {
                //exchange rate when converting from default system currency to given currency
                if (Number(fromCurrency) === Number(defaultCurrency)) {
                    if (exchangeRates[i].from_currency_id === toCurrency && exchangeRates[i].to_currency_id ===
                        fromCurrency) {
                        return parseFloat(1 / (exchangeRates[i].exchange_rate));
                    }
                }
                //default set exchange rate
                if (exchangeRates[i].from_currency_id === fromCurrency && exchangeRates[i].to_currency_id ===
                    toCurrency) {
                    return parseFloat(exchangeRates[i].exchange_rate);
                }
            }

            if (fromCurrency === toCurrency) {
                return 1;
            }
            return null;
        }

        function convertCurrency(amount, fromCurrency, toCurrency) {
            if (Number(fromCurrency) === Number(toCurrency)) {
                return amount;
            }
            var rate = getExchangeRate(fromCurrency, toCurrency);
            if (rate) {
                return amount * rate;
            }
            return null;
        }

        function performConversion() {

            var amount = parseFloat($('#amount').val());
            var transferCurrency = $('#transfer_currency').val();
            var transferFromAccCurrency = $('#from_account option:selected').data('currency');

            if (!transferFromAccCurrency) {
                toastr.warning('Selected Account has an unspecified holding Currency')
            }

            if (!amount || !transferCurrency || !transferFromAccCurrency) {
                $('#exchangedFromAmount').val('');
                $('#conversion').val(0);
                return;
            }

            var convertedAmount = amount;

            // Step 1: Check if transfer currency is the same as default system currency
            if (Number(transferCurrency) === Number(defaultCurrency)) {
                // Convert to transfer from account currency
                convertedAmount = convertCurrency(amount, defaultCurrency, transferFromAccCurrency);
            } else {
                // Convert payment currency to default system currency
                var amountInDefaultCurrency = convertCurrency(amount, Number(transferCurrency), Number(
                    defaultCurrency));

                if (amountInDefaultCurrency !== null) {
                    // Convert from default system currency to account currency
                    convertedAmount = convertCurrency(amountInDefaultCurrency, Number(defaultCurrency), Number(
                        transferFromAccCurrency));
                } else {
                    $('#conversion').val(0);
                    return;
                }
            }

            if (convertedAmount !== null) {
                $('#exchangedFromAmount').val(convertedAmount.toFixed(6));
            } else {
                //leave amount if both transfer currency and transfer acc currency are the same
                if (Number(transferCurrency) === Number(transferFromAccCurrency)) {
                    $('#exchangedFromAmount').val(amount.toFixed(6))
                } else {
                    $('#conversion').val(0);
                }

            }
        }

        $('#amount, #transfer_currency,#from_account').on('change', performConversion)

        $('#to_account').on('change', function() {
            var exchangedFromAmount = parseFloat($('#exchangedFromAmount').val());
            var transferAmount = parseFloat($('#amount').val());
            // console.log(exchangedFromAmount)
            var transferFromAccCurrency = $('#from_account option:selected').data('currency');
            var transfertoAccCurrency = $('#to_account option:selected').data('currency');
            var transferCurrency = Number($('#transfer_currency').val());

            if (!transfertoAccCurrency) {
                toastr.warning('Selected Account has an unspecified holding Currency')
            }

            //leave the same amount to be transfered if both accounts have the same currency
            if (Number(transferFromAccCurrency) === Number(transfertoAccCurrency)) {
                $('#exchangedToAmount').val(exchangedFromAmount.toFixed(6));
            }
            if (Number(transferCurrency) === Number(transfertoAccCurrency)) {
                $('#exchangedToAmount').val(transferAmount.toFixed(6));
            } else {
                var exchangeRateToTransferAcc = getExchangeRate(defaultCurrency, transfertoAccCurrency);
                var exchangeRateFromTransferAcc = getExchangeRate(transferFromAccCurrency,
                    defaultCurrency);
                if (exchangeRateToTransferAcc == null) {
                    $('#conversion').val(0);
                    return;
                }

                const transferedAmonuntInDefaultCurrency = exchangeRateFromTransferAcc *
                    exchangedFromAmount
                const exchangedToAmount = transferedAmonuntInDefaultCurrency * exchangeRateToTransferAcc
                $("#exchangedToAmount").val((parseFloat(exchangedToAmount)).toFixed(6));
            }

        })

        $('#transfer_form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Gather form data
            var formData = $(this).serialize();
            if (Number($('#conversion').val()) === 0) {
                toastr.error(
                    'Operation failed: either of the accounts has no currency exchange rate defined'
                    )
                return;
            } else {

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success(response.msg);
                        location.reload()
                        $('#transfer_form')[0].reset();
                        $('.modal').modal('hide');
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        var errorMessage =
                        'An unexpected error occurred. Please try again.';
                        if (response && response.msg) {
                            errorMessage = response.msg;
                        }
                        toastr.error(errorMessage);
                    }
                });
            }

        });
    });
</script>
