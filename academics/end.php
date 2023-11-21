<?php
session_start();

include("db_connection.php");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the AJAX request
    $queueNumber = $_POST["queueNumber"];
    $queueTime = $_POST["queueTime"];
    $studentInfo = $_POST["studentInfo"];
    $transaction = $_POST["transactionInfo"];
    $endorsedFrom = $_POST["endorsementInfo"];

    // Perform the SQL query to update the database
    $sql = "INSERT INTO academics_logs (queue_number, student_id, endorsed_from, timestamp, timeout,transaction)
        VALUES ('$queueNumber', '$studentInfo', '$endorsedFrom', '$queueTime' , NOW(),'$transaction')";
    $sql2 = "DELETE FROM academics_queue WHERE queue_number = '$queueNumber'";
    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();

?>
