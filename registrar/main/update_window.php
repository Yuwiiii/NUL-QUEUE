<?php
session_start();
$queueNumber = $_POST['queueNumber'];
$windowNumber = $_POST['windowNumber'];

// Validate $queueNumber and $windowNumber

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the window field in the registrar table
$updateQuery = "UPDATE registrar SET window = '$windowNumber' WHERE queue_number = '$queueNumber'";
$result = $conn->query($updateQuery);

if ($result) {
    echo json_encode(['success' => true]);

    // Optionally, you can insert a new row into the display table here
    // $insertQuery = "INSERT INTO `display` (`queue_number`, `window`) VALUES ('$queueNumber', $windowNumber)";
    // $insertResult = $conn->query($insertQuery);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update window']);
}

$conn->close();
?>
