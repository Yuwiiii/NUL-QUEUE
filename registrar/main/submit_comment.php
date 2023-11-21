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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $queueNumber = $_POST['queueNumber'];
    $comment = $_POST['comment'];

    // Update the remarks and transaction in registrar_done table
    $updateSql = "UPDATE registrar_logs SET remarks = '$comment', transaction = 'Completed' WHERE queue_number = '$queueNumber'";

    if ($conn->query($updateSql) === true) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => "Error updating record in registrar_logs table: " . $conn->error));
    }
} else {
    echo json_encode(array('success' => false, 'message' => "Invalid request method."));
}

$conn->close();
?>
