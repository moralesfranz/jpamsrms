<?php
include("header.php");
?>
<div class="container">
    <div id="calendar"></div>
</div>

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/chart/chart.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- FullCalendar Initialization -->
<script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Can change to 'timeGridWeek', 'timeGridDay', etc.
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: 'fetch-events.php', // The PHP file where events are fetched from the server
                    dataType: 'json',
                    success: function(response) {
                        var events = [];
                        $.each(response, function(index, item) {
                            
                            events.push({
                                title: item.title,
                                start: item.start, // ISO8601 date format: "YYYY-MM-DDTHH:MM:SSZ"
                                end: item.end,
                                allDay: item.allDay // true or false
                            });
                        });
                        successCallback(events);
                    },
                    error: function() {
                        failureCallback();
                    }
                });
            },
            editable: true, // Allow editing
            selectable: true, // Allow selection
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
                // Can add additional logic on event click
            },
            eventColor: '#378006' // Optional: Customize event color
        });

        calendar.render();
    });
</script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>

</html>