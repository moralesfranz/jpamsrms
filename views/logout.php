// logout.php
<?php
session_start(); // Start the session to access the session data

// Destroy the session and its data
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session itself

// Redirect the user to the login page or homepage
header("Location:../index.php ");
exit();
?>