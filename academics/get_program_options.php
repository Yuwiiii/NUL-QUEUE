<?php
// Include your database connection file (db_connection.php)
include("db_connection.php");

// Fetch program options from the academics_queue table
$programQuery = "SELECT DISTINCT acronym FROM colleges";
$programResult = $conn->query($programQuery);

$options = array();

while ($row = $programResult->fetch_assoc()) {
    $options[] = $row['acronym'];
}

// Close the database connection
$conn->close();

// Return the options in JSON format
header('Content-Type: application/json');
echo json_encode($options);
?>
