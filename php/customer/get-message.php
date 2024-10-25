<?php
session_start();
require_once "../../require/config.php";

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'customer') {
  $userId = $_SESSION['user_id'];

  // Fetch all messages where the user is either the sender or recipient
  $stmt = $conn->prepare("
    SELECT m.*, 
            CASE 
                WHEN m.sender_id = ? THEN 'user'
                ELSE 'admin'
            END AS sender_type
    FROM messages m
    WHERE m.sender_id = ? OR m.recipient_id = ?
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

  $stmt->bind_param("iii", $userId, $userId, $userId);

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
    'message' => 'User not logged in.'
  ]);
}

$conn->close();