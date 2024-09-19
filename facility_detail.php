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
    $facilityname = $_POST["facilityname"];
    $facilitytype = $_POST["facilitytype"];
    $facilitycapacity = $_POST["facilitycapacity"];
    $facilityprice = $_POST["facilityprice"];
    $areasize = $_POST["areasize"];
    $amenities = isset($_POST['amenities']);

    $photo = $_FILES["photo"]["name"];
    $photoTmp = $_FILES["photo"]["tmp_name"];
    $photoError = $_FILES["photo"]["error"];

    if ($photoError !== UPLOAD_ERR_OK) {
        die("File upload error: " . $photoError);
    }

    $photoPath = "addfacility/" . basename($photo);
    if (!move_uploaded_file($photoTmp, $photoPath)) {
        die("Failed to move uploaded file.");
    }
    
    $stmt = $conn->prepare("INSERT INTO add_facility_management (facilityname, facilitytype, facilitycapacity,facilityprice, areasize, photo, amenities) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddsss", $facilityname, $facilitytype, $facilitycapacity, $facilityprice, $areasize, $photo, $amenities);

    if ($stmt->execute()) {
        echo '<script>alert("Successfully Added")</script>';
        echo '<script>window.location.href = "facility_detail.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
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
                <h1>Facility Management</h1>
                <div class="breadcrumb">
                    <a href="#">Details</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">Facility</a>
                </div>
            </div>

            <div class="four-box-container">
                <div class="guest-details">
                    <h3>Add New Facility</h3>
                    <form method="post" enctype="multipart/form-data">
                        <div class="guest-info-row">
                            <div class="form-group">
                                <input class="form-control" type="hidden">
                            </div>

                            <div class="form-group">
                                <input type="file" id="file" accept="image/*" name="photo" hidden>
                                <div class="img-area" data-img="">
                                    <i class='bx bxs-cloud-upload icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Image size must be less than <span>2MB</span></p>
                                </div>
                                <button type="button" class="select-image" id="selectImageBtn">Select Image</button>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden">
                            </div>

                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Facility Name<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="facilityname" required>
                            </div>

                            <div class="form-group">
                                <label>Facility type<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="facilitytype" required>
                            </div>

                            <div class="form-group">
                                <label>facility Capacity<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="facilitycapacity" required>
                            </div>

                            <div class="form-group">
                                <label>Facility Price<span class="login-danger">*</span></label>
                                <input class="form-control" type="number" name="facilityprice" required>
                            </div>
                        </div>

                        <div class="guest-info-row">
                            <div class="form-group">
                                <label>Area Size<span class="login-danger">*</span></label>
                                <input class="form-control" type="text" name="areasize" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="hidden" required>
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
    <script src="assets/js/img.js"></script>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('file');
            const selectImageBtn = document.getElementById('selectImageBtn');
            const imgArea = document.querySelector('.img-area');

            selectImageBtn.addEventListener('click', function () {
                fileInput.click();
            });

            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function () {
                        const allImg = imgArea.querySelectorAll('img');
                        allImg.forEach(item => item.remove());
                        const imgUrl = reader.result;
                        const img = document.createElement('img');
                        img.src = imgUrl;
                        imgArea.appendChild(img);
                        imgArea.classList.add('active');
                        imgArea.dataset.img = file.name;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

</body>

</html>