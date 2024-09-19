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
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $contactnum = $_POST["contactnum"];
    $numguest = $_POST["numguest"];
    $photo = $_FILES["photo"]["name"];
    $roomtype = $_POST['roomtype'];
    $roomnumber = $_POST['roomnumber'];
    $checkin = $_POST['checkin'];
    $amenities = $_POST['amenities'];
    $checkout = $_POST['checkout'];
    $accompany = $_POST['accompany'];

    if ($_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
        die("File upload error: " . $_FILES["photo"]["error"]);
    }

    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], "guestimage/" . $photo)) {
        die("Failed to move uploaded file.");
    }

    $checkin_date = new DateTime($_POST['checkin']);
    $checkout_date = new DateTime($_POST['checkout']);

    $datecheck = "SELECT * FROM room_reservation 
            WHERE roomnumber = ? 
            AND ((checkin <= ? AND checkout > ?) 
            OR (checkin < ? AND checkout >= ?) 
            OR (checkin >= ? AND checkout < ?))";

    $stmt = $conn->prepare($datecheck);
    $stmt->bind_param(
        "sssssss",
        $roomnumber,
        $checkout_date->format('Y-m-d'),
        $checkin_date->format('Y-m-d'),
        $checkout_date->format('Y-m-d'),
        $checkin_date->format('Y-m-d'),
        $checkin_date->format('Y-m-d'),
        $checkout_date->format('Y-m-d')
    );
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<script>alert("Room is not available for the selected dates. Please choose different dates.");</script>';
        echo '<script>window.location.href = "reservation_room.php";</script>';
    } else {
        if (isset($_POST['checkin']) && isset($_POST['checkout'])) {
            $checkin_date = new DateTime($_POST['checkin']);
            $checkout_date = new DateTime($_POST['checkout']);
            
            $interval = $checkin_date->diff($checkout_date);
            
            $num_days = $interval->days;

            $sql = "INSERT INTO room_reservation (fullname, email, address, phonenumber, Totalguest, guestimage, roomtype, roomnumber, checkin, checkout, amenities, status, accompany, num_days) 
                VALUES ('$fullname', '$email', '$address', '$contactnum', '$numguest','$photo', '$roomtype', '$roomnumber', '$checkin', '$checkout', '$amenities', 'Reserved', '$accompany', '$num_days')";

            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("Successfully Added")</script>';
                echo '<script>window.location.href = "reservation_room.php";</script>';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$sql3 = "SELECT roomnumber FROM add_room_management";
$result3 = $conn->query($sql3);

$roomnumbers = array();
if ($result3->num_rows > 0) {
    while ($row = $result3->fetch_assoc()) {
        $roomnumbers[] = $row["roomnumber"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>

<body>
    <?php include 'includes/sidebar.php'; ?>
    <div id="main-content">
        <?php include 'includes/header.php'; ?>

        <main>
            <div class="four-box-container">
                <h1>Room Reservation Management</h1>
                <div class="breadcrumb">
                    <a href="reservation_facility.php" id="refreshStats" class="btn btn-refresh">Add facility Reservation</a>
                </div>
            </div>
            <div class="four-box-container" style="margin-top: -20px;">
                <div class="breadcrumb">
                    <a href="#">Information about the Guest</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">Room Reservation</a>
                </div>
            </div>            
                
            <div class="four-box-container">
                <div class="guest-details">
                    <h2>Guest Details</h2>
                    <form method="post" enctype="multipart/form-data">
                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Full Name<span style="color:red"> *</span></label>
                                <input class="form-control" type="text" name="fullname" required>
                            </div>

                            <div class="form-group">
                                <label>Email <span style="color:red"> *</span></label>
                                <input class="form-control" type="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label>Address<span style="color:red"> *</span></label>
                                <input class="form-control" type="text" name="address" required>
                            </div>

                            <div class="form-group">
                                <label>Contact Number<span style="color:red"> *</span></label>
                                <input class="form-control" type="text" name="contactnum" required>
                            </div>
                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Number of Guests<span class="login-danger">*</span></label>
                                <input class="form-control" type="number" name="numguest" required>
                            </div>

                            <div class="form-group">
                                <label>Upload Valid ID<span class="login-danger">*</span></label>
                                <input type="file" name="photo" id="photo" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>
                        </div>
                        <h2>Room Details</h2>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Room Type<span class="login-danger">*</span></label>
                                <select class="form-control" name="roomtype" required>
                                    <option value="">Select Room type</option>
                                    <option value="Standard Room">Standard Room</option>
                                    <option value="VIP Room">VIP Room</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Room Number<span class="login-danger">*</span></label>
                                <select class="form-control" name="roomnumber" required>
                                    <option value="">Select Room Number</option>
                                    <?php foreach ($roomnumbers as $roomnumber): ?>
                                        <option value="<?php echo htmlspecialchars($roomnumber); ?>">
                                            <?php echo htmlspecialchars($roomnumber); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Check-in<span class="login-danger">*</span></label>
                                <input class="form-control datetimepicker" type="date" name="checkin" id="checkin"
                                    required onchange="calculateDays()">
                            </div>

                            <div class="form-group">
                                <label>Check-out<span class="login-danger">*</span></label>
                                <input class="form-control datetimepicker" type="date" name="checkout" id="checkout"
                                    required onchange="calculateDays()">
                            </div>
                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Optional (if add more than 1 room)<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="optional">
                            </div>

                            <div class="form-group">
                                <label>Room<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="addroom">
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>
                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>

                            <div class="form-group">
                                <p id="daysDisplay" class="text-center fw-bold"
                                    style="color: #007bff; align-items: center; justify-content:center;"></p>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>
                        </div>

                        <h2>Accompany By:</h2>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <input class="form-control" type="text" name="accompany" required>
                            </div>
                        </div>

                        <h2>Amenities</h2>
                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Select Amenities:</label>
                                <div class="checkbox-group">
                                    <label><input type="checkbox" name="amenities" value="wifi"> Wi-Fi</label>
                                    <label><input type="checkbox" name="amenities" value="breakfast"> Breakfast</label>
                                    <label><input type="checkbox" name="amenities" value="parking"> Parking</label>
                                    <label><input type="checkbox" name="amenities" value="gym"> Gym Access</label>
                                    <label><input type="checkbox" name="amenities" value="pool"> Pool Access</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer" style="text-align: center;">
                            <button type="submit" name="submit"
                                style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Submit</button>
                        </div>

                    </form>
                </div>
            </div>

    </div>
    </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
        integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
        crossorigin="anonymous"></script>
    <script src="assets/js/experiment.js"></script>

    <script>
        function calculateDays() {
            const checkin = new Date(document.getElementById('checkin').value);
            const checkout = new Date(document.getElementById('checkout').value);
            const daysDisplay = document.getElementById('daysDisplay');

            if (checkin && checkout && checkout > checkin) {
                const diffTime = Math.abs(checkout - checkin);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                daysDisplay.textContent = `You're booking for ${diffDays} day${diffDays > 1 ? 's' : ''}.`;
            } else {
                daysDisplay.textContent = '';
            }
        }
    </script>



</body>

</html>