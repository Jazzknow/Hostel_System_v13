<?php
include 'php/connection.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    $sql = "SELECT arrival_time, accompany, departure_time FROM room_reservation WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $row['arrival_time'] = date('h:i A', strtotime($row['arrival_time']));
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Booking not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No ID provided']);
}

$conn->close();
/****** 
include 'php/connection.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    $sql = "SELECT num_days, arrival_time, accompany FROM room_reservation WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $arrival_time = new DateTime($row['arrival_time']);
        $departure_time = clone $arrival_time;
        $departure_time->modify('+21 hours');

        $row['arrival_time'] = date('h:i A', strtotime($row['arrival_time']));
        $row['departure_time'] = $departure_time->format('h:i A');

        echo json_encode($row);

    } else {
        echo json_encode(['error' => 'Booking not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No ID provided']);
}

$conn->close(); *****/
?>