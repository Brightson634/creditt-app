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
                            $disbursementStatus =  loanAlreadyDisbursed($loan->id);
                        @endphp
                        @if(!$disbursementStatus)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="mb-3"><strong>Reviewing Notes</strong></h5>
                                <form action="#" method="POST" id="review_form">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-indigo btn-theme" id="btn_review">Update
                                                Review</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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

            $("#review_form").submit(function(e) {
                e.preventDefault();
                $("#btn_review").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
                $("#btn_review").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.loan.review.store') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_review").html('Update Review');
                            $("#btn_review").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#review_form")[0].reset();
                            removeErrors("#review_form");
                            $("#btn_review").html('Update Review');
                            $("#btn_review").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);

                        }
                    }
                });
            });
        </script>
    @endsection
