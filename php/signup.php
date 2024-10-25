<?php
require '../require/config.php';

$response = [
  'success' => false,
  'errors' => []
];

// Escape user input to protect against SQL injection
$firstName = mysqli_real_escape_string($conn, $_POST['first-name']);
$lastName = mysqli_real_escape_string($conn, $_POST['last-name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

// Validate input fields and add errors to response
if (empty($firstName)) {
  $response['errors']['first-name'] = 'First name is required';
}

if (empty($lastName)) {
  $response['errors']['last-name'] = 'Last name is required';
}

if (empty($email)) {
  $response['errors']['email'] = 'Email is required';
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $response['errors']['email'] = 'Please enter a valid email address';
}

if (empty($password)) {
  $response['errors']['password'] = 'Password is required';
} else if (strlen($password) < 6) {
  $response['errors']['password'] = 'Password must be at least 6 characters long';
}

if (empty($response['errors'])) {
  $sql = "SELECT * FROM users WHERE email = '{$email}'";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

  if (!$result) {
    $response['errors']['email'] = "Error: " . mysqli_error($conn);
  } else {
    $rowCount = mysqli_num_rows($result);

    if ($rowCount > 0) {
      $response['errors']['email'] = 'Email already exists';
    } else {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $defaultUserType = 'customer';

      $sql = "INSERT INTO users (user_type, first_name, last_name, email, password) VALUES ('{$defaultUserType}', '{$firstName}', '{$lastName}', '{$email}', '{$hashedPassword}')";

      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      if ($result) {
        $response['success'] = true;
      } else {
        $response['errors']['general'] = "Error: " . mysqli_error($conn);
      }
    }
  }
}

// Return the response as JSON
echo json_encode($response);