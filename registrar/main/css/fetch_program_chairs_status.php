<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT full_name, status FROM program_chairs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $programChairs = array();
    while ($row = $result->fetch_assoc()) {
        $programChairs[$row['full_name']] = $row['status'];
    }
    echo json_encode($programChairs);
} else {
    echo "No program chairs available";
}

$conn->close();
?>