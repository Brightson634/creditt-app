@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading">

    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    @include('webmaster.loans.loancommon')
                    <hr>
                    @php
                        $status = loanAlreadyDisbursed($loan->id);
                    @endphp
                    @if (!$status)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="mb-3"><strong>Disbursement Notes</strong></h5>
                                <form action="#" method="POST" id="disburse_form">
                                    @csrf
                                    <input type="hidden" name="loan_id" class="form-control" value="{{ $loan->id }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <textarea name="notes" class="form-control" id="notes" rows="4"
                                                    placeholder="writer your notes about the loan"></textarea>
                                                <span class="invalid-feedback"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <h3>Loan Disbursement Details</h3>
                                    <section>
                                        <div class="card p-4 shadow-sm">
                                            <p class="text-muted">The following Loan Account number
                                                will automatically be created for the member for disbursement of
                                                funds</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="account_no" class="form-label">Loan Account No:</label>
                                                        <input type="text" name="loan_account_no" id="loan_account_no"
                                                            class="form-control" value="{{ $loan->loan_no }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        @php
                                                            $account_sub_types = getParentAccounts();
                                                        @endphp
                                                        <label for="accounttype_id" class="form-label">Parent Account
                                                        </label>
                                                        <select class="form-control" name="parent_id" id="parent_id"
                                                            style='width:100%'>
                                                            <option value=""> </option>
                                                            @foreach ($account_sub_types as $account_type)
                                                                <option value="{{ $account_type->id }}">
                                                                    {{ $account_type->account_type_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    @php
                                        $accounts_array = AllChartsOfAccounts();
                                    @endphp
                                    <section>
                                        <div class="card p-4 shadow-sm">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="staff_member_id" class="form-label">Assign Loan
                                                            Officers</label>
                                                        @php
                                                            $staff_members = App\Models\StaffMember::all();
                                                        @endphp
                                                        <select name="staff_member[]" class="form-control staff-dropdown"
                                                            id="staff_member" style="width: 100%;" multiple>
                                                            <option value=''>Select Staff Member</option>
                                                            @foreach ($staff_members as $staff_member)
                                                                <option value="{{ $staff_member->id }}">
                                                                    {{ $staff_member->fname }} - {{ $staff_member->lname }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="accounttype_id" class="form-label">Disbursement
                                                            Account</label>
                                                        <select name="disbursement_account"
                                                            class="form-control accounts-dropdown" id='disbursement_account'
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
                                            </div>
                                        </div>
                                    </section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="mt-2">
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="approve" name="status"
                                                            class="custom-control-input" value="5" checked>
                                                        <label class="custom-control-label" for="approve">DISBURSE
                                                            LOAN</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="reject" name="status"
                                                            class="custom-control-input" value="6">
                                                        <label class="custom-control-label" for="reject">CANCEL
                                                            LOAN</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-indigo btn-theme"
                                                id="btn_disburse">Disburse/Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="container">
                            <p class='text-muted'>Loan already disbursed</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection

    {{-- @php
$officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)->get();
@endphp --}}
    @section('scripts')
        <script type="text/javascript">
            "use strict";
            $("#staff_member").select2({
                placeholder: 'Select Loan Officers'
            })
            $("#parent_id").select2({
                placeholder: 'Select Parent Account'
            })
            $('#disbursement_account').select2({
                placeholder: 'Select  Account from which to disburse funds'
            })
            $("#disburse_form").submit(function(e) {
                e.preventDefault();
                $("#btn_disburse").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
                $("#btn_disburse").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.loan.disburse.store') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_disburse").html('Disburse/Cancel');
                            $("#btn_disburse").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#disburse_form")[0].reset();
                            removeErrors("#disburse_form");
                            $("#btn_disburse").html('Disburse/Cancel');
                            $("#btn_disburse").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);

                        }
                    },
                    error: function(xhr) {
                        $("#btn_disburse").html('Disburse/Cancel')
                        $("#btn_disburse").prop("disabled", false);
                        toastr.error('Something went wrong!')
                    }
                });
            });
        </script>
    @endsection
