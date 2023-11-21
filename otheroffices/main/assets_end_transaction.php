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

    // Retrieve data from the registrar table based on the queue number
    $fetchDataSql = "SELECT * FROM assets WHERE queue_number = '$queueNumber'";
    $result = $conn->query($fetchDataSql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Insert the data into the registrar_done table
        $insertSql = "INSERT INTO assets_logs ( queue_number, student_id, endorsed_from, transaction, remarks, status, timeout, timestamp) VALUES (
            '" . $row['queue_number'] . "',
            '" . $row['student_id'] . "',
            '" . $row['endorsed_from'] . "',
            '" . $row['transaction'] . "',
            '" . $row['remarks'] . "',
            1, 
            CURRENT_TIMESTAMP,
            '" . $row['timestamp'] . "'
        )";

        if ($conn->query($insertSql) === true) {
            // Delete the record from the registrar table
            $deleteSql = "DELETE FROM assets WHERE queue_number = '$queueNumber'";
            if ($conn->query($deleteSql) === true) {
                // Set the notification message
                $_SESSION['notification_message'] = "Transaction Completed for Queue Number: $queueNumber";
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => "Error deleting record from registrar table: " . $conn->error));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => "Error inserting record into registrar_done table: " . $conn->error));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => "Record not found in registrar table for queue number: $queueNumber"));
    }
} else {
    echo json_encode(array('success' => false, 'message' => "Invalid request method."));
}

$conn->close();
?>
