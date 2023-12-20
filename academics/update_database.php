<?php
session_start();

// Include your database connection file (db_connection.php)
include("db_connection.php");

// Check if the 'queue_number' parameter is set in the POST request
if (isset($_POST['queue_number'])) {
    // Sanitize the input to prevent SQL injection
    $queueNumber = mysqli_real_escape_string($conn, $_POST['queue_number']);

    // Update the 'availability' status in the academics_queue table
    $sql = "UPDATE academics_queue SET availability = 0 WHERE queue_number = '$queueNumber'";
    $sql2 = "UPDATE academics_queue SET status = 0 WHERE queue_number = '$queueNumber'";

    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
        echo "Database updated successfully";
    } else {
        echo "Error updating database: " . $conn->error;
    }
} else {
    echo "Queue number not provided.";
}

// Close the database connection
$conn->close();
?>
