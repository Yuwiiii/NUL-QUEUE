<?php
session_start();

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $queueNumber = $_POST['queueNumber'];
    $comments = $_POST['comments'];

    // Retrieve data from the registrar table based on the queue number
    $fetchDataSql = "SELECT * FROM registrar WHERE queue_number = '$queueNumber'";
    $result = $conn->query($fetchDataSql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Insert the data into the registrar_logs table
        $insertRegistrarLogsSql = "INSERT INTO registrar_logs (queue_number, student_id, endorsed_from, transaction, remarks, status, timeout, timestamp) VALUES (
            '" . $row['queue_number'] . "',
            '" . $row['student_id'] . "',
            'REGISTRAR',  -- Set endorsed_from to 'REGISTRAR'
            'COMPLETED',  -- Set transaction to 'COMPLETED'
            '$comments',
            1, 
            CURRENT_TIMESTAMP,
            '" . $row['timestamp'] . "'
        )";

        if ($conn->query($insertRegistrarLogsSql) === true) {
            // Insert the data into the queue_logs table
            $insertQueueLogsSql = "INSERT INTO queue_logs (student_id, queue_number, office, timestamp, status, remarks, endorsed) VALUES (
                '" . $row['student_id'] . "','" . $row['queue_number'] . "', 'REGISTRAR', CURRENT_TIMESTAMP, 1, '$comments', 'COMPLETED')";

            if ($conn->query($insertQueueLogsSql) === true) {
                // Delete the record from the registrar table
                $deleteSql = "DELETE FROM registrar WHERE queue_number = '$queueNumber'";
                if ($conn->query($deleteSql) === true) {
                    // Update the status in the display table
                    $updateDisplaySql = "UPDATE display SET status = 1 WHERE queue_number = '$queueNumber' AND officeName = 'REGISTRAR'";
                    $conn->query($updateDisplaySql);

                    // Set the notification message
                    $_SESSION['notification_message'] = "Transaction Completed for Queue Number: $queueNumber";
                    echo json_encode(array('success' => true));
                } else {
                    echo json_encode(array('success' => false, 'message' => "Error deleting record from registrar table: " . $conn->error));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => "Error inserting record into queue_logs table: " . $conn->error));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Error inserting record into registrar_logs table: " . $conn->error));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => "Record not found in registrar table for queue number: $queueNumber"));
    }
} else {
    echo json_encode(array('success' => false, 'message' => "Invalid request method."));
}

$conn->close();
?>
