
<link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


<!-- Customized Bootstrap Stylesheet -->

<!-- Template Stylesheet -->

<style>


    /* Custom calendar container styles */
    .calendar-container {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 10px;
	  margin-bottom: 20px;
	  margin-top: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Add subtle shadow for better depth */
    }
	
    /* Calendar Container */
    .calendar-container {
      background-color: #ffffff;
      /* Light background for the calendar */
      border-radius: 15px;
      /* Rounded corners for modern look */
      padding: 30px;
      /* Add padding for spacing */
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      /* Subtle shadow for depth */
    }

</style>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../lib/chart/chart.min.js"></script>
  <script src="../lib/easing/easing.min.js"></script>
  <script src="../lib/waypoints/waypoints.min.js"></script>
  <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="../lib/tempusdominus/js/moment.min.js"></script>
  <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
  <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<div class="container">
	
		<!-- <div class="row justify-content-center col-12 mb-3 mt-2">
			<div class="col-lg-10 col-md-12">
				<div class="calendar-container bg-light p-4 rounded shadow">
					<div id="calendar"></div>
				</div>
			</div>
      	</div> -->
		  <div class="mt-3 mb-3" id="calendar"></div>

	<div class="col-xs-12 col-sm-9">
		<!--<div class="jumbotron">-->
		<div class="">
			<div class="panel panel-default">

				<div class="panel-body">
					<div class="col-xs-12 col-sm-12">
						<fieldset>
							<fieldset>
								<legend>
									<h2 class="text-left">About</h2>
								</legend>
								<?php
								$setting = new Setting();
								$result = $setting->single_setting(1);

								echo '<p>' . $result->DESCRIPTION . ' </p>';

								?>


							</fieldset>
							<hr />
							<fieldset>

								<legend>
									<h2 class="text-left">Company Mission</h2>
								</legend>
								<?php
								$setting = new Setting();
								$result = $setting->single_setting(2);
								echo '<p>' . $result->DESCRIPTION . ' </p>';
								?>
							</fieldset>
							<fieldset>
								<legend>
									<h2 class="text-left">Company Vision</h2>
								</legend>
								<?php
								$setting = new Setting();
								$result = $setting->single_setting(3);
								echo '<p>' . $result->DESCRIPTION . ' </p>';
								?>
							</fieldset>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<!--	</div>-->
	</div>
	<?php include 'sidebar.php'; ?>



</div>


<script>
	
    $(document).ready(function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Default view

        // Fetch events from the server
        events: function(fetchInfo, successCallback, failureCallback) {
          $.ajax({
            url: './fetch_reserved.php', // PHP file to fetch the events
            dataType: 'json',
            success: function(response) {
              var events = [];
              // Process each event from the response
              $.each(response, function(index, item) {
                
                events.push({
                  title: item.title, // Title: Room number
                  start: item.start, // Arrival date
                  end: item.end, // Departure date (optional)
                  extendedProps: { // Additional data
                    guest_id: item.extendedProps.guest_id, // Guest ID
                    status: item.extendedProps.status, // Reservation status
                    confirmation: item.extendedProps.confirmation, // Confirmation code
                    reservation_id: item.extendedProps.reservation_id, // Reservation ID, 
                    departure: item.extendedProps.departure , 
                    roomNo: item.extendedProps.roomNo 
                  }
                });
              });

              successCallback(events); // Return events to FullCalendar
            },
            error: function() {
              failureCallback(); // Handle errors
            }
          });
        },

        editable: false, // Allow editing
        selectable: true, // Allow selection

        // Customize event display
        eventContent: function(info) {
          // Create custom HTML for the event
          var customHtml = `
                <div class="fc-event-custom">
                    <strong>${info.event.extendedProps.departure}: Reserved</strong><br>
                </div>
            `;
          // Return the custom HTML to be displayed
          return {
            html: customHtml
          };
        },

        eventDidMount: function(info) {
          if (info.event.extendedProps.departure === 'Day Tour') {
            info.el.style.backgroundColor = '#f7ad23';
          } else {
            info.el.style.backgroundColor = '#4275c7';
          }
        }
      });

      calendar.render();
    });
</script>

<style>
    /* Customize the size of the event box */
    .fc-event-custom {
      font-size: 10px;
      /* Reduce font size */
      padding: 2px;
      /* Reduce padding */
      margin: 2px;
      /* Reduce margin */
    }

    .fc-daygrid-event {
      white-space: normal;
      /* Ensure the event text wraps */
      padding: 3px;
      /* Adjust padding for each event block */
    }

    /* Customize the size of the event title */
    .fc-event-custom strong {
      font-size: 12px;
      /* Slightly larger font for the title */
    }

    /* Customize other small text within the event */
    .fc-event-custom small {
      font-size: 9px;
      /* Make additional info smaller */
    }
  </style>