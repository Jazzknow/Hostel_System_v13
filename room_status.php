<?php
include 'php/connection.php';

// Update reservation status to 'occupied' where status is 'checkin' and the check-in date is today
$today = date('Y-m-d');
$update_sql = "
    UPDATE add_room_management
    SET status = 'occupied'
    WHERE status = 'checkin' = ?
";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param('s', $today);
$stmt->execute();
$stmt->close();
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
                                <th>Room Number</th>
                                <th>Bed Type</th>
                                <th>Room Capacity</th>
                                <th>Room Price</th>
                                <th>Reservation Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // SQL query to fetch room information along with reservation status
                                $sql = "
                                    SELECT 
                                        rm.photo,
                                        rm.roomnumber, 
                                        rm.bedtype, 
                                        rm.roomcapacity, 
                                        rm.roomprice,
                                        rr.status AS reservation_status
                                    FROM 
                                        add_room_management rm
                                    LEFT JOIN 
                                        room_reservation rr ON rm.roomnumber = rr.roomnumber AND rr.status = 'checkin'
                                ";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Loop through the results
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td><img src='addrooms/" . htmlspecialchars($row['photo']) . "' alt='Room Photo' class='room-photo' width='100' height='75'></td>";
                                        echo "<td style='color:grey;'><strong>" . htmlspecialchars($row['roomnumber']) . "</strong></td>";
                                        echo "<td style='color:grey;'><strong>" . htmlspecialchars($row['bedtype']) . "</strong></td>";
                                        echo "<td style='color:grey;'><strong>" . htmlspecialchars($row['roomcapacity']) . "</strong></td>";
                                        echo "<td style='color:grey;'><strong>" . htmlspecialchars($row['roomprice']) . "</strong></td>";
                                        echo "<td style='color:grey;'><strong>" . htmlspecialchars($row['reservation_status'] ?? 'Available') . "</strong></td>";
                                        echo "<td>
                                                <a href='reservation_room.php?roomnumber=" . htmlspecialchars($row['roomnumber']) . "' 
                                                   style='background: #007bff; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none;'>Book Now</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No rooms found</td></tr>";
                                }

                                // Close the database connection
                                $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <div id="noResults" style="display: none;">No results found</div>
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
