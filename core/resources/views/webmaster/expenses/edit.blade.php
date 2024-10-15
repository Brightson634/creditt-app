@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading">
        {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
    </div>
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <div class="float-left">
                            <h3 class="card-title">Edit Expense Information</h3>
                        </div>
                        <div class="float-right">
                            @can('view_expenses')
                                <a href="{{ route('webmaster.expense.update') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                        class="fa fa-eye"></i> View Expenses</a>
                            @endcan
                        </div>
                    </div>
                    <form action="#" method="POST" id="expense_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Expense</label>
                                    <input type="text" name="name" id="name" value="{{ $expense->name }}"
                                        class="form-control" placeholder='Provide name'>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <input type='hidden' name="id" value="{{$expense->id}}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subcategory_id">Expense Category</label>
                                    <select class="form-control" id="subcategory_id" name="subcategory_id">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <optgroup label="{{ $category->name }}"
                                                @if ($expense->category_id == $category->id) selected @endif>
                                                @php
                                                    $subcategories = \App\Models\ExpenseCategory::where('is_subcat', 1)
                                                        ->where('parent_id', $category->id)
                                                        ->get();
                                                @endphp
                                                @foreach ($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}"
                                                        @if ($expense->subcategory_id == $subcategory->id) selected @endif>
                                                        {{ $subcategory->name }}</option>
                                                @endforeach
                                            </optgroup>
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
                                                @if ($expense->paymenttype_id == $data->id) selected @endif>{{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" value="{{ $expense->amount }}" name="amount" id="amount"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount" class="form-label">Amount Currency</label>
                                    <select name="amount_currency" id="amount_currency" class="form-control">
                                        <option value="">Please Select Payment Currency</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}"
                                                @if ($expense->currency_id == $currency->id) selected @endif>{{ $currency->country }}
                                                - {{ $currency->currency }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{-- <label>Converted Amount</label> --}}
                                    <input type="number" hidden name="exchangedAmount" id="exchangedAmount"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_id" class="form-label">Account</label>
                                    <select name="account_id" class="form-control accounts-dropdown account_id"
                                        style="width: 100%;">
                                        <option value=''>Select Account</option>
                                        @foreach ($accounts_array as $account)
                                            <option value="{{ $account['id'] }}"
                                                data-currency="{{ $account['currency'] }}" @if($expense->account_id == $account['id'] ) selected @endif>{{ $account['name'] }}
                                                -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Date</label>
                                    <input type="text" name="date" class="form-control" data-provide="datepicker"
                                        data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="date"
                                        value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control" rows="2">{{$expense->description}}</textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="number" hidden class='form-control' name='conversion' id='conversion'>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-theme" id="btn_expense">Update
                                    Expense</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $("#expense_form").submit(function(e) {
            e.preventDefault();
            $("#btn_expense").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
            $("#btn_expense").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.expense.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_expense").html('Update Expense');
                        $("#btn_expense").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#expense_form")[0].reset();
                        removeErrors("#expense_form");
                        $("#btn_expense").html('Update Expense');
                        $("#btn_expense").prop("disabled", false);
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 1000);

                    }
                },
                error: function(jxhr) {
                    console.log(jxhr)
                    toastr.error('Unexpected error');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("select.accounts-dropdown").select2({
                placeholder: 'Select Account',
                searchInputPlaceholder: 'Search'
            });
            $("select#amount_currency").select2({
                placeholder: 'Choose payment currency',
                searchInputPlaceholder: 'Search'
            });

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
                var paymentCurrency = $('#amount_currency').val();
                var accountCurrency = $('.account_id option:selected').data('currency');
                //   if(!accountCurrency || !paymentCurrency)
                //   {
                //    toastr.warning('Selected Account has an unspecified holding Currency')
                //   }
                if (!amount || !paymentCurrency || !accountCurrency) {
                    $('#exchangedAmount').val('');
                    $('#conversion').val(0);
                    return;
                }

                var convertedAmount = amount;

                // Step 1: Check if payment currency is the same as default system currency
                if (Number(paymentCurrency) === Number(defaultCurrency)) {
                    // Convert to account currency
                    convertedAmount = convertCurrency(amount, defaultCurrency, accountCurrency);
                } else {
                    // Convert payment currency to default system currency
                    var amountInDefaultCurrency = convertCurrency(amount, Number(paymentCurrency), Number(
                        defaultCurrency));

                    if (amountInDefaultCurrency !== null) {
                        // Convert from default system currency to account currency
                        convertedAmount = convertCurrency(amountInDefaultCurrency, Number(defaultCurrency), Number(
                            accountCurrency));
                        console.log(convertedAmount);
                    } else {
                        $('#conversion').val(0);
                        return;
                    }
                }

                if (convertedAmount !== null) {
                    $('#exchangedAmount').val(convertedAmount.toFixed(2));
                    $('#conversion').val(1);
                } else {
                    //leave amount if both payment currency and account currency are the same
                    if (Number(paymentCurrency) === Number(accountCurrency)) {
                        $('#exchangedAmount').val(amount.toFixed(2))
                    }
                    toastr.warning('No exchange rate defined for the payment currency')
                }
            }

            $('#amount, #amount_currency, .account_id').on('change', performConversion)

        });
    </script>
@endsection
