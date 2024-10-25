<?php
// Database connection (update with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplayadb"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reservation data
$sql = "SELECT reservation_id, roomNo, guest_id, arrival, departure, status, confirmation FROM reservation";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => 'Room ' . $row['roomNo'], // Using room number as title
            'start' => $row['arrival'], // Reservation start date
            'end' => $row['departure'],  // Reservation end date (optional)
            'extendedProps' => [ // Pass additional data
                'guest_id' => $row['guest_id'],
                'status' => $row['status'],
                'confirmation' => $row['confirmation'],
                'reservation_id' => $row['reservation_id'] // Reservation ID
            ]
        ];
    }
}

// Return data as JSON
echo json_encode($events);

$conn->close();
