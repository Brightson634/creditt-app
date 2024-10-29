@extends('member.partials.dashboard.main')

@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <style>
        /* Make the calendar section stand out with a light background */
        #calendar-container,
        #event-list {
            background-color: #f5f7fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Make sure the calendar takes up the full available space */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Improve modal appearance */
        .modal-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
        }

        /* Styling the form fields */
        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        /* Styling the save/update buttons */
        .btn-primary,
        .btn-danger {
            border-radius: 20px;
        }

        /* Button hover effects */
        .btn-primary:hover {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Center the modal on the screen */
        .modal-dialog {
            max-width: 500px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-11 mx-auto scheduler"></div>
    </div>
    <!-- LARGE MODAL -->
    <div id="repaymentModal" class="modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Loan Repayment Form</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="repaymentForm" enctype="multipart/form-data" method="POST"
                          action="{{ route('member.loan.repayment') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="date_due" class="form-label">Due Date</label>
                            <input type="date" readonly class="form-control" name="date_due" id="date_due" required>
                            @error('date_due')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount to Pay</label>
                            <input type="number" class="form-control" name="amount" id="amount"
                                   placeholder="Enter amount" required>
                            @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="paymentType" class="form-label">Payment Type</label>
                            <select class="form-control" name="payment_type" id="paymentType">
                                <option value="">Select Payment</option>
                                <option value="paid">Full Payment</option>
                                <option value="partial">Partial Payment</option>
                            </select>
                            @error('payment_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="paymentMode" class="form-label">Mode of Payment</label>
                            <select class="form-control" name="payment_mode" id="paymentMode" required>
                                <option value="">Select</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="mobile_money">Mobile Money</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="cash">Cash</option>
                            </select>
                            @error('payment_mode')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="proofOfPayment" class="form-label">Upload Proof of Payment (optional)</label>
                            <input type="file" class="form-control" name="proof_of_payment" id="proofOfPayment"
                                   accept="image/*,application/pdf">
                            @error('proof_of_payment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo submitPayment">Submit Payment</button>
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- modal-dialog -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Display modal with errors if validation fails
            @if ($errors->any())
                $('#repaymentModal').modal('show');
            @endif

            // AJAX call to load scheduler data
            $.ajax({
                url: '{{ route('member.loan.schedule') }}',
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 200) {
                        $(".scheduler").html(response.html);

                        // Handle download button click for PDF generation
                        $('#downloadBtn').on('click', function(event) {
                            event.preventDefault();

                            $.ajax({
                                url: '{{ route('member.loan.scheduler.pdf') }}',
                                method: 'get',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                contentType: false,
                                xhrFields: {
                                    responseType: 'blob' // Important: Set the response type to blob
                                },
                                success: function(response, status, xhr) {
                                    var disposition = xhr.getResponseHeader('Content-Disposition');
                                    var filename = "Loan_Schedule.pdf";

                                    if (disposition && disposition.indexOf('attachment') !== -1) {
                                        var match = disposition.match(/filename="([^"]+)"/);
                                        if (match && match[1]) {
                                            filename = match[1];
                                        }
                                    }

                                    var downloadLink = document.createElement('a');
                                    var url = window.URL.createObjectURL(response);
                                    downloadLink.href = url;
                                    downloadLink.download = filename;
                                    document.body.appendChild(downloadLink);
                                    downloadLink.click();
                                    window.URL.revokeObjectURL(url);
                                    document.body.removeChild(downloadLink);
                                },
                                error: function(jqxhr) {
                                    if (jqxhr.status === 422) {
                                        var errors = jqxhr.responseJSON.errors;
                                        $.each(errors, function(key, value) {
                                            toastr.error(value[0]);
                                        });
                                    } else {
                                        toastr.error('An error occurred. Please try again.');
                                    }
                                }
                            });
                        });
                    }
                },
                error: function(jqxhr) {
                    if (jqxhr.status === 422) {
                        var errors = jqxhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                }
            });

            // Event listener for showing modal with the selected due date
            $(document).on('click', '.repayment_date', function(event) {
                event.preventDefault();
                const dueDate = $(this).attr('data-due-date');
                $('#date_due').val(dueDate);
                $('#repaymentModal').modal('show');
            });
        });
    </script>
@endsection
