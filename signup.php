<?php
require_once './vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('192547642967-55c0n1rkuphejq5et6sso4fggcjudhga.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/jpams_resort_management_system/google-callback.php');
$client->addScope("email");
$client->addScope("profile");

$auth_url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
        @import url("http://fonts.cdnfonts.com/css/sf-pro-display");
        @import url('https://fonts.cdnfonts.com/css/sf-ui-text-2');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        @import url("https://use.typekit.net/ngj5fjz.css");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Sf Pro display', 'Public sans', sans-serif;
        }

        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            overflow: hidden;
            position: relative;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .intro-title {
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            color: #333;
        }

        .field {
            display: flex;
            flex-direction: column;
        }

        .name-field {
            display: flex;
            gap: 0.8rem;
        }

        .form-label {
            font-size: 14px;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .form-input {
            padding: 10px 12px;
            font-size: 0.95rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fafafa;
            transition: border-color 0.2s ease;
            width: 100%;
            font-size: 14px;
        }

        .form-input:focus {
            border-color: #007BFF;
            outline: none;
        }

        .submit-btn {
            padding: 16px;
            font-size: 14px;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s ease;
            height: 50px;
            font-weight: 500;
        }

        .submit-btn:hover {
            background-color: #3e3e3e;
        }

        .google-btn {
            font-size: 14px;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s ease;
            font-weight: 400;
            background: #f9f9f9;
            border: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            color: #555;
            gap: 6px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .google-btn:hover {
            background-color: #f0f2f5;
        }

        .or-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .or-line {
            width: 100%;
            height: 1px;
            background-color: #ddd;
        }

        .or-text {
            font-size: 14px;
            color: #aaa;
            background-color: white;
            position: absolute;
            padding-inline: 10px;
            text-transform: lowercase;
            font-weight: medium;
        }

        .redirect-text {
            font-size: 14px;
            color: gray;
            text-align: center;
        }

        .redirect-text a:hover {
            text-decoration: underline !important;
            color: #3e3e3e;
        }

        /* Error message styling */
        .error-message {
            display: none;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 40px;
            background: #fdeded;
            border-radius: 0.5rem;
            color: #5f2120;
            font-size: 14px;
            font-weight: 500;
        }

        .success-message {
            display: none;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 40px;
            background: #edf7ed;
            border-radius: 0.5rem;
            color: #1e4620;
            font-size: 14px;
            font-weight: 500;
        }

        .error-text {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form action="#" class="form" id="signup-form" method="POST">
            <h1 class="intro-title">Sign Up</h1>

            <div class="error-message"></div>
            <div class="success-message"></div>

            <div class="name-field">
                <div class="field">
                    <label for="first-name" class="form-label">
                        First Name
                    </label>
                    <input
                        id="first-name"
                        name="first-name"
                        placeholder="Juan"
                        class="form-input">
                    <span id="first-name-error" class="error-text"></span>
                </div>
                <div class="field">
                    <label for="last-name" class="form-label">
                        Last Name
                    </label>
                    <input
                        id="last-name"
                        name="last-name"
                        placeholder="Dela Cruz"
                        class="form-input">
                    <span id="last-name-error" class="error-text"></span>
                </div>
            </div>
            <div class="field">
                <label for="email" class="form-label">
                    Email
                </label>
                <input
                    id="email"
                    name="email"
                    placeholder="juandelacruz@example.com"
                    class="form-input">
                <span id="email-error" class="error-text"></span>
            </div>
            <div class="field">
                <label for="password" class="form-label">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    placeholder="******"
                    type="password"
                    class="form-input">
                <span id="password-error" class="error-text"></span>
            </div>
            <button class="submit-btn" type="submit">
                Sign up with credentials
            </button>

            <div class="or-container">
                <span class="or-text">or</span>
                <div class="or-line"></div>
            </div>

            <a class="google-btn" href="<?php echo $auth_url; ?>">
                <img width="25" height="25" src="https://th.bing.com/th/id/R.0fa3fe04edf6c0202970f2088edea9e7?rik=joOK76LOMJlBPw&riu=http%3a%2f%2fpluspng.com%2fimg-png%2fgoogle-logo-png-open-2000.png&ehk=0PJJlqaIxYmJ9eOIp9mYVPA4KwkGo5Zob552JPltDMw%3d&risl=&pid=ImgRaw&r=0" alt="Google logo">
                Sign up with google
            </a>
            <div class="redirect-text">
                Already have an account?
                <a href="signin.php" style="font-weight: 500; color: #333; text-decoration: none; ">Sign in</a>
            </div>
        </form>
    </div>
    <!-- Sign Up AJAX -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(() => {

            $('#signup-form').submit((e) => {
                e.preventDefault();

                // Clear previous error
                $('.error-text').text('').hide();

                // Get the value of the form fields
                var formData = {
                    'account_name': $('#first-name').val()+" "+$('#last-name').val(),
                    'account_username': $('#email').val(),
                    'account_password': $('#password').val(),
                };

                console.log(formData);
                

                $.ajax({
                    type: 'POST',
                    url: './php/signin.php',

                    data: formData,
                    dataType: 'json',
                    success: (response) => {
                        if (response.success) {
                            $('.success-message').css({
                                display: 'flex'
                            });
                            $('.success-message').text('Your account has been created').show();
                            $('.error-text').text('').hide();
                            $('#signup-form')[0].reset();

                            // After 5 seconds, redirect user to login page.
                            setTimeout(() => {
                                window.location.href = 'signin.php';
                            }, 5000);
                            return;
                        }

                        $.each(response.errors, (field, message) => {
                            $(`#${field}-error`).text(message).show();
                        });
                    },
                    error: (xhr, status, error) => {
                        $('.error-message').css({
                            display: 'flex'
                        });
                        $('.error-message').text(xhr.responseText).show();
                    }
                });
            });
        });
    </script>

</body>

</html>