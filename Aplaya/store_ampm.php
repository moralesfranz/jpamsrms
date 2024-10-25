<?php
session_start();

if (isset($_POST['ampm'])) {
    $ampmValue = $_POST['ampm'];  
    $datepost = $_POST['from'];  
    
    $_SESSION['ampm'] = $ampmValue;
    $_SESSION['from'] = $datepost;
    
    echo json_encode(['status' => 'success', 'ampmValue' => $ampmValue]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No ampm value received']);
}