<?php
include 'php/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $facilityId = $_POST['facilityId'];
    $arrivalDate = $_POST['arrivalDate'];
    $numDays = $_POST['numDays'];

    // Calculate check-out date (21 hours per day)
    $checkoutDate = date('Y-m-d H:i:s', strtotime($arrivalDate . ' + ' . ($numDays * 21) . ' hours'));

    // Update the database
    $sql = "UPDATE facility_reservation SET status = 'Check-in', checkin = ?, checkout = ? WHERE facility_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $arrivalDate, $checkoutDate, $facilityId);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>