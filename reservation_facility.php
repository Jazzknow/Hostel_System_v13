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
    $event = $_POST['event'];
    $guest_category = $_POST['guest_category'];
    $facilityname = $_POST['facilityname'];
    $facility_type = $_POST['facility_type'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    if ($_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
        die("File upload error: " . $_FILES["photo"]["error"]);
    }

    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], "guestfacilityimage/" . $photo)) {
        die("Failed to move uploaded file.");
    }

    $checkin_date = new DateTime($_POST['checkin']);
    $checkout_date = new DateTime($_POST['checkout']);

    $datecheck = "SELECT * FROM facility_reservation 
            WHERE facilityname = ? 
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
        echo '<script>alert("Facility Unavailable Choose another date")</script>';
        echo '<script>window.location.href = "reservation_facility.php";</script>';
    } else {
        $sql = "INSERT INTO facility_reservation (fullname, email, address, phonenumber, guest_category, event, numguest, photo_facility, facilityname, facility_type, checkin, checkout, status) 
         VALUES ('$fullname', '$email', '$address', '$contactnum', '$guest_category','$event', '$numguest', '$photo', '$facilityname', '$facility_type', '$checkin', '$checkout', 'Reserved')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Successfully Added")</script>';
            echo '<script>window.location.href = "reservation_facility.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$sql3 = "SELECT facilityname FROM add_facility_management";
$result3 = $conn->query($sql3);

$facilitynames = array();
if ($result3->num_rows > 0) {
    while ($row = $result3->fetch_assoc()) {
        $facilitynames[] = $row["facilityname"];
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
                <h1>Facility Reservation Management</h1>
                <div class="breadcrumb">
                    <a href="reservation_room.php" id="refreshStats" class="btn btn-refresh">Add Room Reservation</a>
                </div>
            </div>
            <div class="four-box-container" style="margin-top: -20px;">
                <div class="breadcrumb">
                    <a href="#">Information about the Guest</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">Facility Reservation</a>
                </div>
            </div>

            <div class="four-box-container">
                <div class="guest-details">
                    <h2>Guest Details</h2>
                    <form method="post" enctype="multipart/form-data">
                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Fullname<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="fullname" required>
                            </div>

                            <div class="form-group">
                                <label>Email<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="email" required>
                            </div>

                            <div class="form-group">
                                <label>Address<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="address" required>
                            </div>

                            <div class="form-group">
                                <label>Contact Number<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="contactnum" required>
                            </div>
                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Guest Category<span class="login-danger">*</span></label>
                                <select class="form-control" name="guest_category" required>
                                    <option value="">Select Guest Category</option>
                                    <option value="outside guest">Outside guest</option>
                                    <option value="inside guest">Inside guest</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Event<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="event" required>
                            </div>

                            <div class="form-group">
                                <label>Number of guest<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="numguest" required>
                            </div>

                            <div class="form-group">
                                <label>Upload Valid ID<span class="login-danger">*</span></label>
                                <input type="file" name="photo" id="photo_facility">
                            </div>
                        </div>
                        <h2>Facility Details</h2>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Facility Name<span class="login-danger">*</span></label>
                                <Select class="form-control" name="facilityname" required>
                                    <option value="">Select Facility Name</option>
                                    <?php foreach ($facilitynames as $facilityname): ?>
                                        <option value="<?php echo htmlspecialchars($facilityname); ?>">
                                            <?php echo htmlspecialchars($facilityname); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Facility type<span class="login-danger">*</span></label>
                                <Select class="form-control" name="facility_type" required>
                                    <option value="Standard">Standard</option>
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
                                <input class="form-control" type="hidden">
                            </div>

                            <div class="form-group">
                                <p id="daysDisplay" class="text-center fw-bold"
                                    style="color: #007bff; align-items: center; justify-content:center;"></p>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden">
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