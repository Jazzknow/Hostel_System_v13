<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_tab.png" type="x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login | Hostel Management </title>
    <link rel="stylesheet" href="../assets/css/user_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .signup-redirect-3 {
            text-align: start;
            margin-top: 20px;
        }

        .signup-redirect-3 p {
            font-size: 12px;
            color: #fefdfd;
            margin: 0;
        }

        .signup-redirect-3 a {
            color: #feffff;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-redirect-3 a:hover {
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-decoration-skip-ink: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="form-title">User Login Form</h1>
        <form id="form" class="form" method="POST">
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email" autocomplete="email">
                    <small>Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter password"
                            autocomplete="new-password">
                        <i class="fas fa-eye password-toggle"></i>
                    </div>
                    <small>Error Message</small>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const passwordInput = document.getElementById('password');
                        const passwordToggle = document.querySelector('.password-toggle');

                        passwordToggle.addEventListener('click', function () {
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                passwordToggle.classList.remove('fa-eye');
                                passwordToggle.classList.add('fa-eye-slash');
                            } else {
                                passwordInput.type = 'password';
                                passwordToggle.classList.remove('fa-eye-slash');
                                passwordToggle.classList.add('fa-eye');
                            }
                        });
                    });
                </script>
            </div>
            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" id="remember" name="remember"> Remember me
                </label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="form-submit-btn">
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="signup-container">
            <div class="signup-redirect">
                <p>Don't have an account? <a href="user_registration.php">Sign up</a></p>
            </div>
            <div class="line"></div>
            <div class="signup-redirect-2">
                <p> Not a User? <a href="index.php">Login as Admin</a></p>
            </div>
            <div class="signup-redirect-3">
                <p><a href="../website/homepage.php">Go to Website</a></p>
            </div>
        </div>
    </div>
</body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hostel_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_tbl WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            echo '<script>alert("Log-In Successfully!");</script>';
            echo '<script>window.location.href = "#";</script>';
        } else {
            echo '<script>alert("Invalid Email or Passsword");</script>';
            echo '<script>window.location.href = "index.php";</script>';
        }
    } else {
        echo '<script>alert("Error. Please try again.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
    }
}

$conn->close();
?>

</html>