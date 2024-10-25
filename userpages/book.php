<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>JPAMS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis .com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar sticky-top px-4 py-2 py-lg-0">
        <nav class="navbar navbar-expand-lg navbar-light">
            <!-- Brand Logo -->
            <a href="UserLanding.php" class="navbar-brand">
                <img src="../img/JPAMS LOGO.png" alt="Logo" loading="lazy" style="max-height: 80px; width: auto;">
            </a>
            <!-- Toggler Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto py-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="userpages\about.php" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="userpages\package.php" class="nav-link">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="userpages\contact.php" class="nav-link">Contact</a>
                    </li>
                </ul>
                <!-- Social Icons -->
                <div class="team-icon d-none d-xl-flex justify-content-center me-3">
                    <a class="btn btn-square btn-light rounded-circle mx-1" href="https://www.facebook.com/profile.php?id=100081561532377" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <!-- Add more social icons if needed -->
                </div>
                <!-- User Dropdown -->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="../img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex">John Doe</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="userpages\index.php" class="dropdown-item">My Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar & Hero End -->




    <!-- Footer Start -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <a href="index.html" class="p-0">
                            <h4 class="text-white mb-4"><i class="fas fa-swimmer text-primary me-3"></i>JPMAS</h4>
                            <!-- <img src="img/logo.png" alt="Logo"> -->
                        </a>
                        <p class="mb-2 text-white">This private resort’s location can significantly impact your overall experience.
                            Whether you desire a coastal sanctuary or a retreat, ensure your selected resort
                            aligns with your preferences.</p>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                            <p class="text-white mb-0">Mountainview Subdivision, Blk 7 Lot 7 Camachille St, San Jose del
                                Monte City</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <p class="text-white mb-0">JPAMS@gmail.com</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa fa-phone-alt text-primary me-3"></i>
                            <p class="text-white mb-0">(+63) 9090 27890</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-2">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Quick Links</h4>
                        <a href="about.php"><i class="fas fa-angle-right me-2 "></i> About Us</a>
                        <a href="feature.php"><i class="fas fa-angle-right me-2 "></i> Feature</a>
                        <a href="attraction.php"><i class="fas fa-angle-right me-2 "></i> Attractions</a>
                        <a href="package.php"><i class="fas fa-angle-right me-2 "></i> Packages</a>
                        <a href="contact.php"><i class="fas fa-angle-right me-2 "></i> Contact us</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Opening Hours</h4>
                        <div class="opening-date mb-3 pb-3">
                            <div class="opening-clock flex-shrink-0">
                                <h6 class="text-white mb-0 me-auto">Monday - Friday:</h6>
                                <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i> 07:00 AM - 19:00 PM</p>
                            </div>
                            <div class="opening-clock flex-shrink-0">
                                <h6 class="text-white mb-0 me-auto">Saturday - Sunday:</h6>
                                <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i> 07:00 AM - 19:00 PM</p>
                            </div>
                            <div class="opening-clock flex-shrink-0">
                                <h6 class="text-white mb-0 me-auto">Holiday:</h6>
                                <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i> 07:00 AM - 19:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>JPMAS</a>, All right
                        reserved.</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- JavaScript calendars -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/chart/chart.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>




    <!-- JavaScript Libraries -->


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
    <script src="../js/main.js"></script>
</body>

</html>