<?php
// Include your database connection and necessary files
include('../../../userpages/db_connection.php'); // Make sure this path is correct

if (isset($_GET['id'])) {
    $imageId = $_GET['id'];

    // Fetch the image data from the database using the ID
    $query = "SELECT imgType, imgData FROM reservation WHERE reservation_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $imageId); // "i" indicates the imageId is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Set the content type header based on the image type
        header("Content-Type: " . $row['imgType']);
        echo $row['imgData']; // Output the image data
    } else {
        echo "Image not found.";
    }
} else {
    echo "Invalid request.";
}
?>