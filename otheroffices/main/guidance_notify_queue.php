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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $queueNumber = $_GET["queueNumber"];

    // Move the queue from 'guidance' table to 'notified_queues' table.
    $moveQuery = "INSERT INTO notified_queues (queue_number, timestamp, student_id, remarks) 
                  SELECT queue_number, NOW(), student_id, remarks FROM guidance WHERE queue_number = ?";
    $moveStatement = $conn->prepare($moveQuery);
    $moveStatement->bind_param("s", $queueNumber);

    $success = $moveStatement->execute();

    // Remove the queue number from the 'guidance' table.
    $deleteQuery = "DELETE FROM guidance WHERE queue_number = ?";
    $deleteStatement = $conn->prepare($deleteQuery);
    $deleteStatement->bind_param("s", $queueNumber);

    $deleteSuccess = $deleteStatement->execute();

    // Return success status as JSON.
    echo json_encode(["success" => $success && $deleteSuccess]);

    $moveStatement->close();
    $deleteStatement->close();
}

$conn->close();
?>
