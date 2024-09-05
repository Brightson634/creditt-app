@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
        {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <div class="float-left">
                            <h3 class="card-title">Withdraws</h3>
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-dark btn-sm btn-theme" data-toggle="modal"
                                data-target="#accountWithdrawModel">
                                <i class="fa fa-plus"></i>New withdraw
                            </button>
                            <div class="modal fade" id="accountWithdrawModel">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="card-title mb-4"> Account Withdraw Form </h4>
                                            <form action="#" method="POST" id="accountWithdrawForem">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            @php
                                                                $accounts_array = AllChartsOfAccounts();
                                                            @endphp
                                                            <label for="account_id">Account</label>
                                                            <select name="account_id"
                                                                class="form-control accounts-dropdown account_id"
                                                                style="width: 100%;">
                                                                <option value=''>Select Account</option>
                                                                @foreach ($accounts_array as $account)
                                                                    <option value="{{ $account['id'] }}"
                                                                        data-currency="{{ $account['currency'] }}">
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
                                                            <select class="form-control" name="paymenttype_id"
                                                                id="paymenttype_id">
                                                                <option value="">select payment type </option>
                                                                @foreach ($payments as $data)
                                                                    <option value="{{ $data->id }}">{{ $data->name }}
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
                                                            <input type="text" name="amount" id="amount"
                                                                class="form-control">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="depositor">Withdrawer</label>
                                                            <input type="text" name="withdrawer" id="withdrawer"
                                                                class="form-control">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="date" class="form-label">Transaction
                                                                Date</label>
                                                            <input type="text" name="date" class="form-control"
                                                                data-provide="datepicker" data-date-autoclose="true"
                                                                data-date-format="yyyy-mm-dd" id="date"
                                                                value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                                            <span class="invalid-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger btn-sm btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-sm btn-theme"
                                                        id="btn_accountwithdraw">Withdraw</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($withdraws->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Account</th>
                                        <th>Payment Type</th>
                                        <th>Withdrawer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdraws as $row)
                                        <tr>
                                            <td>{{ dateFormat($row->date) }}</td>
                                            <td>{!! showAmount($row->amount) !!}</td>
                                            <td>{{ $row->memberAccount->account_no }}</td>
                                            <td>{{ $row->paymenttype->name }}</td>
                                            <td>{{ $row->withdrawer }}</td>
                                            <td>
                                                <a href="#" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i>
                                                    view</a>
                                            </td>
                                        <tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center mt-5">
                            <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                            <span class="mt-3">No Data</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".account_id").select2({
                placeholder: "Select an account",
                allowClear: true,
                dropdownParent: $('#accountWithdrawModel')
            })
            $("#accountWithdrawForem").submit(function(e) {
                e.preventDefault();
                $("#btn_accountwithdraw").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_accountwithdraw").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.accountwithdraw.store') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            if(response.overdraft){
                                return toastr.error(response.overdraft)
                            }
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                                toastr.error(value);
                            });
                            $("#btn_accountwithdraw").html('Make withdraw');
                            $("#btn_accountwithdraw").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#accountWithdrawForem")[0].reset();
                            removeErrors("#accountWithdrawForem");
                            $("#btn_accountwithdraw").html('Make Withdraw');
                            $("#btn_accountwithdraw").prop("disabled", false);
                            setTimeout(function() {
                                window.location.reload(true);
                            }, 1000);

                        }
                    },
                    error:function(xhr){
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endsection
