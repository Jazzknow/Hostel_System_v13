<?php
include 'php/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomId = $_POST['roomId'];
    $status = $_POST['status'];

    // Sanitize inputs
    $roomId = mysqli_real_escape_string($conn, $roomId);
    $status = mysqli_real_escape_string($conn, $status);

    // Update the status in the database
    $sql = "UPDATE room_reservation SET status = '$status' WHERE room_id = '$roomId'";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>