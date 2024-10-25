<?php
require_once 'vendor/autoload.php';
require_once './require/config.php';

session_start();

$client = new Google\Client();
$client->setClientId('192547642967-55c0n1rkuphejq5et6sso4fggcjudhga.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/jpams_resort_management_system/google-callback.php');

if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        $oauth2 = new Google\Service\Oauth2($client);
        $user_info = $oauth2->userinfo->get();

        $email = $user_info->getEmail();
        $name = $user_info->getName();
        $firstName = $user_info->getGivenName();
        $lastName = $user_info->getFamilyName();
        $avatar = $user_info->getPicture();
        $googleId = $user_info->getId();

        // Check if the user already exists by Google ID
        $sql = "SELECT * FROM users WHERE google_id = '{$googleId}'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($result) {
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                // User exists by Google ID, set session variables
                $user = mysqli_fetch_assoc($result);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['is_logged_in'] = true;

                // Redirect based on user type
                if ($user['user_type'] == 'admin') {
                    header('Location: views/admin_dashboard.php');
                    exit;
                } else if ($user['user_type'] == 'customer') {
                    header('Location: views/customer_dashboard.php');
                    exit;
                }
            } else {
                // If no Google ID is found, check if the email exists
                $sql = "SELECT * FROM users WHERE email = '{$email}'";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                if ($result && mysqli_num_rows($result) > 0) {
                    // Email exists, update the existing user with Google ID and avatar
                    $sql = "UPDATE users SET google_id = '{$googleId}', avatar = '{$avatar}' WHERE email = '{$email}'";
                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                    if ($result) {
                        // Retrieve the updated user's information
                        $sql = "SELECT * FROM users WHERE email = '{$email}'";
                        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                        if ($result) {
                            $user = mysqli_fetch_assoc($result);
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_email'] = $user['email'];
                            $_SESSION['user_type'] = $user['user_type'];
                            $_SESSION['is_logged_in'] = true;

                            // Redirect based on user type
                            if ($user['user_type'] == 'admin') {
                                header('Location: views/admin_dashboard.php');
                                exit;
                            } else if ($user['user_type'] == 'customer') {
                                header('Location: views/customer_dashboard.php');
                                exit;
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    // User does not exist, insert new user into the database
                    $defaultUserType = 'customer';
                    $sql = "INSERT INTO users (user_type, google_id, first_name, last_name, email, avatar) 
                            VALUES ('{$defaultUserType}', '{$googleId}', '{$firstName}', '{$lastName}', '{$email}', '{$avatar}')";
                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                    if ($result) {
                        // Retrieve the newly inserted user's ID
                        $newUserId = mysqli_insert_id($conn);

                        // Set session variables for the new user
                        $_SESSION['user_id'] = $newUserId;
                        $_SESSION['user_email'] = $email;
                        $_SESSION['user_type'] = $defaultUserType;
                        $_SESSION['is_logged_in'] = true;

                        // Redirect based on user type (default is customer)
                        header('Location: views/customer_dashboard.php');
                        exit;
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
} else {
    echo "Authentication failed. No authorization code received.";
}
