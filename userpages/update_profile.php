<?php
// Include database connection
session_start(); // Start the session
if (!include 'db_connection.php') {
    die("Failed to include database connection.");
}

// Get data from POST
$name = $_POST['name'];
$email = $_POST['email'];
$bio = $_POST['bio'];
$userId = 1; // Assuming you are updating the user with ID 1

// Prepare and execute the SQL update statement
$query = "UPDATE usersp SET name = ?, email = ?, bio = ? WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sssi", $name, $email, $bio, $userId);

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

// Close the statement and connection
$stmt->close();
$conn->close();
