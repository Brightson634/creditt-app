@extends('webmaster.partials.dashboard.main')

@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <style>
        /* Make the calendar section stand out with a light background */
        #calendar-container {
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
        <div id="calendar-container" class="col-md-10">
            <div id="calendar"></div>
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

                    $('#updateEvent').on('click', function(ev) {
                        ev.preventDefault()
                        // Get updated values from the form
                        var updatedTitle = $('#eventTitle').val();
                        var updatedStart = $('#eventStart').val();
                        var updatedEnd = $('#eventEnd').val();
                        if (updatedTitle && updatedStart && updatedEnd) {
                            var newEvent = {
                                title: updatedTitle,
                                start: updatedStart,
                                end: updatedEnd
                            };

                            var baseUrl =
                                "{{ route('webmaster.calendar.event.update', ['id' => ':id']) }}";
                            const updateUrl = baseUrl.replace(':id', event.id);
                            $.ajax({
                                url: updateUrl,
                                type: 'PUT',
                                data: {
                                    title: updatedTitle,
                                    start: updatedStart,
                                    end: updatedEnd,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.message) {
                                        toastr.success('Event Updated')
                                    }
                                    console.log(response)
                                },
                                error: function(response) {
                                    console.log(response)
                                    toastr.error("An unexpected error!")
                                }
                            });

                            calendar.refetchEvents();

                            // location.reload(true);

                            // Close the modal
                            $('#eventModal').modal('hide');

                            // Reset form
                            $('#eventForm')[0].reset();
                        } else {
                            toastr.warning('Please fill all fields.');
                        }

                    })

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
                    calendar.addEvent(newEvent);

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
                            }
                            console.log(response)
                        },
                        error: function(response) {
                            toastr.error("An unexpected error!")
                        }
                    });

                    // Close the modal
                    $('#eventModal').modal('hide');

                    // Reset form
                    $('#eventForm')[0].reset();
                } else {
                    alert('Please fill all fields.');
                }

            });

            $('#eventModal').on('hidden.bs.modal', function() {
                $('#eventForm')[0].reset();
                $('#saveEvent').css('display', 'block');
                $('#update_cont').css('display', 'none');
            });
        });
    </script>
@endsection