<?php
session_start();
require_once "../../require/config.php";

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'admin') {
  $adminId = $_SESSION['user_id'];
  
  // Check if a customer ID is provided
  if (!isset($_GET['customer_id'])) {
    echo json_encode([
      'success' => false,
      'message' => 'Customer ID is required.'
    ]);
    exit;
  }
  
  $customerId = $_GET['customer_id'];

  // Fetch all messages between the admin and the selected customer
  $stmt = $conn->prepare("
    SELECT m.*, 
          CASE 
              WHEN m.sender_id = ? THEN 'admin'
              ELSE 'customer'
          END AS sender_type
    FROM messages m
    WHERE (m.sender_id = ? AND m.recipient_id = ?)
      OR (m.sender_id = ? AND m.recipient_id = ?)
    ORDER BY m.created_at ASC
  ");

  if ($stmt === false) {
    error_log("Prepare failed: " . $conn->error);
    echo json_encode([
      'success' => false,
      'message' => 'Internal server error.'
    ]);
    exit;
  }

  $stmt->bind_param("iiiii", $adminId, $adminId, $customerId, $customerId, $adminId);

  if (!$stmt->execute()) {
    echo json_encode([
      'success' => false,
      'message' => 'Error: ' . $conn->error
    ]);
    exit;
  }

  $result = $stmt->get_result();
  $messages = [];

  while ($row = $result->fetch_assoc()) {
    $messages[] = [
      'id' => $row['id'],
      'sender_id' => $row['sender_id'],
      'recipient_id' => $row['recipient_id'],
      'content' => $row['content'],
      'created_at' => $row['created_at'],
      'sender_type' => $row['sender_type']
    ];
  }

  echo json_encode([
    'success' => true,
    'messages' => $messages
  ]);

  $stmt->close();
} else {
  echo json_encode([
    'success' => false,
    'message' => 'User not logged in or not an admin.'
  ]);
}

$conn->close();