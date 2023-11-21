<?php

// Include your database connection code here
$db_host = "localhost"; // Change to your database host
$db_username = "root"; // Change to your database username
$db_password = ""; // Change to your database password
$db_name = "queuing_system"; // Change to your database name

// Create a connection to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['queue_number'])) {
    $selectedQueueNumber = $_POST['queue_number'];

    // Update availability and window to 0 in the database
    $sqlUpdateData = "UPDATE guidance SET availability = 0, window = 0 WHERE queue_number = '$selectedQueueNumber'";
    
    if ($conn->query($sqlUpdateData) !== TRUE) {
        $response = "Error updating data: " . $conn->error;
    } else {
        $response = "Data updated successfully";
    }

    echo $response;
} else {
    echo "Queue number not provided";
}
?>