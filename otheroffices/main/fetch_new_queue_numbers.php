<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT queue_number, timestamp FROM guidance";
$result = $conn->query($sql);

$newQueueNumbers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $newQueueNumbers[] = array(
            'queue_number' => $row['queue_number'],
            'timestamp' => $row['timestamp']
        );
    }
}

// Custom function to sort the array based on the timestamp
usort($newQueueNumbers, function($a, $b) {
    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
});

// Extract only the queue numbers after sorting
$sortedQueueNumbers = array_column($newQueueNumbers, 'queue_number');

echo json_encode($sortedQueueNumbers);

$conn->close();
?>
