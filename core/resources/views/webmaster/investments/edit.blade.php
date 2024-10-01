@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    @include('webmaster.partials.generalheader')
    {{-- <div id="wizard1">
        <h3>New Investment Creation</h3>
        <section>
       
        </section>
        <h3>Billing Information</h3>
        <section>
            <p class="mg-b-0">Wonderful transition effects.</p>
        </section>
        <h3>Payment Details</h3>
        <section>
            <p class="mg-b-0">The next and previous buttons help you to navigate through your content.</p>
        </section>
    </div> --}}
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
                            <h3 class="card-title">Edit Investment Information</h3>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.investments') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                    class="fa fa-eye"></i> View Investments</a>
                        </div>
                    </div>
                    <form action="#" method="POST" id="investment_form">
                        @csrf
                        <input type='hidden' name='id' value="{{$investment->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="investment_no" class="form-label">Investment No.</label>
                                    <input type="text" name="investment_no" id="investment_no" class="form-control"
                                        value="{{ $investment->investment_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="investor_type" class="form-label">Investor Type</label>
                                    <select class="form-control" name="investor_type" id="investor_type">
                                        <option value="">select member</option>
                                        <option value="member" @if($investment->investor_type == 'member') selected @endif>Member Investor</option>
                                        <option value="nonmember" @if($investment->investor_type == 'nonmember') selected @endif>Non Member Investor</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            @if($investment->investor_type = 'member')
                            <div class="col-md-4 memberDiv">
                                <div class="form-group">
                                    <label for="member_id" class="form-label">Member Investor</label>
                                    <select class="form-control" name="member_id" id="member_id">
                                        <option value="">select member</option>
                                        @foreach ($members as $data)
                                            <option value="{{ $data->id }}" @if($investment->investor_id == $data->id) selected @endif>{{ $data->fname }} {{ $data->lname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            @else
                            <div class="col-md-4 nonmemberDiv" style="display: none;">
                                <div class="form-group">
                                    <label for="investor_id" class="form-label">Non Member Investor</label>
                                    <div class="input-group">
                                        <select class="form-control" name="investor_id" id="investor_id">
                                            <option value="">select investor</option>
                                            @foreach ($investors as $data)
                                                <option value="{{ $data->id }}" @if($investment->investor_id == $data->id) selected @endif>{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#investorModel"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <span class="invalid-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="investment_amount" class="form-label">Investment Amount</label>
                                    <input type="text" name="investment_amount" value="{{$investment->investment_amount}}" id="investment_amount"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="investmentplan_id" class="form-label">Investment Plan</label>
                                    <select class="form-control" name="investmentplan_id" id="investmentplan_id">
                                        <option value="">select investment plan</option>
                                        @foreach ($plans as $data)
                                            <option value="{{ $data->id }}" data-duration="{{ $data->duration }}"
                                                data-interestvalue="{{ $data->interest_value }}" @if($investment->investmentplan_id == $data->id) selected @endif>{{ $data->name }} -
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
                                    <label for="investment_period" class="form-label">Investment Period</label>
                                    <div class="input-group">
                                        <input type="text" name="investment_period" value="{{$investment->investment_period}}" id="investment_period"
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
                                    <input type="text" name="interest_amount" value="{{$investment->interest_amount}}" id="interest_amount"
                                        class="form-control" readonly>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="roi_amount" class="form-label">Investment ROI</label>
                                    <input type="text" name="roi_amount" value="{{$investment->roi_amount}}" id="roi_amount" class="form-control"
                                        readonly>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date" class="form-label">Investment End Date</label>
                                    <input type="text" name="end_date" value="{{$investment->end_date}}" id="end_date" class="form-control" readonly>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-theme" id="btn_investment">Update
                                    Investment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="investorModel" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h4 class="card-title mb-4">New Investor Form</h4>
                            <form action="#" method="POST" id="gmember_form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gname">Names</label>
                                            <input type="text" name="gname" id="gname" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gdesignation">Designation</label>
                                            <input type="text" name="gdesignation" id="gdesignation"
                                                class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gtelephone">Telephone</label>
                                            <input type="text" name="gtelephone" id="gtelephone"
                                                class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gemail">Email</label>
                                            <input type="email" name="gemail" id="gemail" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gaddress">Address</label>
                                            <textarea name="gaddress" class="form-control" id="gaddress" rows="2"></textarea>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gphoto">Photo</label>
                                            <div class="image-upload image-uploadx">
                                                <div class="thumb thumbx">
                                                    <img alt="image" class="mr-3" id="gpreview"
                                                        src="{{ asset('assets/uploads/defaults/author.png') }}"
                                                        width="60">
                                                    <div class="upload-file">
                                                        <input type="file" name="gphoto"
                                                            class="form-control file-upload" id="gphoto">
                                                        <label for="gphoto" class="btn bg-secondary">upload photo
                                                        </label>
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-theme" id="btn_gmember">Add
                                        Investor</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            "use strict";
            $('#member_id').select2({
                placeholder: 'Select Member'
            })

            $('#investor_type').change(function() {
                let investor_type = $(this).val();
                if (investor_type == 'member') {
                    $('.memberDiv').show();
                    $('.nonmemberDiv').hide();
                } else if (investor_type == 'nonmember') {
                    $('.memberDiv').hide();
                    $('.nonmemberDiv').show();
                } else {
                    $('.memberDiv').show();
                    $('.nonmemberDiv').hide();
                }
            });

            $('#investmentplan_id').change(function() {
                var selectedOption = $(this).find(':selected');
                var duration = selectedOption.data("duration");
                var durationSpan = $("#duration_plan");
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

            $('#investmentplan_id, #investment_amount, #investment_period').on('input', function() {
                let selectedOption = $('#investmentplan_id').find(':selected');
                let duration = selectedOption.data("duration");
                let interest_value = selectedOption.data("interestvalue");
                let investment_amount = parseFloat($('#investment_amount').val()) || 0;
                let investment_period = parseFloat($('#investment_period').val()) || 0;
                let interest_rate = parseFloat(selectedOption.text().split('-')[1]) || 0;
                let interest_amount = 0;
                let roi_amount = 0;
                let end_date = new Date();

                if (duration === 'day') {
                    interest_amount = interest_value * investment_amount * investment_period;
                    roi_amount = investment_amount + interest_amount;
                    end_date = new Date();
                    end_date.setDate(end_date.getDate() + investment_period);
                } else if (duration === 'week') {
                    interest_amount = interest_value * investment_amount * (investment_period * 7);
                    roi_amount = investment_amount + interest_amount;
                    end_date = new Date();
                    end_date.setDate(end_date.getDate() + (investment_period * 7));
                } else if (duration === 'month') {
                    interest_amount = interest_value * investment_amount * investment_period;
                    roi_amount = investment_amount + interest_amount;
                    end_date = new Date();
                    end_date.setMonth(end_date.getMonth() + investment_period);
                } else if (duration === 'year') {
                    interest_amount = interest_value * investment_amount * investment_period;
                    roi_amount = investment_amount + interest_amount;
                    end_date = new Date();
                    end_date.setFullYear(end_date.getFullYear() + investment_period);
                }

                let formatted_end_date = end_date.getFullYear() + '-' + (end_date.getMonth() + 1).toString()
                    .padStart(2,
                        '0') + '-' + end_date.getDate().toString().padStart(2, '0');

                $('#interest_amount').val(isNaN(interest_amount) ? '' : interest_amount);
                $('#roi_amount').val(isNaN(roi_amount) ? '' : roi_amount);
                $('#end_date').val(formatted_end_date);
            });


            $("#investment_form").submit(function(e) {
                e.preventDefault();
                $("#btn_investment").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_investment").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.investment.update') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_investment").html('Add Investment');
                            $("#btn_investment").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#investment_form")[0].reset();
                            removeErrors("#investment_form");
                            $("#btn_investment").html('Add Investment');
                            $("#btn_investment").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);

                        }
                    }
                });
            });

            previewImage("gphoto", "gpreview");
            $("#gmember_form").submit(function(e) {
                e.preventDefault();
                $("#btn_gmember").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_gmember").prop("disabled", true);
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('webmaster.investment.investor.store') }}',
                    method: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_gmember").html('Add Investor');
                            $("#btn_gmember").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#gmember_form")[0].reset();
                            removeErrors("#gmember_form");
                            $("#btn_gmember").html('Add Investor');
                            $("#btn_gmember").prop("disabled", false);
                            var newInvestors = response.investors;
                            $('#investor_id').empty();
                            $.each(newInvestors, function(index, investor) {
                                var option = '<option value="' + investor.id + '">' +
                                    investor
                                    .name + '</option>';
                                $('#investor_id').append(option);
                            });
                            $('#investor_id').val(response.investors[response.investors.length -
                                1].id);
                            $('#investorModel').modal('hide');

                        }
                    }
                });
            });
        });
    </script>
@endsection
