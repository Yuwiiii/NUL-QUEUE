<?php
session_start();

include("db_connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the AJAX request
    $queueNumber = $_POST["queueNumber"];
    $studentInfo = $_POST["studentInfo"];
    $transaction = $_POST["transactionInfo"];
    $endorsedFrom = $_POST["endorsementInfo"];
    $remarks = $_POST["remarks"];
    $academicsStr = "Academics";

    $endorsedFromStr = strtoupper($endorsedFrom);

    // Perform the SQL queries to update the database
    $sql = "INSERT INTO academics_logs (queue_number, student_id, endorsed_from, endorsed_to, timestamp, timeout, remarks, transaction, status)
        VALUES ('$queueNumber', '$studentInfo', '$endorsedFromStr', '$academicsStr', '$queueTime' , NOW(), '$remarks', '$transaction','1')";

    $sql3 = "INSERT INTO queue_logs (queue_number, student_id, endorsed, office,  remarks)
    VALUES ('$queueNumber', '$studentInfo', 'Completed', '$academicsStr',  '$remarks')";

    $sql2 = "DELETE FROM academics_queue WHERE queue_number = '$queueNumber'";

    // Update the "academics" table
    $sql4 = "UPDATE academics SET status = 1 WHERE queue_number = '$queueNumber'";

    // Update the "queue" table
    $sql5 = "UPDATE queue SET studentstatus = 1, status = 1 WHERE queue_number = '$queueNumber'";

    // Use a transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Execute the SQL queries
        $conn->query($sql);
        $conn->query($sql2);
        $conn->query($sql3);
        $conn->query($sql4);
        $conn->query($sql5);

        // Commit the transaction if all queries are successful
        $conn->commit();
        echo "Record updated successfully";
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $conn->rollback();
        echo "Error updating record: " . $e->getMessage();
    }
}

$conn->close();
?>
