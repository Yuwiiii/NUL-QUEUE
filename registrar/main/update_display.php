<?php
session_start();

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queueNumber = $_POST["queueNumber"];
    $windowNumber = $_POST["windowNumber"];
    $officeName = $_POST["officeName"];

    // Check if the queue number is already displayed
    $checkSql = "SELECT * FROM display WHERE queue_number = '$queueNumber' AND status = 0";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // If the queue number is already displayed, update the existing record
        $updateSql = "UPDATE display SET window = $windowNumber, officeName = '$officeName' WHERE queue_number = '$queueNumber' AND status = 0";
        $updateResult = $conn->query($updateSql);

        if ($updateResult) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update display table."]);
        }
    } else {
        // If the queue number is not displayed, insert a new record
        $insertSql = "INSERT INTO display (queue_number, window, officeName, status) VALUES ('$queueNumber', $windowNumber, '$officeName', 0)";
        $insertResult = $conn->query($insertSql);

        if ($insertResult) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update display table."]);
        }
    }
}

$conn->close();
?>