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

$sql = "SELECT acronym FROM colleges";
$result = $conn->query($sql);

$programs = array();
while ($row = $result->fetch_assoc()) {
    $programs[] = $row['acronym']; // Fetch the 'acronym' column from the result
}

// Debugging output
echo json_encode(array('data' => $programs));
?>
