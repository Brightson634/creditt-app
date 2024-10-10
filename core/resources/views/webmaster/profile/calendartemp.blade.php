<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Date Calendar</title>
    
    <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    
    <!-- jQuery, Moment.js, FullCalendar -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>

    <!-- Custom Styles -->
    <style>
        /* General page styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Calendar container styling */
        #calendar-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
            margin: auto;
        }

        /* FullCalendar styling */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Calendar header custom styling */
        .fc-header-toolbar {
            background-color: #3f87a6;
            border-radius: 10px;
            color: #fff;
            padding: 10px;
        }

        /* Calendar buttons */
        .fc-button {
            background-color: #6cace4 !important;
            border: none !important;
            color: white !important;
            border-radius: 5px !important;
            padding: 5px 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .fc-button:hover {
            background-color: #4c8bc0 !important;
        }

        /* Title style */
        .fc-center h2 {
            font-size: 1.5em;
            font-weight: bold;
        }

        /* Calendar content adjustments */
        .fc-day-grid-event {
            background-color: #4c8bc0;
            color: white;
            border-radius: 5px;
            padding: 2px 5px;
        }

    </style>
</head>
<body>

    <div id="calendar-container">
        <div id='calendar'></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                defaultDate: moment().format('YYYY-MM-DD'),
                editable: false,
                height: 400,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                views: {
                    basicDay: {}
                },
                events: []
            });
        });
    </script>
</body>
</html>
