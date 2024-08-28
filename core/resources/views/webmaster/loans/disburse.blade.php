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
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                           <div class="mt-2">
                                              <div class="custom-control custom-radio custom-control-inline">
                                                 <input type="radio" id="approve" name="status" class="custom-control-input" value="5" checked>
                                                 <label class="custom-control-label" for="approve">DISBURSE LOAN</label>
                                              </div>
                                              <div class="custom-control custom-radio custom-control-inline">
                                                 <input type="radio" id="reject" name="status" class="custom-control-input" value="6">
                                                 <label class="custom-control-label" for="reject">CANCEL LOAN</label>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-indigo btn-theme" id="btn_disburse">Update
                                            Status</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                            $("#btn_disburse").html('Update Review');
                            $("#btn_disburse").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#disburse_form")[0].reset();
                            removeErrors("#disburse_form");
                            $("#btn_disburse").html('Update Review');
                            $("#btn_disburse").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);

                        }
                    }
                });
            });
        </script>
    @endsection
