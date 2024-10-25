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
        @import url("http://fonts.cdnfonts.com/css/sf-pro-display");
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        @import url("https://use.typekit.net/ngj5fjz.css");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Sf Pro display', 'Montserrat', sans-serif;
            color: #1d1d1f;
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
            text-decoration: none;
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

        .forgot-btn {
            border: none;
            background: transparent;
            width: fit-content;
            align-self: flex-end;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            text-decoration: underline;
            cursor: pointer;
            transition: color 100ms ease-in;
        }

        .forgot-btn:hover {
            color: #555;
        }

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
    </style>
</head>

<body>
    <div class="form-container">
        <form action="#" class="form" method="POST" id="signin-form">
            <h1 class="intro-title">Sign In</h1>

            <div class="error-message"></div>

            <div class="field">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    name="email"
                    placeholder="juandelacruz@example.com"
                    class="form-input">
            </div>
            <div class="field">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    name="password"
                    placeholder="******"
                    type="password"
                    class="form-input">
            </div>
            <button
                class="forgot-btn"
                type="button"
                onclick="window.location.href='forgot_password.php'">
                Forgot password?
            </button>
            <button class="submit-btn" type="submit">
                Sign in with credentials
            </button>

            <div class="or-container">
                <span class="or-text">or</span>
                <div class="or-line"></div>
            </div>

            <a class="google-btn" type="button" href="<?php echo $auth_url; ?>">
                <img width="25" height="25" src="https://th.bing.com/th/id/R.0fa3fe04edf6c0202970f2088edea9e7?rik=joOK76LOMJlBPw&riu=http%3a%2f%2fpluspng.com%2fimg-png%2fgoogle-logo-png-open-2000.png&ehk=0PJJlqaIxYmJ9eOIp9mYVPA4KwkGo5Zob552JPltDMw%3d&risl=&pid=ImgRaw&r=0" alt="Google logo">
                Sign in with google
            </a>
            <div class="redirect-text">
                Don't have an account?
                <a href="signup.php" style="font-weight: 500; color: #333; text-decoration: none; ">Sign up</a>
            </div>
        </form>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(() => {
            $('#signin-form').submit((e) => {
                e.preventDefault();

                $('.error-message').text('').hide();

                $.ajax({
                    type: 'POST',
                    url: './php/signin.php',
                    data: $('#signin-form').serialize(),
                    dataType: 'json',
                    success: (response) => {
                        if (response.success && response.message === 'success') {
                            switch (response.user_type) {
                                case 'admin':
                                    window.location.href = 'views/admin_dashboard.php';
                                    break;
                                case 'customer':
                                    window.location.href = 'views/user_dashboard.php';
                                    break;
                            }
                        } else {
                            $('.error-message').text(response.message).css('display', 'flex');
                        }
                    },
                    error: (xhr, status, error) => {
                        $('.error-message').text('An error occurred. Please try again.').css('display', 'flex');
                    }
                });
            });
        });
    </script>
</body>

</html>