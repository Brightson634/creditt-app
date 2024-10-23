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
        <div class="col-xl-10 mx-auto scheduler"></div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('member.loan.schedule') }}',
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 200) {
                        $(".scheduler").html(response.html);

                        //pdf generate
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

                                    var disposition = xhr
                                        .getResponseHeader(
                                            'Content-Disposition');
                                    // console.log("Content-Disposition: ",
                                    //     disposition);

                                    // Default filename
                                    var filename = "Loan_Schedule.pdf";

                                    if (disposition && disposition
                                        .indexOf('attachment') !== -1) {
                                        var match = disposition.match(
                                            /filename="([^"]+)"/);
                                        if (match && match[1]) {
                                            filename = match[
                                                1];
                                        }
                                    }

                                    // Log the extracted filename for debugging
                                    // console.log("Extracted filename: ",
                                    //     filename);

                                    var downloadLink = document
                                        .createElement('a');
                                    var url = window.URL
                                        .createObjectURL(response);
                                    downloadLink.href = url;
                                    downloadLink.download =
                                        filename;
                                    document.body.appendChild(
                                        downloadLink);
                                    downloadLink.click();
                                    window.URL.revokeObjectURL(url);
                                    document.body.removeChild(
                                        downloadLink);
                                },
                                error: function(jqxhr) {
                                    if (jqxhr.status === 422) {
                                        var errors = jqxhr.responseJSON
                                            .errors;
                                        $.each(errors, function(key,
                                            value) {
                                            toastr.error(value[
                                                0]);
                                        });
                                    } else {
                                        toastr.error(
                                            'An error occurred. Please try again.'
                                        );
                                    }
                                }
                            });
                        });

                    }
                },
                error: function(jqxhr) {
                    if (jqxhr.status === 422) {
                        // Validation error (Unprocessable Entity)
                        var errors = jqxhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[
                                0]);
                        });
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                }
            });
        });
    </script>
@endsection
