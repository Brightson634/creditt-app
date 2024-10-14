
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    
</head>
<body>
    <div id='calendar'>

    </div>
</body>
</html>
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