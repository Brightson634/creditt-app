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
    @if (session('message'))
        @include('member.partials.generalheader')
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
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <!-- Event title -->
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" required>
                        </div>

                        <!-- Event start date and time -->
                        <div class="mb-3">
                            <label for="eventStart" class="form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" id="eventStart" required>
                        </div>

                        <!-- Event end date and time -->
                        <div class="mb-3">
                            <label for="eventEnd" class="form-label">End Time</label>
                            <input type="datetime-local" class="form-control" id="eventEnd" required>
                        </div>

                        <!-- Buttons for saving or updating event -->
                        <button type="submit" id="saveEvent" class="btn btn-primary">Save Event</button>
                        <div id="update_cont" style="display: none">
                            <button type="submit" id="updateEvent" class="btn btn-primary">Update Event</button>
                            <button type="button" class="btn btn-danger" id="deleteEventBtn">Delete Event</button>
                        </div>
                    </form>
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
                events: '{{ route('member.calendar.event') }}',
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
                // When an event is clicked, open modal for editing/deleting
                eventClick: function(info) {
                    var event = info.event;
                    $('#eventTitle').val(event.title);
                    $('#eventStart').val(new Date(event.start).toISOString().slice(0, 16));
                    $('#eventEnd').val(new Date(event.end).toISOString().slice(0, 16));
                    $('#saveEvent').css('display', 'none');
                    $('#update_cont').css('display', 'block');
                    // Show the modal
                    $('#eventModal').modal('show');

                }

            });
            calendar.render();

            //initial fetch of events
            eventList()
            //function to fill event list
            function eventList() {

                $.ajax({
                    type: "get",
                    url: `{{ route('member.calendar.event') }}`,
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
                                            <div>${event.title} (${formattedStart}</div>
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