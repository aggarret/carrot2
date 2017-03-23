<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<html>
<head>

<link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.css' />
</head>
<body>
  <div id='calendar'></div>
    
<script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/moment.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/jquery.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/jquery-ui.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.js'></script>
<script type="text/javascript">
	$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        left:   'Calendar',
        center: '',
        right:  'today prev,next'
    })

});
</script>
</html>