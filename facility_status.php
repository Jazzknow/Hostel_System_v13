<?php
include 'php/connection.php';
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
                <h1>Room Status Monitoring</h1>
            </div>
            <div class="four-box-container" style="margin-top: -20px;">
                <div class="breadcrumb">
                    <a href="#">Here is the room status</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">Room status</a>
                </div>
            </div>      

            <div class="box-info-container">
                <div class="header-container" style="width: 100%; ">
                    <h4>Room Information</h4>
                </div>
                
                <div class="horizontal-box" style="width: 100%; margin-top: -15px;">
                    <table id="bookingTable">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Facility Name</th>
                                <th>Area Size</th>
                                <th>Maximum Occupancy</th>
                                <th>Deal Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT photo, facilityname, areasize, facilitycapacity, facilityprice,  status FROM add_facility_management";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><img src='addfacility/" . htmlspecialchars($row['photo']) . "' alt='Room Photo' class='room-photo' width='100' height='75'></td>";
                                    echo "<td>" . htmlspecialchars($row['facilityname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['areasize']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['facilitycapacity']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['facilityprice']) . "</td>";
                                    echo "<td style='color:grey;'><strong>" . htmlspecialchars($row['status']) . "</strong></td>";
                                    echo "<td>
                                                <a href='reservation_facility.php' style='background: #007bff; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none;'>Book Now</a>
                                            </td>
                                        </tr>
                                            </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No bookings found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="noResults">No results found</div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
        integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
        crossorigin="anonymous"></script>
    <script src="assets/js/experiment.js"></script>
    <script src="assets/js/roombooking.js"></script>
</body>
</html>