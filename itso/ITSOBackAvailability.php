<?php
include '../database.php';

if (isset($_POST['queue_number'])) {
    $selectedQueueNumber = $_POST['queue_number'];

    // Update availability and window to 0 in the database
    $sqlUpdateData = "UPDATE itso SET availability = 0, window = 0 WHERE queue_number = '$selectedQueueNumber'";
    
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