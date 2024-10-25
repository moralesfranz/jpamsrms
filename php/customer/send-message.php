<?php
session_start();
require_once "../../require/config.php";

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'customer') {
  $message = $_POST['message'];

  if (empty($message)) {
    echo json_encode([
      'success' => false,
      'message' => 'Message cannot be empty.'
    ]);
    return;
  }

  // Get all admin ids
  $adminStmt = $conn->prepare("SELECT id FROM users WHERE user_type = 'admin'");
  if ($adminStmt === false) {
    error_log("Admin query prepare failed: " . $conn->error);
    echo json_encode([
      'success' => false,
      'message' => 'Internal server error.'
    ]);
    return;
  }

  if (!$adminStmt->execute()) {
    echo json_encode([
      'success' => false,
      'message' => 'Error fetching admin IDs: ' . $conn->error
    ]);
    return;
  }

  $adminResult = $adminStmt->get_result();
  $adminIds = [];

  while ($row = $adminResult->fetch_assoc()) {
    $adminIds[] = $row['id'];
  }

  $adminStmt->close();

  // Insert customer message for each admin.
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

  foreach ($adminIds as $adminId) {
    $stmt->bind_param("iis", $userId, $adminId, $message);

    if (!$stmt->execute()) {
      $success = false;
      error_log("Failed to send message to admin ID $adminId: " . $conn->error);
    }
  }

  $stmt->close();

  if ($success) {
    echo json_encode([
      'success' => true,
      'message' => 'Message sent to all admins successfully.'
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Error: Failed to send message to one or more admins.'
    ]);
  }
}

$conn->close();