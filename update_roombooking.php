<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'php/connection.php';

$response = ['success' => false, 'message' => ''];

try {
    if (!isset($_POST['roomId'], $_POST['status'], $_POST['arrivalTime'], $_POST['days'])) {
        throw new Exception('Missing required parameters');
    }

    $roomId = $_POST['roomId'];
    $status = $_POST['status'];
    $arrivalTime = $_POST['arrivalTime'];
    $days = $_POST['days'];

    list($hours, $minutes) = explode(':', $arrivalTime);
    $hours = intval($hours);
    $minutes = intval($minutes);

    $totalMinutes = $hours * 60 + $minutes;

    $additionalMinutes = $days * 21 * 60;

    $totalMinutes += $additionalMinutes;

    $newHours = floor($totalMinutes / 60) % 24;
    $newMinutes = $totalMinutes % 60;

    $formattedTime = sprintf('%02d:%02d', $newHours, $newMinutes);

    $sql = "UPDATE room_reservation SET status = ?, arrival_time = ?, departure_time = '$formattedTime' WHERE room_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("ssi", $status, $arrivalTime, $roomId);

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    if ($stmt->affected_rows > 0) {
        $response['success'] = true;
        $response['message'] = 'Booking updated successfully';
    } else {
        $response['message'] = 'No rows were updated';
    }

    $stmt->close();
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);