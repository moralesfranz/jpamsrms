<?php
session_start();

require '../require/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];

  // Check if the email exists in the database
  $sql = "SELECT id, email, user_type, password FROM users WHERE email = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  
  if ($result->num_rows > 0) {
      $user = mysqli_fetch_assoc($result);
      
      if (password_verify($password, $user['password'])) {
        // Correct password and creating session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['is_logged_in'] = true;
        
        echo json_encode([
          'success' => true, 
          'message' => 'success',
          'user_type' => $user['user_type']
        ]);
      } else {
        // Incorrect password
        echo json_encode([
          'success' => false, 
          'message' => 'Invalid credentials'
        ]);
      }
  } else {
    // User not found
    echo json_encode([
      'success' => false, 
      'message' => 'Invalid credentials'
    ]);
  }
  
  mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>