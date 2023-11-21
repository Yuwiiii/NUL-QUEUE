<?php
// Assuming you have a database connection established in this file
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$program = $_GET['program'];
$sql = "SELECT full_name FROM program_chairs WHERE program = '$program'";
$result = $conn->query($sql);

$concerns = array();
while ($row = $result->fetch_assoc()) {
    $concerns[] = $row;
}

echo json_encode($concerns);
?>