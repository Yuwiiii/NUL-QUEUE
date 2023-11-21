<?php
session_start();

// Include your database connection file (db_connection.php)
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queueNumber = $_POST["queue_number"];

    // Prepare the SQL statement to delete the data
    $sql = "DELETE FROM academics_queue WHERE queue_number = '$queueNumber'";

    if ($conn->query($sql) === TRUE) {
        echo "Data deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>