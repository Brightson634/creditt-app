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
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <div class="float-left">
                            <h3 class="card-title">Account Information Update</h3>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.memberaccounts') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                    class="fa fa-eye"></i> View Accounts</a>
                        </div>
                    </div>
                    <form id="account_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type='hidden' name='account' value='{{$memberAccount->id}}'>
                                <div class="form-group">
                                    <label for="member_id" class="form-label">Member</label>
                                    <select class="form-control"  name="member_id" id="member_id" style="width:100%;">
                                        <option value="">select member</option>
                                        @foreach ($members as $data)
                                            <option value="{{ $data->id }}"
                                                @if ($memberAccount->member_id == $data->id) selected @endif>{{ $data->fname }}
                                                {{ $data->lname }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="accounttype_id" class="form-label">Account Type</label>
                                    <select class="form-control" name="accounttype_id" id="accounttype_id">
                                        <option value="">select account type </option>
                                        @foreach ($accounttypes as $data)
                                            <option
                                                value="{{ $data->id }}"@if ($memberAccount->accounttype_id == $data->id) selected @endif>
                                                {{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_no" class="form-label">Account No:</label>
                                    <input type="text" name="account_no" id="account_no" class="form-control"
                                        value="{{ $memberAccount->account_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    @php
                                        $account_sub_types = getParentAccounts();
                                        $accountId = $memberAccount->accounting_accounts->account_sub_type_id;
                                    @endphp
                                    <label for="accounttype_id" class="form-label">Parent Account</label>
                                    <select class="form-control" name="parent_account" id="parent_account"
                                        style="width:100%">
                                        <option value=""> </option>
                                        @foreach ($account_sub_types as $account_type)
                                            <option value="{{ $account_type->id }}"
                                                @if ($accountId == $account_type->id) selected @endif>
                                                {{ $account_type->account_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="opening_balance" class="form-label">Opening Balance</label>
                                    <input type="text" name="opening_balance"
                                        value={{ $memberAccount->opening_balance }} id="opening_balance"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fees_id" class="form-label">Applicable Fees</label>
                                    <select class="form-control select2" data-toggle="select2" name="fees_id[]" id="fees_id" style='width:100%' multiple>
                                        <option value="">select fees</option>
                                        @php
                                            $selectedFees = explode(',', $memberAccount->fees_id);
                                        @endphp
                                        @foreach ($fees as $data)
                                            <option value="{{ $data->id }}" 
                                                {{ in_array($data->id, $selectedFees) ? 'selected' : '' }}>
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="account_purpose" class="form-label">Account Purpose</label>
                                    <input type="text" name="account_purpose" value='{{$memberAccount->account_purpose}}' id="account_purpose" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="default_account" class="form-check-input"
                                        id="default_account" @if ($memberAccount->account_status == 1) checked @endif>
                                    <label class="form-check-label" for="default_account"
                                        >Set as Default Account</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary btn-theme" id="btn_account">Update
                                    Account</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="select2"]').select2();
            $('#member_id').select2({
                placeholder: 'Select Member',
            })
            $('#parent_account').select2({
                placeholder: 'Select Parent Account',
            })
            $(document).on('click','#btn_account',function(e) {
                e.preventDefault();
                $("#btn_account").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_account").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.memberaccount.update') }}',
                    method: 'post',
                    data: $('#account_form').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_account").html('Add Account');
                            $("#btn_account").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#account_form")[0].reset();
                            removeErrors("#account_form");
                            $("#btn_account").html('Add Account');
                            $("#btn_account").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);

                        }
                    }
                });
            });
        });
    </script>
@endsection
