<?php

include('../userpages/db_connection.php');

// Fetch reservation data
$sql = "SELECT reservation_id, roomNo, guest_id, arrival, departure, status, confirmation,departure FROM reservation 
where status='Confirmed' OR status='Checkedin'
group by arrival,departure
order by departure asc, roomNo asc";
$result = $conn->query($sql);

$events = [];

$daytour="";
$nighttour="";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => '', // Using room number as title
            'start' => $row['arrival'], // Reservation start date
            'end' => $row['departure'],  // Reservation end date (optional)
            'extendedProps' => [ // Pass additional data
                'guest_id' => $row['guest_id'],
                'status' => $row['status'],
                'confirmation' => $row['confirmation'],
                'reservation_id' => $row['reservation_id'] ,
                'departure' => $row['departure'],
                'roomNo' => $row['roomNo']
            ]
        ];
    }
}

// Return data as JSON
echo json_encode($events);

$conn->close();