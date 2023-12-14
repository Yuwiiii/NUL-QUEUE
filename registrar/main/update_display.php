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

    // Insert a new row into the display table
    $insertSql = "INSERT INTO `display` (`queue_number`, `window`, `officeName`) VALUES ('$queueNumber', $windowNumber, '$officeName')";
    $insertResult = $conn->query($insertSql);

    if ($insertResult) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update display table."]);
    }
}

$conn->close();
?>
