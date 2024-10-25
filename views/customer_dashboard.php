<?php
// Check if a session is already active
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Include database connection
if (!include '../userpages/db_connection.php') {
  die("Failed to include database connection.");
}

// Get the user ID (assuming you have it; you can set it based on session or request)
// $userId = $_SESSION[];

// Fetch user data from the database, including profile_picture
$query = "SELECT * FROM useraccounts WHERE ACCOUNT_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Fetch user data as an associative array

// Initialize variables to avoid undefined index warnings
$name = isset($user['ACCOUNT_NAME']) ? $user['ACCOUNT_NAME'] : '';
// $email = isset($user['email']) ? $user['email'] : '';
// $bio = isset($user['bio']) ? $user['bio'] : '';
// $profilePicture = isset($user['profile_picture']) ? $user['profile_picture'] : 'img/user.jpg'; // Use existing profile picture

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get data from POST
  $name = $_POST['name'];
  $email = $_POST['email'];
  $bio = $_POST['bio'];

  // Initialize a variable to hold the new profile picture path
  $newProfilePicture = $profilePicture; // Default to existing picture

  // Handle file upload
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    // File upload settings
    $uploadDir = 'img/'; // Directory to save uploaded images
    $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Check if file is an image
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if ($check !== false && in_array($imageFileType, $validExtensions)) {
      // Move the uploaded file to the desired directory
      if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
        $newProfilePicture = $uploadFile; // Update the new profile picture path
      } else {
        echo "Error moving uploaded file.";
      }
    } else {
      echo "File is not an image or unsupported file type.";
    }
  }

  // Prepare the SQL update statement
  $updateQuery = "UPDATE usersp SET name = ?, email = ?, bio = ?, profile_picture = ? WHERE id = ?";
  $stmt = $conn->prepare($updateQuery);

  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  // Bind parameters, including the (possibly updated) profile picture
  $stmt->bind_param("ssssi", $name, $email, $bio, $newProfilePicture, $userId);

  // Execute the statement
  if ($stmt->execute()) {
    // Set session message
    $_SESSION['notification'] = "Your profile is updated!";
    // Redirect to profile.php after successful update
    header("Location: profile.php");
    exit(); // Make sure to call exit after header redirect
  } else {
    echo "Error updating profile: " . $stmt->error;
  }

  // Close the statement
  $stmt->close();
}

// Close the database connection
$conn->close();

?>




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
      <a href="customer_dashboard.php" class="navbar-brand">
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
            <a href="customer_dashboard.php" class="nav-link active">Home</a>
          </li>
          <li class="nav-item">
            <a href="../userpages/contact.php" class="nav-link">Contact us</a>
          </li>
          <li class="nav-item">
            <a href="../userpages/package.php" class="nav-link">Services</a>
          </li>
          <li class="nav-item">
            <a href="../userpages/about.php" class="nav-link">About us</a>
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
            <img class="me-lg-2" src="" alt="">
            <span class="d-none d-lg-inline-flex"><?php echo htmlspecialchars($name); ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
            <a href="../userpages/profile.php" class="dropdown-item">My Profile</a>
            <a href="logout.php" class="dropdown-item">Log Out</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <!-- Navbar & Hero End -->



  <!-- Carousel Start -->
  <div class="header-carousel owl-carousel">
    <div class="header-carousel-item">
      <!-- <img src="img/jpams/1.jpg" class="img-fluid w-100" alt="Image">-->
      <div class="ratio ratio-ratio ratio-21x9">
        <div>21x9</div>"><video autoplay loop muted plays-inline class="w-full h-auto">
          <source src="../VIDEO/HIGHLIGHT.mp4" type="video/mp4">
        </video>
      </div>
      <div class="carousel-caption">
        <div class="container align-items-center py-4">
          <div class="row g-5 align-items-center">
            <div class="col-xl-7 fadeInLeft animated" data-animation="fadeInLeft" data-delay="2s" style="animation-delay: 2s;">
              <div class="text-start">
                <h1 class="text-primary text-uppercase fw-bold mb-5">Welcome To </h1>
                <h1 class="display-4 text-uppercase text-white mb-4">JPAMS PRIVATE RESORT
                </h1>
                <p class="mb-4 fs-5">Join us in creating unforgettable memories, forging lasting
                  connections, and embracing the essence of JPAMS Private Resort. We invite you to
                  unwind, explore, and discover.
                </p>
                <div class="d-flex flex-shrink-0">
                  <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="../Aplaya/index.php">Book now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Carousel End -->

  <style>
    .fc-event-custom {
      font-size: 12px;
      line-height: 1.2;
      /* Adjust line height for compact display */
      /* Allow text to wrap */
    }

    .fc-event-custom small {
      display: block;
      color: #555;
    }

    /* Adjust event size for better fit */
    .fc-event {
      padding: 1px;
    }

    #calendar {
      height: 900px;
      /* Adjust height if necessary */
      width: 100%;
      /* Set width to 100% of the container */
    }

    /* Custom calendar container styles */
    .calendar-container {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Add subtle shadow for better depth */
    }

    /* Responsive media queries */
    @media (max-width: 800px) {
      #calendar {
        height: 700px;
        /* Reduce height for smaller screens */
      }
    }

    /* Container Styles */
    .attractions {
      background-color: #2c3e50;
      /* Dark background to contrast with light calendar */
      color: white;
      /* Ensure text is legible */
    }

    .attractions-section h1,
    .attractions-section h4 {
      color: white;
      /* Keep text consistent with theme */
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

    /* Calendar Styles */
    #calendar {
      height: 700px;
      /* Adjust height based on preference */
      width: 100%;
    }

    /* Adjust font sizes for headings inside calendar */
    .fc-event-custom {
      font-size: 13px;
      white-space: normal;
      /* Ensure text wraps */
    }

    /* Calendar responsiveness for smaller screens */
    @media (max-width: 768px) {
      #calendar {
        height: 500px;
        /* Reduce height on smaller screens */
      }

      .calendar-container {
        padding: 20px;
        /* Adjust padding for smaller screens */
      }
    }
  </style>

  <!-- Calendar UI Layout -->
  
  <!-- Calendar End -->

  <!-- Feature Start -->
  <div class="container-fluid feature py-5">
    <div class="container py-5">
      <div class="row g-4">
        <!-- Image and Initial Description -->
        <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.2s">
          <div class="feature-item">
            <img src="../img/jpams/1.jpg" class="img-fluid rounded" style="width: 100%; height: 500px; object-fit: cover;" alt="Image">
            <div class="feature-content p-4">
              <div class="feature-content-inner">
                <h4 class="text-white">Special Events</h4>
                <p class="text-white"> Whether it’s a wedding, a graduation, a birthday, or a new chapter like retirement, each special event is a reminder that life is a collection of extraordinary moments meant to be celebrated, cherished, and remembered forever.</p>
                <a href="../reunion.php" class="btn btn-primary rounded-pill py-2 px-4">More Pictures<i class="fa fa-arrow-right ms-1"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!-- Additional Description -->
        <div class="col-lg-7 wow fadeInUp d-flex align-items-center justify-content-center position-relative" data-wow-delay="0.4s">
          <div class="additional-description p-4 bg-light rounded text-center position-relative" style="width: 100%; padding-top: 80px;">
            <!-- Badge/Label -->
            <div class="rounded bg-primary p-3 position-absolute d-flex justify-content-center align-items-center" style="width: 200px; height: 80px; top: -40px; left: 50%; transform: translateX(-50%); z-index: 10;">
              <h3 class="mb-0 text-white">New Events</h3>
            </div>
            <!-- Picture and Caption -->
            <div class="position-relative d-flex flex-column align-items-center mb-1">
              <div class="p-3"> <!-- Added padding container -->
                <img src="../img/picture/debut/DSC_0068.JPG" alt="Description of the picture" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
              </div>
              <p class="text-dark mb-2">Debut</p>
            </div>
            <!-- Content -->
            <h5 class="text-dark mt-5 pt-2">Additional Information</h5>
            <p class="text-dark">The debut is a significant celebration in various cultures, symbolizing a young woman’s transition into adulthood. It’s often celebrated with a grand party, traditional dances, and ceremonies that reflect the girl’s upbringing and values. Family, friends, and the community play a vital role in this event, making it a memorable and meaningful occasion.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Feature End -->


  <!-- About Start -->
  <div class="container-fluid about py-5">
    <div class="container-fluid about pb-5">
      <div class="container pb-5">
        <div class="row g-5">
          <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
            <div>
              <h4 class="text-primary">About JPAMS</h4>
              <h1 class="display-5 mb-4">The Best Private Resort For Your Family</h1>
              <p class="mb-5">Welcome to JPAMS Private Resort, a hidden gem where simplicity meets modern comfort. Experience the perfect blend of simplicity and sophistication with our cozy accommodations and top-notch security. Discover a sanctuary where nature’s beauty and modern amenities harmonize seamlessly.</p>
              <div class="row g-4">
                <div class="col-md-6">
                  <div class="d-flex">
                    <div class="me-3"><i class="fas fa-glass-cheers fa-3x text-primary"></i></div>
                    <div>
                      <h4> Book Your Celebration with JPAMS!</h4>
                      <p>We're excited to announce a special event to celebrate our recent achievements with JPAMS! Join us for an evening of festivities, recognition, and fun as we honor the hard work and dedication that brought us to this milestone.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex">
                    <a href="../contact.php">
                      <div class="me-3"><i class="fas fa-dot-circle fa-3x text-primary"></i></div>
                      <div>
                    </a>
                    <h4>It easy to find</h4>
                    <p>Located at bulacan area</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex">
                  <div class="me-3"><i class="fas fa-hand-holding-usd fa-3x text-primary"></i>
                  </div>
                  <div>
                    <h4>Relax and Unwind at Our Affordable Resort! </h4>
                    <p>Escape the hustle and bustle of daily life without breaking the bank! Our resort offers an exceptional retreat with affordable pricing, ensuring you can relax and rejuvenate without worrying about your budget.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex">
                  <div class="me-3"><i class="fas fa-lock fa-3x text-primary"></i></div>
                  <div>
                    <h4>Safety Site</h4>
                    <p>At our resort, your safety is our top priority. We have implemented rigorous health and safety protocols to ensure that you and your guests enjoy a worry-free stay. From enhanced sanitation practices to social distancing measures, we’re committed to providing a safe and relaxing environment.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.4s">
          <div class="position-relative rounded">
            <div class="rounded" style="margin-top: 40px;">
              <div class="row g-0">
                <div class="col-lg-12">
                  <div class="rounded mb-4">
                    <img src="../img/1 (2).jpg" class="img-fluid rounded w-100" alt="">
                  </div>
                  <div class="row gx-4 gy-0">
                    <div class="col-6">
                      <div class="counter-item bg-primary rounded text-center p-4 h-100">
                        <div class="counter-item-icon mx-auto mb-3">
                          <i class="fas fa-thumbs-up fa-3x text-white"></i>
                        </div>
                        <div class="counter-counting mb-3">
                          <span class="text-white fs-2 fw-bold" data-toggle="counter-up">150</span>
                          <span class="h1 fw-bold text-white">K +</span>
                        </div>
                        <h5 class="text-white mb-0">Happy Visitors</h5>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="counter-item bg-dark rounded text-center p-4 h-100">
                        <div class="counter-item-icon mx-auto mb-3">
                          <i class="fas fa-certificate fa-3x text-white"></i>
                        </div>
                        <div class="counter-counting mb-3">
                          <span class="text-white fs-2 fw-bold" data-toggle="counter-up">122</span>
                          <span class="h1 fw-bold text-white"> +</span>
                        </div>
                        <h5 class="text-white mb-0">Events</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="rounded bg-primary p-4 position-absolute d-flex justify-content-center" style="width: 90%; height: 80px; top: -40px; left: 50%; transform: translateX(-50%);">
              <h3 class="mb-0 text-white">10 Years</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->


  <!-- Attractions Start -->
  <div class="container-fluid attractions py-5">
    <div class="container attractions-section py-5">
      <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
        <h4 class="text-primary">Attractions</h4>
        <h1 class="display-5 text-white mb-4">Explore JPAMS Private Resort</h1>
        <p class="text-white mb-0">When you want a quick getaway from Metro Manila, heading to a nearby private
          resort is a good option. You’ll never run out of choices, as there are a lot of private resorts in
          the nearby provinces of Bulacan.
        </p>
      </div>
      <div class="owl-carousel attractions-carousel wow fadeInUp" data-wow-delay="0.1s">
        <div class="attractions-item wow fadeInUp" data-wow-delay="0.2s">
          <img src="../img/jpams/1.jpg" class="img-fluid rounded w-100" style="height: 300px; object-fit: cover;" alt="">
          <a href="#" class="attractions-name"></a>
        </div>
        <div class="attractions-item wow fadeInUp" data-wow-delay="0.4s">
          <img src="../img/jpams/2.jpg" class="img-fluid rounded w-100" style="height: 300px; object-fit: cover;" alt="">
          <a href="#" class="attractions-name"></a>
        </div>
        <div class="attractions-item wow fadeInUp" data-wow-delay="0.6s">
          <img src="../img/jpams/3.jpg" class="img-fluid rounded w-100" style="height: 300px; object-fit: cover;" alt="">
          <a href="#" class="attractions-name"></a>
        </div>
        <div class="attractions-item wow fadeInUp" data-wow-delay="0.8s">
          <img src="../img/jpams/4.jpg" class="img-fluid rounded w-100" style="height: 300px; object-fit: cover;" alt="">
          <a href="#" class="attractions-name"></a>
        </div>
        <div class="attractions-item wow fadeInUp" data-wow-delay="1s">
          <img src="../img/jpams/2.jpg" class="img-fluid rounded w-100" style="height: 300px; object-fit: cover;" alt="">
          <a href="#" class="attractions-name"></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Attractions End -->


  <!-- Gallery Start -->
  <div class="container-fluid gallery pb-5">
    <div class="container pb-5">
      <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
        <h4 class="text-primary">Our Gallery</h4>
        <h1 class="display-5 mb-4">Captured Moments In JPAMS Private Resort</h1>
        <p class="mb-0">A lifetime of memories condensed into a single snapshot, the photograph serves as a
          portal to a bygone era. Dickinson's poem invites us to reflect on the transience of life and the
          power of images to preserve the past.
        </p>
      </div>

      <div class="row g-4">
        <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
          <div class="gallery-item">
            <img src="../img/cap (1).jpg" class="img-fluid rounded w-100 h-100" style="object-fit: cover;" alt="">
            <div class="search-icon" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
              <a href="../img/cap (1).jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-1">
                <i class="fas fa-search-plus"></i>
              </a>
              <div class="message-box" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; width: 100%;">
                <p>JPAMS Private Resort is a budget-friendly, family-friendly getaway with bunk beds, shared spaces</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 wow fadeInUp" data-wow-delay="0.4s">
          <div class="gallery-item">
            <img src="../img/cap (2).jpg" class="img-fluid rounded w-100 h-100" alt="">
            <div class="search-icon" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
              <a href="../img/cap (2).jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-2">
                <i class="fas fa-search-plus"></i>
              </a>
              <div class="message-box" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; width: 100%;">
                <p>JPAMS Private Resort is a budget-friendly, family-friendly getaway shared spaces</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 wow fadeInUp" data-wow-delay="0.6s">
          <div class="gallery-item">
            <img src="../img/cap (3).jpg" class="img-fluid rounded w-100 h-100" alt="">
            <div class="search-icon" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
              <a href="../img/cap (3).jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-3">
                <i class="fas fa-search-plus"></i>
              </a>
              <div class="message-box" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; width: 100%;">
                <p>JPAMS Private Resort is a budget-friendly, family-friendly getaway a pool</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 wow fadeInUp" data-wow-delay="0.2s">
          <div class="gallery-item">
            <img src="../img/1 (4).jpg" class="img-fluid rounded w-100 h-100" style="object-fit: cover;" alt="">
            <div class="search-icon" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
              <a href="../img/1 (4).jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-4">
                <i class="fas fa-search-plus"></i>
              </a>
              <div class="message-box" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; width: 100%;">
                <p>JPAMS Private Resort is a budget-friendly, family-friendly getaway a pool</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 wow fadeInUp" data-wow-delay="0.4s">
          <div class="gallery-item">
            <img src="../img/1 (5).jpg" class="img-fluid rounded w-100 h-100" alt="">
            <div class="search-icon" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
              <a href="../img/1 (5).jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-5">
                <i class="fas fa-search-plus"></i>
              </a>
              <div class="message-box" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; width: 100%;">
                <p>JPAMS Private Resort is perfect for a fun and relaxing vacation.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
          <div class="gallery-item">
            <img src="../img/cap 6.jpg" class="img-fluid rounded w-100 h-100" alt="">
            <div class="search-icon" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
              <a href="../img/cap 6.jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-6">
                <i class="fas fa-search-plus"></i>
              </a>
              <div class="message-box" style="margin-top: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; width: 100%;">
                <p>jPAMS.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Gallery End -->

  <!-- Footer Start -->
  <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
      <div class="row g-5">
        <div class="col-md-6 col-lg-6 col-xl-4">
          <div class="footer-item">
            <a href="customer_dashboard.php" class="p-0">
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
            <a href="../about.php"><i class="fas fa-angle-right me-2 "></i> About Us</a>
            <a href="../feature.php"><i class="fas fa-angle-right me-2 "></i> Feature</a>
            <a href="../attraction.php"><i class="fas fa-angle-right me-2 "></i> Attractions</a>
            <a href="../package.php"><i class="fas fa-angle-right me-2 "></i> Packages</a>
            <a href="../contact.php"><i class="fas fa-angle-right me-2 "></i> Contact us</a>
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
          <span class="text-body"><a href="customer_dashboard.php" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>JPAMS</a>, All right
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


  <script>
    $(document).ready(function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Default view

        // Fetch events from the server
        events: function(fetchInfo, successCallback, failureCallback) {
          $.ajax({
            url: 'fetch-events.php', // PHP file to fetch the events
            dataType: 'json',
            success: function(response) {
              var events = [];
              // Process each event from the response
              $.each(response, function(index, item) {
                console.log(item.title);
                
                events.push({
                  title: item.title, // Title: Room number
                  start: item.start, // Arrival date
                  end: item.end, // Departure date (optional)
                  extendedProps: { // Additional data
                    guest_id: item.extendedProps.guest_id, // Guest ID
                    status: item.extendedProps.status, // Reservation status
                    confirmation: item.extendedProps.confirmation, // Confirmation code
                    reservation_id: item.extendedProps.reservation_id // Reservation ID
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
                    <strong>${info.event.title}</strong><br>
                    <small>Guest ID: ${info.event.extendedProps.guest_id}</small><br>
                    <small>Status: ${info.event.extendedProps.status}</small><br>
                    <small>Confirmation: ${info.event.extendedProps.confirmation}</small>
                </div>
            `;
          // Return the custom HTML to be displayed
          return {
            html: customHtml
          };
        },

        eventColor: '#32cd32' // Customize event color
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






  <!-- Template Javascript -->
  <script src="../js/main.js"></script>
</body>

</html>