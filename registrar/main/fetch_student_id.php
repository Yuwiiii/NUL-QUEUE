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

if (isset($_GET['queueNumber'])) {
    $queueNumber = $_GET['queueNumber'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT student_id FROM registrar WHERE queue_number = ?");
    $stmt->bind_param("s", $queueNumber);
    $stmt->execute();
    $stmt->bind_result($studentId);

    // Fetch the result
    if ($stmt->fetch()) {
        $response = array('success' => true, 'student_id' => $studentId);
    } else {
        $response = array('success' => false, 'message' => 'Failed to fetch student ID');
    }

    $stmt->close();
} else {
    $response = array('success' => false, 'message' => 'Queue number not provided');
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
