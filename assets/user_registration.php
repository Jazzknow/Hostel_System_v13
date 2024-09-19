<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration | Hostel Management </title>
    <link rel="stylesheet" href="../assets/css/user_registration.css">
    <link rel="icon" href="img/logo_tab.png" type="x-icon">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .user-input-box {
            position: relative;
        }

        .user-input-box input[type="password"] {
            padding-right: 35px;
        }

        .user-input-box .password-toggle {
            position: absolute;
            right: 21px;
            top: 55%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 15px;
            color: #666;
        }

        .user-input-box .confirmpass-toggle {
            position: absolute;
            right: 9px;
            top: 55%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 15px;
            color: #666;
        }

        .g-recaptcha {
            margin-top: 20px;
        }

        .form-submit-btn {
            margin-top: 20px;
        }

        .form-submit-btn input.enabled {
            cursor: pointer;
            /* Change to pointer when enabled */
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: hidden;
            /* Prevent scrolling */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            /* Center horizontally */
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            max-width: 500px;
            /* Optional: Limit maximum width */
            height: auto;
            /* Adjust height based on content */
            position: relative;
            /* Position relative to allow absolute positioning inside */
            top: 50%;
            /* Center vertically */
            transform: translateY(-50%);
            /* Adjust for center alignment */
            text-align: center;
            /* Center text */
        }

        .modal-footer {
            position: absolute;
            /* Position absolutely relative to the modal-content */
            bottom: 20px;
            /* Adjust as needed */
            left: 50%;
            /* Center horizontally */
            transform: translateX(-50%);
            /* Adjust for center alignment */
            width: 100%;
            /* Full width of the modal-content */
            text-align: center;
            /* Center the text inside */
        }


        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #3085d6;
        }

        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="form-title">User Registration Form</h1>
        <form id="form" method="POST">
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter Full Name" autocomplete="name">
                    <small>Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" autocomplete="email">
                    <small class="error3">Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="address">Complete Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter Complete Address"
                        autocomplete="add">
                    <small class="error">Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter Phone Number" autocomplete="tel">
                    <small class="error">Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password"
                        autocomplete="new-password">
                    <i class="fas fa-eye password-toggle" id="password-toggle"></i>
                    <small>Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="confirmpass">Confirm Password</label>
                    <input type="password" id="confirmpass" name="confirmpass" placeholder="Confirm Password"
                        autocomplete="new-password">
                    <i class="fas fa-eye confirmpass-toggle" id="confirmpass-toggle"></i>
                    <small class="error2">Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="confirmpass">ID Type</label>
                    <input type="password" id="confirmpass" name="confirmpass" placeholder="Confirm Password"
                        autocomplete="new-password">
                    <small class="error2">Error Message</small>
                </div>
                <div class="user-input-box">
                    <label for="confirmpass">ID Number</label>
                    <input type="password" id="confirmpass" name="confirmpass" placeholder="Confirm Password"
                        autocomplete="new-password">
                    <small class="error2">Error Message</small>
                </div>
                <div class="user-input-box">
                    <div class="pht">
                        <label for="photo">Upload ID Photo</label>
                        <input type="file" id="photo" name="photo" autocomplete="upload-photo"
                            onchange="previewPhoto()">
                        <img id="photoPreview" src="" alt="Photo Preview" style="display: none;">
                        <small class="error">Error Message</small>
                    </div>
                </div>

                <script>
                    function previewPhoto() {
                        const fileInput = document.getElementById('photo');
                        const photoPreview = document.getElementById('photoPreview');

                        if (fileInput.files && fileInput.files[0]) {
                            const reader = new FileReader();

                            reader.onload = function (e) {
                                photoPreview.src = e.target.result;
                                photoPreview.style.display = 'block'; // Show the preview image
                            }

                            reader.readAsDataURL(fileInput.files[0]);
                        } else {
                            photoPreview.style.display = 'none'; // Hide the preview image if no file is chosen
                        }
                    }
                </script>
                <div class="gender-details-box">
                    <span class="gender-title">Gender</span>
                    <div class="gender-category">
                        <input type="radio" name="gender" id="male" value="male">
                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="female" value="female">
                        <label for="female">Female</label>
                    </div>
                </div>
            </div>

            <div class="g-recaptcha" data-sitekey="6LecvTQqAAAAADf6YlyB-eP9JZzItJI_a3IEsscV"></div>
            <label class="terms">By creating an account you agree to our <a href="#">Terms and Conditions</a> and our <a
                    href="#">Privacy Policy</a></label>
            <div class="form-submit-btn">
                <input type="submit" value="Register">
            </div>
        </form>
        <div class="login-redirect">
            <p>Already have an account? <a href="user_login.php">Login here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');
            const confirmpassInput = document.getElementById('confirmpass');
            const confirmpassToggle = document.getElementById('confirmpass-toggle');
            const submitBtn = document.getElementById('submit-btn');

            function togglePasswordVisibility(input, icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            passwordToggle.addEventListener('click', function () {
                togglePasswordVisibility(passwordInput, passwordToggle);
            });

            confirmpassToggle.addEventListener('click', function () {
                togglePasswordVisibility(confirmpassInput, confirmpassToggle);
            });

            // Function to enable the submit button after reCAPTCHA validation
            window.enableSubmitBtn = function () {
                submitBtn.classList.add('enabled');
                submitBtn.disabled = false; // Enable the submit button
            }

            // Disable submit button initially
            submitBtn.disabled = true;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById("form");

            const fullname = document.getElementById("fullname");
            const email = document.getElementById("email");
            const phone = document.getElementById("phone");
            const password = document.getElementById("password");
            const confirmpass = document.getElementById("confirmpass");

            function showError(input, message) {
                const userinputbox = input.parentElement;
                userinputbox.className = "user-input-box error";
                const small = userinputbox.querySelector("small");
                small.innerText = message;
            }

            function showSuccess(input) {
                const userinputbox = input.parentElement;
                userinputbox.className = "user-input-box success";
            }


            function checkPasswordLength(password, min, max) {
                if (password.value.length < min) {
                    showError(password, `Must be at least ${min} characters`);
                } else if (password.value.length > max) {
                    showError(password, `Must be less than ${max} characters`);
                } else {
                    showSuccess(password);
                }
            }

            function isValidEmail(email) {
                const re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                return re.test(email);
            }

            form.addEventListener("submit", function (e) {
                e.preventDefault();

                let isValid = true;

                if (fullname.value.trim() === "") {
                    showError(fullname, "Fullname is required");
                    isValid = false;
                } else {
                    showSuccess(fullname);
                }

                if (email.value.trim() === "") {
                    showError(email, "Email is required");
                    isValid = false;
                } else if (!isValidEmail(email.value.trim())) {
                    showError(email, "Email is not valid");
                    isValid = false;
                } else {
                    showSuccess(email);
                }

                if (phone.value.trim() === "") {
                    showError(phone, "Phone Number is required");
                    isValid = false;
                } else {
                    showSuccess(phone);
                }

                if (password.value.trim() === "") {
                    showError(password, "Password is required");
                    isValid = false;
                } else {
                    checkPasswordLength(password, 6, 25);
                }

                if (confirmpass.value.trim() === "") {
                    showError(confirmpass, "Confirm Password is required");
                    isValid = false;
                } else if (password.value.trim() !== confirmpass.value.trim()) {
                    showError(confirmpass, "Passwords do not match");
                    isValid = false;
                } else {
                    showSuccess(confirmpass);
                }

                if (isValid) {
                    form.submit(); // Submit the form if valid
                }
            });
        });
    </script>
</body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hostel_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo $conn->connect_error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirmpass = $_POST["confirmpass"];
    $gender = $_POST["gender"];

    $email_check_sql = "SELECT * FROM user_tbl WHERE email ='$email'";
    $email_check_result = $conn->query($email_check_sql);
    if ($email_check_result->num_rows > 0) {
        echo '<script>alert("Email already exists");</script>';
        echo '<script>window.location.href = "registration.php";</script>';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_tbl (fullname, email, phone, password, gender) VALUES ('$fullname', '$email', '$phone', '$hashed_password', '$gender')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>
                // Create and display the modal
                document.addEventListener("DOMContentLoaded", function() {
                    var modal = document.createElement("div");
                    modal.className = "modal";
                    modal.id = "successModal";

                    var modalContent = document.createElement("div");
                    modalContent.className = "modal-content";

                    var closeSpan = document.createElement("div");
                    closeSpan.className = "close";
                    closeSpan.innerHTML = "&times;";
                    closeSpan.onclick = function () {
                        modal.style.display = "none";
                    };

                    var header = document.createElement("h2");
                    header.textContent = "Registration Successful!";

                    var message = document.createElement("p");
                    message.textContent = "Click the button below to go to your Gmail account.";

                    var gmailButton = document.createElement("button");
                    gmailButton.className = "btn btn-primary";
                    gmailButton.textContent = "Go to Gmail";
                    gmailButton.onclick = function () {
                        window.open("https://mail.google.com/", "_blank");
                    };

                    var stayButton = document.createElement("button");
                    stayButton.className = "btn btn-secondary";
                    stayButton.textContent = "Stay Here";
                    stayButton.onclick = function () {
                       window.location.href = "index.php";
                    };

                    modalContent.appendChild(closeSpan);
                    modalContent.appendChild(header);
                    modalContent.appendChild(message);
                    modalContent.appendChild(gmailButton);
                    modalContent.appendChild(stayButton);

                    modal.appendChild(modalContent);
                    document.body.appendChild(modal);

                    modal.style.display = "block";
                });
            </script>';
        } else {
            echo '<script>alert("Error ' . $sql . '\n' . $conn->error . '");</script>';
            echo '<script>window.location.href = "index.php";</script>';
        }
    }
}
$conn->close();
?>

</html>