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

// Fetch program chairs data from the database
$sql = "SELECT full_name, program FROM program_chairs";
$result = $conn->query($sql);

$programChairsData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $programChairsData[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return program chairs data as JSON
echo json_encode($programChairsData);
?>
