@extends('webmaster.partials.dashboard.main')

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
    @if (session('message'))
        @include('webmaster.partials.generalheader')
    @endif
    <div class="row justify-content-center">
        <!-- Calendar container with padding and background -->
        <div id="calendar-container" class="col-md-8">
            <div id="calendar"></div>
        </div>
        <div class="col-md-4" id="event-list" style="height: 400px; overflow-y: auto;">
            <label class="az-content-label tx-13 tx-bold mg-b-10">Loan Repayment Timeline</label>
            <nav class="nav az-nav-column az-nav-calendar-event" id='nav-event-list'>

            </nav>
        </div>
    </div>

    <!-- Event Modal -->
    <div id="eventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel"><span id='memberId'></span> Loan  Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="loanDiv">
                        <p class="invoice-info-row"><span>Due Amount:</span><span id='dueAmount'></span></p>
                        <p class="invoice-info-row"><span>Due Date:</span><span id='dueDate'></span></p>
                        <p class="invoice-info-row"><span>Total Loan Amount:</span><span id='loanAmount'></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var note = '{{ session('note') }}';

            if (note) {
                toastr.warning(note);
            }
            //calendar
            var calendarEl = $('#calendar')[0];
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                events: '{{ route('webmaster.calendar.event') }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                select: function(info) {
                    // Format start and end dates to match the datetime-local input format
                    var startDate = new Date(info.start);
                    var endDate = new Date(info.end);

                    // Convert dates to ISO format without seconds (required by datetime-local)
                    var formattedStart = startDate.toISOString().slice(0,
                        16);
                    var formattedEnd = endDate.toISOString().slice(0,
                        16);

                    // Set values in the modal inputs
                    $('#eventStart').val(formattedStart);
                    $('#eventEnd').val(formattedEnd);
                    $('#eventModal').modal('show');
                },
                eventClick: function(info){
                    var event = info.event;
                    const extendedEventInfo = event.extendedProps;
                    const formattedStart = new Date(event.start).toLocaleDateString(
                                'en-US', {
                                    month: 'long',
                                    day: 'numeric',
                                    year: 'numeric'
                                });
                    $('#dueAmount').text(extendedEventInfo.payment_amount);
                    $('#dueDate').text(formattedStart);
                    $('#loanAmount').text(extendedEventInfo.total_amount);
                    $('#memberId').text(extendedEventInfo.member);
                    // $('#saveEvent').css('display', 'none');
                    // $('#update_cont').css('display', 'block');
                    // Show the modal
                    $('#eventModal').modal('show');

                    // $('#updateEvent').on('click', function(ev) {
                    //     ev.preventDefault()
                    //     // Get updated values from the form
                    //     var updatedTitle = $('#eventTitle').val();
                    //     var updatedStart = $('#eventStart').val();
                    //     var updatedEnd = $('#eventEnd').val();
                    //     if (updatedTitle && updatedStart && updatedEnd) {
                    //         var newEvent = {
                    //             title: updatedTitle,
                    //             start: updatedStart,
                    //             end: updatedEnd
                    //         };

                    //         var baseUrl =
                    //             "{{ route('webmaster.calendar.event.update', ['id' => ':id']) }}";
                    //         const updateUrl = baseUrl.replace(':id', event.id);
                    //         $.ajax({
                    //             url: updateUrl,
                    //             type: 'PUT',
                    //             data: {
                    //                 title: updatedTitle,
                    //                 start: updatedStart,
                    //                 end: updatedEnd,
                    //                 _token: '{{ csrf_token() }}'
                    //             },
                    //             success: function(response) {
                    //                 if (response.message) {
                    //                     toastr.success('Event Updated')
                    //                     eventList();
                    //                     calendar.refetchEvents();
                    //                 }
                    //                 console.log(response)
                    //             },
                    //             error: function(response) {
                    //                 console.log(response)
                    //                 toastr.error("An unexpected error!")
                    //             }
                    //         });


                    //         // location.reload(true);

                    //         // Close the modal
                    //         $('#eventModal').modal('hide');

                    //         // Reset form
                    //         $('#eventForm')[0].reset();
                    //     } else {
                    //         toastr.warning('Please fill all fields.');
                    //     }

                    // })

                    // Handle event deletion
                    $('#deleteEventBtn').off('click').on('click', function() {
                        var baseUrl =
                            "{{ route('webmaster.calendar.event.destroy', ['id' => ':id']) }}";
                        const deleteUrl = baseUrl.replace(':id', event.id);
                        if (confirm('Are you sure you want to delete this event?')) {
                            event.remove();

                            $.ajax({
                                url: deleteUrl,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    toastr.success('Event deleted successfully!');
                                },
                                error: function(response) {
                                    toastr.error('Error deleting event!');
                                }
                            });
                            $('#eventModal').modal('hide');
                        }
                    });
                }

            });
            calendar.render();

            $('#saveEvent').on('click', function(event) {
                event.preventDefault()
                var title = $('#eventTitle').val();
                var start = $('#eventStart').val();
                var end = $('#eventEnd').val();

                if (title && start && end) {
                    var newEvent = {
                        title: title,
                        start: start,
                        end: end
                    };

                    // Add event to calendar
                    // calendar.addEvent(newEvent);

                    // Optional: Send the event data to the backend using AJAX
                    $.ajax({
                        url: '{{ route('webmaster.calendar.event.store') }}',
                        type: 'POST',
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.message) {
                                toastr.success('Event Created')
                                eventList();
                                calendar.refetchEvents();
                            }
                            console.log(response)
                        },
                        error: function(response) {
                            toastr.error("An unexpected error!")
                        }
                    });

                    // Close the modal
                    $('#eventModal').modal('hide');
                } else {
                    alert('Please fill all fields.');
                }

            });

            $('#eventModal').on('hidden.bs.modal', function() {
                // $('#saveEvent').css('display', 'block');
                // $('#update_cont').css('display', 'none');
            });

            //initial fetch of events
            eventList()
            //function to fill event list
            function eventList() {

                $.ajax({
                    type: "get",
                    url: `{{ route('webmaster.calendar.event') }}`,
                    success: function(response) {

                        $('#nav-event-list').empty();
                        const colorClasses = ['tx-primary', 'tx-success', 'tx-danger', 'tx-warning',
                            'tx-info'
                        ];
                        response.forEach(function(event, index) {
                            const formattedStart = new Date(event.start).toLocaleDateString(
                                'en-US', {
                                    month: 'long',
                                    day: 'numeric',
                                    year: 'numeric'
                                });
                            const formattedEnd = new Date(event.end).toLocaleDateString(
                                'en-US', {
                                    month: 'long',
                                    day: 'numeric',
                                    year: 'numeric'
                                });

                            const colorClass = colorClasses[index % colorClasses.length];
                            const eventHTML = `
                                        <a href="" class="nav-link">
                                            <i class="icon ion-ios-calendar ${colorClass}"></i>
                                            <div>${event.title} (${formattedStart})</div>
                                        </a>
                                    `;

                            $('#nav-event-list').append(eventHTML);
                        });
                    }
                });
            }
        });
    </script>
@endsection
