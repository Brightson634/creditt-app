@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>

    </style>
@endsection
@section('content')
    @include('webmaster.partials.generalheader')
    <form action="{{ route('webmaster.loan.store') }}" method="POST" id="loan_form" enctype="multipart/form-data">
        @csrf
        <div id="wizard1">
            <h3>Loan Application</h3>
            <section>
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix mb-3">
                                    <div class="float-left">
                                        <h3 class="card-title">Loan Information</h3>
                                    </div>
                                    <div class="float-right">
                                        <a href="{{ route('webmaster.loans') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                                class="fa fa-eye"></i>
                                            View Loans</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="loan_no" class="form-label">Loan No:</label>
                                            <input type="text" name="loan_no" id="loan_no" class="form-control"
                                                value="{{ $loan_no }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="loan_type" class="form-label">Loan Type</label>
                                            <select class="form-control" name="loan_type" id="loan_type">
                                                <option value="">select loan type</option>
                                                <option value="individual">Individual Loan</option>
                                                <option value="group">Group Loan</option>
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 memberDiv">
                                        <div class="form-group">
                                            <label for="loan_member_id" class="form-label">Member</label>
                                            <select class="form-control loan_member_id" name="loan_member_id"
                                                id="loan_member_id">
                                                <option value="">select member</option>
                                                @foreach ($members as $data)
                                                    <option value="{{ $data->id }}">{{ $data->fname }} -
                                                        {{ $data->lname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                            <span class="member-feedback"></span>
                                            <input type='number'hidden value='1' name='member_loan_status'
                                                id=member_loan_status>
                                        </div>
                                        <input type='hidden' value='' class='form-control' id='memberAccBalance'>
                                    </div>
                                    <div class="col-md-4 groupDiv" style="display: none;">
                                        <div class="form-group">
                                            <label for="group_id" class="form-label">Group</label>
                                            <select class="form-control loan_member_id" name="group_id" id="group_id">
                                                <option value="">select group</option>
                                                @foreach ($groups as $data)
                                                    <option value="{{ $data->id }}">{{ $data->fname }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="principal_amount" class="form-label">Principal Amount</label>
                                            <input type="text" name="principal_amount" id="principal_amount"
                                                class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="loanproduct_id" class="form-label">Loan Product</label>
                                            <select class="form-control loanProduct" name="loanproduct_id"
                                                id="loanproduct_id">
                                                <option value="">select loan product</option>
                                                @foreach ($loanproducts as $data)
                                                    <option value="{{ $data->id }}" data-min="{{ $data->min_amount }}"
                                                        data-max="{{ $data->max_amount }}"
                                                        data-duration="{{ $data->duration }}"
                                                        data-interestvalue="{{ $data->interest_value }}"
                                                        data-minbalance="{{ $data->cust_acc_balance }}">
                                                        {{ $data->name }} -
                                                        @if ($data->duration == 'day')
                                                            DAILY
                                                        @endif
                                                        @if ($data->duration == 'week')
                                                            WEEKLY
                                                        @endif
                                                        @if ($data->duration == 'month')
                                                            MONTHLY
                                                        @endif
                                                        @if ($data->duration == 'year')
                                                            YEARLY
                                                        @endif - {{ $data->interest_rate }}%
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="loan_period" class="form-label">Loan Term/Period</label>
                                            <div class="input-group">
                                                <input type="text" name="loan_period" id="loan_period"
                                                    class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="duration_plan"></span>
                                                </div>
                                                <span class="invalid-feedback"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="interest_amount" class="form-label">Interest Amount</label>
                                            <input type="text" name="interest_amount" id="interest_amount"
                                                class="form-control" readonly>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="repayment_amount" class="form-label">Loan Repayment
                                                Amount</label>
                                            <input type="text" name="repayment_amount" id="repayment_amount"
                                                class="form-control" readonly>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label">Loan End Date</label>
                                            <input type="text" name="end_date" id="end_date" class="form-control"
                                                readonly>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loanMaturityDate">Loan Maturity Date</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker"
                                                    id="loanMaturityDate" name="loan_maturity_date"
                                                    placeholder="Select loan maturity date" data-toggle="datetimepicker">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gracePeriodType">Grace Period</label>
                                            <div class="input-group">
                                                <select class="form-control" id="gracePeriodType"
                                                    name="grace_period_type">
                                                    <option value="">Select period type</option>
                                                    <option value="days">Days</option>
                                                    <option value="weeks">Weeks</option>
                                                    <option value="months">Months</option>
                                                </select>
                                                <input type="number" class="form-control d-none" id="gracePeriodValue"
                                                    name="grace_period_value" placeholder="Enter value">
                                                <div class="input-group-append d-none" id="gracePeriodAppend">
                                                    <span class="input-group-text" id="gracePeriodText">Days</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="fees_id" class="form-label">Applicable Fees</label>
                                            <select class="form-control select2" data-toggle="select2"
                                                multiple="multiple" name="fees_id[]" id="fees_id">
                                                <option></option>
                                                @foreach ($fees as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fees_total" class="form-label">Fees Total</label>
                                            <input type="text" name="fees_total" id="fees_total" class="form-control"
                                                readonly>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="payment_mode" class="form-label">Payment Mode</label>
                                            <select class="form-control" name="payment_mode" id="payment_mode">
                                                <option value="">select payment option</option>
                                                <option value="cash">Cash Payment</option>
                                                <option value="savings">Saving Account</option>
                                                <option value="loan">Loan Principal</option>
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 cashDiv" style="display: none;">
                                        <div class="form-group">
                                            <label for="cash_amount" class="form-label">Cash Amount</label>
                                            <input type="text" name="cash_amount" id="cash_amount"
                                                class="form-control" readonly>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 savingDiv" style="display: none;">
                                        <div class="form-group">
                                            <label for="account_id" class="form-label">Account No</label>
                                            <select name="account_id" class="form-control account_id" id="account_id">
                                                <option value="">select account number</option>
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 loanDiv" style="display: none;">
                                        <div class="form-group">
                                            <label for="loan_principal" class="form-label">Loan Principal</label>
                                            <input type="text" name="loan_principal" id="loan_principal"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <h3>Guarantors</h3>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Radio Buttons for Membership Status -->
                        <div class="form-group row">
                            <label for="is_member" class="col-sm-3 col-form-label">Is a Member</label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="yes" name="is_member" class="custom-control-input"
                                        value="1" checked>
                                    <label class="custom-control-label" for="yes">YES</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="no" name="is_member" class="custom-control-input"
                                        value="0">
                                    <label class="custom-control-label" for="no">NO</label>
                                </div>
                            </div>
                        </div>

                        <!-- Member Details Section (Visible when 'YES' is selected) -->
                        <div id="yesMember" class="form-section">
                            <div class="form-group">
                                <label for="member_id" class="form-label">Members</label>
                                <select class="form-control memberSelection" style="width: 75%" name="member_id[]"
                                    id="member_id" multiple="multiple">
                                    <option value="">Select members</option>
                                    @foreach ($members as $data)
                                        @if ($data->member_type == 'individual')
                                            <option value="{{ $data->id }}">{{ $data->fname }} -
                                                {{ $data->lname }}</option>
                                        @endif
                                        @if ($data->member_type == 'group')
                                            <option value="{{ $data->id }}">{{ $data->fname }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>

                        <!-- Non-Member Details Section (Visible when 'NO' is selected) -->
                        <div id="noMember" class="form-section" style="display:none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Names:</label>
                                        <input type="text" name="non_member_names[]" class="form-control"
                                            placeholder="Enter name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="non_member_emails[]" class="form-control"
                                            placeholder="Enter email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telephone" class="form-label">Telephone</label>
                                        <input type="text" name="non_member_telephones[]" class="form-control"
                                            placeholder="Enter telephone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="occupation" class="form-label">Occupation</label>
                                        <input type="text" name="non_member_occupations[]" class="form-control"
                                            placeholder="Enter occupation">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="non_member_addresses[]" class="form-control" rows="2" placeholder="Enter address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addNonMember" class="btn btn-primary">Add Another
                                Non-Member</button>
                            <div id="nonMemberList" class="mt-3"></div>
                        </div>
                        <!-- Non-Member Details Section (Visible when 'NO' is selected) -->
                        <div id="noMember" class="form-section" style="display:none;">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Names:</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Telephone:</label>
                                    <input type="text" name="telephone" id="telephone" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="occupation" class="form-label">Occupation:</label>
                                    <input type="text" name="occupation" id="occupation" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="form-label">Address:</label>
                                <textarea name="address" class="form-control" id="address" rows="2"></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <h3>Collaterals</h3>
            <section>
                @php
                    $collateralMethods = getLoanCollateralMethods();
                    $bothMethods = false;
                    if (
                        in_array('min_balance', $collateralMethods) &&
                        in_array('collateral_items', $collateralMethods)
                    ) {
                        $bothMethods = true;
                    }

                @endphp
                <div id="collateralContainer">
                    <!-- Initial Collateral Template (No Remove Button) -->
                    <div class="card shadow-sm p-3 mb-4 rounded collateral-item" data-index="0">
                        <h5 class="card-title">Add Collateral</h5>

                        <!-- Collateral Item Select Field -->
                        <div class="form-group">
                            <label for="collateralItem">Collateral Item</label>
                            <select class="form-control select2" name="collateral_item[0]">
                                <option value="" disabled selected>Select Collateral Item</option>
                                @foreach ($collateral_items as $data)
                                    @if ($bothMethods || $data->name != 'Minimum Account Balance')
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Collateral Name -->
                        <div class="form-group">
                            <label for="collateralName">Collateral Name</label>
                            <input type="text" class="form-control" name="collateral_name[0]"
                                placeholder="Enter collateral name">
                        </div>

                        <!-- Estimated Value -->
                        <div class="form-group">
                            <label for="estimatedValue">Estimated Value</label>
                            <input type="number" class="form-control" id='estimated_value' name="estimated_value[0]"
                                placeholder="Enter estimated value">
                        </div>

                        <!-- Collateral Remarks -->
                        <div class="form-group">
                            <label for="collateralRemarks">Collateral Remarks</label>
                            <textarea class="form-control" name="collateral_remarks[0]" rows="3" placeholder="Enter remarks"></textarea>
                        </div>

                        <!-- Collateral Photos with Preview -->
                        <div class="form-group">
                            <label for="collateralPhotos">Collateral Photos</label>
                            <input type="file" class="form-control-file collateralPhotos"
                                name="collateral_photos[0][]" accept="image/*" multiple>
                            <div class="mt-3 photoPreviews" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <!-- Add Button -->
                    <div class="col-md-6">
                        <button type="button" id="addCollateral" class="btn btn-primary mb-3">Add Another
                            Collateral</button>
                    </div>
                </div>

            </section>
            <h3>Documents</h3>
            <section>
                <div class="card p-4 shadow-sm">
                    <h3 class="card-title mb-4 text-center">Upload Loan Documents/Photos</h3>
                    <div class="form-group mb-4 text-center">
                        <div class="image-upload image-uploadx">
                            <div class="thumb thumbx position-relative d-inline-block" id="image-preview-container">
                            </div>
                            <div class="upload-file mt-3">
                                <input type="file" name="photos[]" class="form-control-file d-none file-upload"
                                    id="photo" multiple>
                                <label for="photo" class="btn btn-secondary btn-block text-white">
                                    <i class="fas fa-upload"></i> Upload Photos
                                </label>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6 d-flex justify-content-center mb-3 mb-md-0">
                        {{-- <button type="submit" class="btn btn-outline-indigo btn-theme btn-lg" id="btn_save_draft">
                            Save as Draft
                        </button> --}}
                    </div>
                </div>

            </section>
            <h3>Loan Account Details</h3>
            <section>
                <div class="row">
                    <div class='container'>
                        <spanc class='text-danger'><sup>*</sup></span>
                            <p class="text-muted">The following Loan Account number
                                will automatically be created for the member for disbursement of funds</p>
                    </div>
                </div>
                <div class="card p-4 shadow-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account_no" class="form-label">Loan Account No:</label>
                                <input type="text" name="loan_account_no" id="loan_account_no" class="form-control"
                                    value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @php
                                    $account_sub_types = getParentAccounts();
                                @endphp
                                <label for="accounttype_id" class="form-label">Parent Account </label>
                                <select class="form-control" name="parent_id" id="parent_id" style='width:100%'>
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
                <div class="row mt-4">
                    <div class="col-md-6 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-theme btn-lg" id="btn_loan">
                            Submit Loan Application
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            "use strict";
            $('[data-toggle="select2"]').select2({
                placeholder: 'Choose Fees',
                searchInputPlaceholder: 'Search',
                allowClear: true,
                dropdownParent: $('#wizard1'),
            });

            $('#loanMaturityDate').datepicker({
                autoclose: true,
                startDate: new Date(),
            });

            $('#gracePeriodType').on('change', function() {
                let selectedType = $(this).val();

                if (selectedType) {
                    // Show the input field and update the text
                    $('#gracePeriodValue').removeClass('d-none');
                    $('#gracePeriodAppend').removeClass('d-none');
                    $('#gracePeriodText').text(selectedType.charAt(0).toUpperCase() + selectedType.slice(
                        1));
                } else {
                    // Hide the input field if no type is selected
                    $('#gracePeriodValue').addClass('d-none');
                    $('#gracePeriodAppend').addClass('d-none');
                }
            });


            // Initialize Select2 on the multi-select dropdown
            $('.memberSelection').select2({
                dropdownParent: $('#wizard1'),
                placeholder: 'Select members',
                allowClear: true
            })
            $('#parent_id').select2({
                dropdownParent: $('#wizard1'),
                placeholder: 'Select Parent Account for this Loan Account',
                allowClear: true
            })
            $('#loan_member_id').select2({
                dropdownParent: $('#wizard1'),
                placeholder: 'Select Member',
                allowClear: true
            })

            // Toggle visibility of member and non-member sections
            $('input[name="is_member"]').on('change', function() {
                if ($(this).val() === '1') {
                    $('#yesMember').show();
                    $('#noMember').hide();
                } else {
                    $('#yesMember').hide();
                    $('#noMember').show();
                }
            }).filter(':checked').trigger('change');


            $("#loan_account_no").val($('#loan_no').val());


            // Add new non-member entry
            $('#addNonMember').on('click', function() {
                var newEntry = `
                    <div class="non-member-entry mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Names:</label>
                                    <input type="text" name="non_member_names[]" class="form-control" placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="non_member_emails[]" class="form-control" placeholder="Enter email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" name="non_member_telephones[]" class="form-control" placeholder="Enter telephone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="occupation">Occupation</label>
                                    <input type="text" name="non_member_occupations[]" class="form-control" placeholder="Enter occupation">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="non_member_addresses[]" class="form-control" rows="2" placeholder="Enter address"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger removeNonMember">Remove</button>
                    </div>
                `;
                $('#nonMemberList').append(newEntry);
            });

            // Remove non-member entry
            $('#nonMemberList').on('click', '.removeNonMember', function() {
                $(this).closest('.non-member-entry').remove();
            });

            var collateralIndex = $('#collateralContainer .collateral-item')
                .length; // Initialize based on existing items

            function updatePhotoPreview(input, previewContainer) {
                $(input).off('change').on('change', function(
                    event) { // Unbind previous event handler and bind a new one
                    var files = event.target.files;
                    $(previewContainer).html(''); // Clear previous previews
                    $.each(files, function(index, file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var img = $('<img>').attr('src', e.target.result)
                                .addClass('img-fluid')
                                .css({
                                    'max-height': '150px',
                                    'margin': '10px',
                                    'border-radius': '8px'
                                });
                            $(previewContainer).append(img);
                        };
                        reader.readAsDataURL(file);
                    });
                });
            }

            // Initialize photo preview for existing inputs
            $('.collateralPhotos').each(function() {
                updatePhotoPreview(this, $(this).next('.photoPreviews'));
            });

            // Add new collateral section
            $('#addCollateral').click(function() {
                var newCollateral = $('.collateral-item:first').clone();
                newCollateral.find('input, select, textarea').val('');
                newCollateral.find('.photoPreviews').html(''); // Clear previews

                // Update unique IDs and names for cloned elements
                newCollateral.attr('data-index', collateralIndex);
                newCollateral.find('input, select, textarea').each(function() {
                    var name = $(this).attr('name');
                    var id = $(this).attr('id');
                    if (name) {
                        name = name.replace(/\[\d+\]/, '[' + collateralIndex + ']');
                        $(this).attr('name', name);
                    }
                    if (id) {
                        id = id.replace(/\d+/, collateralIndex);
                        $(this).attr('id', id);
                    }
                });

                // Add remove button to new collateral
                newCollateral.append(
                    '<button type="button" class="btn btn-danger remove-collateral mt-3">Remove</button>'
                );

                // Append to container
                $('#collateralContainer').append(newCollateral);

                // Initialize photo preview for the new input
                updatePhotoPreview(newCollateral.find('.collateralPhotos')[0], newCollateral.find(
                    '.photoPreviews'));

                // Increment index for the next clone
                collateralIndex++;
            });

            // Remove collateral section
            $(document).on('click', '.remove-collateral', function() {
                $(this).closest('.collateral-item').remove();
            });

            // Handle image input change dynamically
            $(document).on('change', '.collateralPhotos', function() {
                updatePhotoPreview(this, $(this).next('.photoPreviews'));
            });

            // Handle photo preview for main photo input
            $('#photo').on('change', function() {
                previewImages(this);
            });

            function previewImages(input) {
                let previewContainer = $('#image-preview-container');
                previewContainer.empty(); // Clear existing previews

                if (input.files) {
                    $.each(input.files, function(i, file) {
                        let reader = new FileReader();

                        reader.onload = function(e) {
                            let imgElement = $('<img>').attr('src', e.target.result).addClass(
                                'rounded shadow-sm m-2');
                            imgElement.css({
                                width: '100px',
                                height: '100px',
                                objectFit: 'cover'
                            });
                            previewContainer.append(imgElement);
                        }

                        reader.readAsDataURL(file); // Read the uploaded file
                    });
                }
            }

            // Getting member account minimum balance info
            $('#loan_member_id,#group_id').on('change', function() {
                const memberId = $(this).val();

                $.ajax({
                    url: "{{ route('webmaster.member.accountbal') }}",
                    method: 'POST',
                    data: {
                        member_id: memberId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log(response);
                        if(response.data)
                        {
                            $('#memberAccBalance').val(response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            //dealing with minimum account balance
            $('select[name="collateral_item[0]"]').on('change', function() {
                var selectedText = $(this).find('option:selected').text();
                if (selectedText === 'Minimum Account Balance') {
                    const memberAccBalance = parseFloat($('#memberAccBalance').val())
                    var selectedOption = $('#loanproduct_id').find('option:selected');
                    var minBalance = parseFloat(selectedOption.data('minbalance'));
                    if(memberAccBalance > minBalance){
                        $('#estimated_value').val(parseFloat(memberAccBalance))
                    }else{
                        toastr.warning('The member account balance is lesser than minimum balance for this product')
                    }
                  
                } 
            });

            $('#loanproduct_id').change(function() {
                let selectedOption = $(this).find(':selected');
                let duration = selectedOption.data("duration");
                let durationSpan = $("#duration_plan");
                if (duration === 'day') {
                    durationSpan.text('Days');
                } else if (duration === 'week') {
                    durationSpan.text('Weeks');
                } else if (duration === 'month') {
                    durationSpan.text('Months');
                } else if (duration === 'year') {
                    durationSpan.text('Years');
                } else {
                    durationSpan.text('');
                }
            });

            $('#loanproduct_id, #principal_amount, #loan_period').on('input', function() {
                let selectedOption = $('#loanproduct_id').find(':selected');
                let duration = selectedOption.data("duration");
                let interest_value = selectedOption.data("interestvalue");
                let principal_amount = parseFloat($('#principal_amount').val()) || 0;
                let loan_period = parseFloat($('#loan_period').val()) || 0;
                let interest_rate = parseFloat(selectedOption.text().split('-')[1]) || 0;
                let interest_amount = 0;
                let repayment_amount = 0;
                let end_date = new Date();

                if (duration === 'day') {
                    interest_amount = interest_value * principal_amount * loan_period;
                    repayment_amount = principal_amount + interest_amount;
                    end_date = new Date();
                    end_date.setDate(end_date.getDate() + loan_period);
                } else if (duration === 'week') {
                    interest_amount = interest_value * principal_amount * (loan_period * 7);
                    repayment_amount = principal_amount + interest_amount;
                    end_date = new Date();
                    end_date.setDate(end_date.getDate() + (loan_period * 7));
                } else if (duration === 'month') {
                    interest_amount = interest_value * principal_amount * loan_period;
                    repayment_amount = principal_amount + interest_amount;
                    end_date = new Date();
                    end_date.setMonth(end_date.getMonth() + loan_period);
                } else if (duration === 'year') {
                    interest_amount = interest_value * principal_amount * loan_period;
                    repayment_amount = principal_amount + interest_amount;
                    end_date = new Date();
                    end_date.setFullYear(end_date.getFullYear() + loan_period);
                }

                let formatted_end_date = end_date.getFullYear() + '-' + (end_date.getMonth() + 1).toString()
                    .padStart(2,
                        '0') + '-' + end_date.getDate().toString().padStart(2, '0');

                $('#interest_amount').val(isNaN(interest_amount) ? '' : interest_amount);
                $('#repayment_amount').val(isNaN(repayment_amount) ? '' : repayment_amount);
                $('#end_date').val(formatted_end_date);
            });

            $('#fees_id').change(function() {
                let selectedFeesIds = $('#fees_id option:checked').map(function() {
                    return $(this).val();
                }).get();
                let principalAmount = parseFloat($('#principal_amount').val()) || 0;
                calculateFeesTotal(selectedFeesIds, principalAmount);
            });

            $('#principal_amount').on('input', function() {
                let principalAmount = $(this).val();
                $('#loan_principal').val(principalAmount);
                let selectedFeesIds = ['0'];
                calculateFeesTotal(selectedFeesIds, principalAmount);
            });

            function calculateFeesTotal(selectedFeesIds, principalAmount) {
                //var selectedFeesIds = $('#fees_id option:checked').map(function() {
                //return $(this).val();
                //}).get();
                //let principalAmount = parseFloat($('#principal_amount').val()) || 0;

                $.ajax({
                    url: '{{ route('webmaster.loan.feescalculate') }}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        'fees_id': selectedFeesIds,
                        'principal_amount': principalAmount
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#fees_total').val(data.fees_total.toFixed(2));
                        $('#cash_amount').val(data.fees_total.toFixed(2));
                    },
                    error: function(data) {
                        //
                    }
                });
            }

            $('#loan_type').change(function() {
                let loan_type = $(this).val();
                if (loan_type == 'member') {
                    $('.memberDiv').show();
                    $('.groupDiv').hide();
                } else if (loan_type == 'group') {
                    $('.memberDiv').hide();
                    $('.groupDiv').show();
                } else {
                    $('.memberDiv').show();
                    $('.groupDiv').hide();
                }
            });

            $('#payment_mode').change(function() {
                let payment_mode = $(this).val();
                if (payment_mode == 'cash') {
                    let feesTotal = parseFloat($('#fees_total').val()) || 0;
                    $('#cash_amount').val(feesTotal);
                    $('.cashDiv').show();
                    $('.savingDiv').hide();
                    $('.loanDiv').hide();
                } else if (payment_mode == 'savings') {
                    $('.cashDiv').hide();
                    $('.savingDiv').show();
                    $('.loanDiv').hide();
                } else if (payment_mode == 'loan') {
                    $('.cashDiv').hide();
                    $('.savingDiv').hide();
                    $('.loanDiv').show();
                } else {
                    $('.cashDiv').hide();
                    $('.savingDiv').hide();
                    $('.loanDiv').hide();
                }
            });

            $('loan_member_id').change(function() {
                var member_id = $(this).val();
                let url = `${baseurl}/webmaster/saving/getaccounts/${member_id}`;
                $.get(url, function(response) {
                    $(".account_id").html(response);
                });
            });




            $("#loan_form").submit(function(e) {
                e.preventDefault();
                if ($('#member_loan_status').val() != 1) {
                    toastr.warning('Member has existing loan')
                    return;
                }
                var formData = new FormData(this);

                // Disable the submit button and add spinner (optional)
                // $("#btn_loan").html(
                //     '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                // );
                // $("#btn_loan").prop("disabled", true);
                if (checkPrincipalMinAndMaxAmount()) {
                    var formData = new FormData(this);
                    $.ajax({
                        url: '{{ route('webmaster.loan.store') }}',
                        method: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.status == 400) {
                                $.each(response.message, function(key, value) {
                                    showError(key, value);
                                    toastr.error(value, key.charAt(0).toUpperCase() +
                                        key.slice(1));
                                });
                                $("#btn_loan").html('Submit Loan Application');
                                $("#btn_loan").prop("disabled", false);
                            } else if (response.status == 200) {
                                // Show success alert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Loan application submitted successfully!',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(function() {
                                    window.location.href = response.url;
                                });
                            }
                            toastr.warning()
                        }
                    });
                } else {
                    $("#btn_loan").html('Submit Loan Application');
                    $("#btn_loan").prop("disabled", false);
                }
            });


            const checkPrincipalMinAndMaxAmount = () => {
                let principal_amount = parseFloat($('#principal_amount').val()) || 0;
                // Get the selected option
                var selectedOption = $("#loanproduct_id").find('option:selected');

                // Get data-min and data-max attributes
                var minLoanAmount = Number(selectedOption.data('min'));
                var maxLoanAmount = Number(selectedOption.data('max'));


                if (principal_amount > maxLoanAmount) {
                    toastr.error(`The principal amount cannot exceed ${maxLoanAmount} for this product`)
                    return false
                } else if (principal_amount < minLoanAmount) {
                    toastr.error(`The principal amount cannot be less than ${minLoanAmount} for this product`)
                    return false
                } else {
                    return true
                }

            }

            //check whether member has an existing loan application
            $('#loan_member_id').on('change', function() {
                const member_id = $(this).val();
                $('.member-feedback').text('')
                $('#member_loan_status').val(1);
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('webmaster.loan.memberid') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        member: member_id,
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.warning('This member has a loan already in the system!')
                            $('.member-feedback').text(
                                'This member has a loan already in the system!').css(
                                'color', 'red');
                            $('#member_loan_status').val(0)
                        }
                    },
                    error: function(xhr, status, error) {
                        // toastr.error('Unable to create unique Id')
                        console.error('AJAX request failed:', error);
                    }
                });

            })
        });
    </script>
@endsection
