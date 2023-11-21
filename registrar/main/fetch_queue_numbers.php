<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the queue table where the office is "REGISTRAR"
$sql = "SELECT student_id, queue_number, remarks, timestamp FROM queue WHERE office = 'REGISTRAR'";
$result = $conn->query($sql);

$newQueueData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Store the required data in an array
        $newQueueData[] = array(
            'student_id' => $row['student_id'],
            'queue_number' => $row['queue_number'],
            'remarks' => $row['remarks'],
            'timestamp' => $row['timestamp']
        );
    }
}

echo json_encode($newQueueData);

$conn->close();
?>
