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
                <h1>Manage Rooms</h1>
                <div class="breadcrumb">
                    <a href="#">Details</a>
                    <i class='bx bx-chevron-right'></i>
                    <a class="active" href="#">Room</a>
                </div>
            </div>

            <div class="four-box-container">
                <div class="box" style="display: flex; flex-direction: row;">
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: center;">Room Number</th>
                                <th style="text-align: center;">Room Type</th>
                                <th style="text-align: center;">Bed Type</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT roomnumber, roomtype, bedtype, status FROM add_room_management";
                            $result = $conn->query($sql);
                            $temp_value = "unknown";
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['roomnumber']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['roomtype']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['bedtype']) . "</td>";
                                    echo "<td>" . htmlspecialchars($temp_value) . "</td>";
                                    echo "<td>
                                                    <a href='room_management.php?id=" . htmlspecialchars($row['roomnumber']) . "'>View</a> |
                                                    <a href='room_management.php?id=" . htmlspecialchars($row['roomnumber']) . "'>Edit</a> 
                                                </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No Rooms found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>



        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
        integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
        crossorigin="anonymous"></script>
    <script src="assets/js/experiment.js"></script>



</body>

</html>