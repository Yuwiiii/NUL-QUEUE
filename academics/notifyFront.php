<?php
// Include your database connection code
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the queuenumber from the POST data
    $queuenumber = $_POST["queuenumber"];
    $success = true; // A flag to track the overall success of the updates

    // Update the 'queue' table
    $updateQueueStatusSql = "UPDATE academics_queue SET status = 1 WHERE queue_number = '$queuenumber'";
    if ($conn->query($updateQueueStatusSql) !== TRUE) {
        $success = false;
    }

    // Update the 'academics' table
    $updateAcademicsStatusSql = "UPDATE academics_queue SET status = 1 WHERE queue_number = '$queuenumber'";
    if ($conn->query($updateAcademicsStatusSql) !== TRUE) {
        $success = false;
    }

    // Close the database connection
    $conn->close();

    if ($success) {
        echo "success";
    } else {
        echo "error: One or more updates failed.";
    }
}
?>