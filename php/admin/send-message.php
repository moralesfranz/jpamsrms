<?php
session_start();
require_once "../../require/config.php";

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'admin') {
  $message = $_POST['message'];
  $recipientId = $_POST['recipient_id'];

  if (!isset($_POST['recipient_id'])) {
    echo json_encode([
      'success' => false,
      'message' => 'Recipient ID is required.'
    ]);
    return;
  }

  if (empty($message)) {
    echo json_encode([
      'success' => false,
      'message' => 'Message cannot be empty.'
    ]);
    return;
  }

  $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, content) VALUES (?, ?, ?)");
  if ($stmt === false) {
    error_log("Message insert prepare failed: " . $conn->error);
    echo json_encode([
      'success' => false,
      'message' => 'Internal server error.'
    ]);
    return;
  }

  $userId = $_SESSION['user_id'];
  $success = true;

  $stmt->bind_param("iis", $userId, $recipientId, $message);

  if (!$stmt->execute()) {
    $success = false;
    error_log("Failed to send message" . $conn->error);
  }

  $stmt->close();

  if ($success) {
    echo json_encode([
      'success' => true,
      'message' => 'Message sent successfully.'
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Error: Failed to send message.'
    ]);
  }
}

$conn->close();