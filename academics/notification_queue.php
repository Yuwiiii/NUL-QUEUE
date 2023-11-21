<?php
session_start();

// Include your database connection file (db_connection.php)
include("db_connection.php");

$response = array();

if (isset($_SESSION['full_name']) && isset($_SESSION['office'])) {
    $office = $_SESSION['office'];
    $full_name = $_SESSION['full_name'];
    // Check for new rows here
    $newRowSql = "SELECT * FROM academics_queue WHERE program = '$office' AND concern = '$full_name' ORDER BY id DESC LIMIT 1";
    $newRowResult = $conn->query($newRowSql);
    if ($newRowResult->num_rows > 0) {
        $newRow = $newRowResult->fetch_assoc();
        $response['newQueueNumber'] = $newRow['queue_number'];
        // Set a session variable to indicate that the notification has been shown
        $_SESSION['notificationShown'] = true;
    }
}

// Close the database connection
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
