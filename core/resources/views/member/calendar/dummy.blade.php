@extends('webmaster.partials.dashboard.main')

@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <style>
        #calendar-container {
            background-color: #f5f7fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        .modal-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .btn-primary, .btn-danger {
            border-radius: 20px;
        }

        .btn-primary:hover {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .modal-dialog {
            max-width: 500px;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div id="calendar-container" class="col-md-10">
            <div id="calendar"></div>
        </div>
    </div>

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
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventStart" class="form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" id="eventStart" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventEnd" class="form-label">End Time</label>
                            <input type="datetime-local" class="form-control" id="eventEnd" required>
                        </div>
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
                // Open the modal for a new event
                $('#eventModal').modal('show');

                // Reset the form fields for a new event
                $('#eventForm')[0].reset();
                $('#saveEvent').css('display', 'block'); // Show 'Save' button
                $('#update_cont').css('display', 'none'); // Hide update controls

                // Set selected start and end dates for the new event
                $('#eventStart').val(new Date(info.start).toISOString().slice(0, 16));
                $('#eventEnd').val(new Date(info.end).toISOString().slice(0, 16));
            },
            eventClick: function(info) {
                // Open the modal for editing/deleting an existing event
                var event = info.event;
                $('#eventTitle').val(event.title);
                $('#eventStart').val(new Date(event.start).toISOString().slice(0, 16));
                $('#eventEnd').val(new Date(event.end).toISOString().slice(0, 16));
                $('#saveEvent').css('display', 'none'); // Hide 'Save' button
                $('#update_cont').css('display', 'block'); // Show update controls
                $('#eventModal').modal('show');
            }
        });

        calendar.render();

        // Save or update event
        $('#saveEvent, #updateEvent').on('click', function(event) {
            event.preventDefault();
            var title = $('#eventTitle').val();
            var start = $('#eventStart').val();
            var end = $('#eventEnd').val();

            if (title && start && end) {
                var newEvent = { title: title, start: start, end: end };

                // Add new event or update existing one
                calendar.addEvent(newEvent);

                // Close the modal
                $('#eventModal').modal('hide');
            } else {
                alert('Please fill all fields.');
            }
        });

        // Reset form and hide update controls when the modal is closed
        $('#eventModal').on('hidden.bs.modal', function () {
            $('#eventForm')[0].reset(); // Reset the form fields
            $('#saveEvent').css('display', 'block'); // Show 'Save' button again
            $('#update_cont').css('display', 'none'); // Hide update controls
        });
    });
</script>

@endsection
