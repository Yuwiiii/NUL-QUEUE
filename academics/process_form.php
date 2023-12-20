<?php

include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST["student_id"];
    $office = $_POST["office"];
    $transaction = $_POST["transaction"];
    $remarks = $_POST["remarks"];
    $timenow = $_POST["form-queue-timestamp"];
    $queuenumbercolumn = $_POST["form-queue-number"];
    $endorse = "Academics";
    $endorsedFrom = $_POST["form-queue-endoresedfrom"];

    if ($office === "select" || $transaction === "select") {
        echo "Please select both 'Endorsed To' and 'Transaction' options.";
    } else {
        $table = strtolower($office); // Convert office name to lowercase for the table name
        $academicsStr = strtoupper($endorse);
        $OfficeStr = strtoupper($office);
        $endorsedFromStr = strtoupper($endorsedFrom);

        // Prepare the SQL statement to insert the data into the appropriate table
        $sql = "INSERT INTO $table (queue_number, student_id, timestamp, remarks, transaction,endorsed_from, status)
                VALUES ('$queuenumbercolumn', '$studentId', NOW(), '$remarks','$transaction', '$academicsStr', '0')";

        $sql2 = "INSERT INTO academics_logs (queue_number, student_id, endorsed_from, endorsed_to, timestamp, timeout, transaction,  remarks)
        VALUES ('$queuenumbercolumn', '$studentId', '$endorsedFromStr', '$OfficeStr', '$timenow' , NOW(),'$transaction', '$remarks')";

        $sql3 = "INSERT INTO queue_logs (queue_number, student_id, endorsed, office, timestamp, remarks)
        VALUES ('$queuenumbercolumn', '$studentId', '$OfficeStr', '$academicsStr', '$timenow', '$remarks')";

        $sql4 = "DELETE FROM academics_queue WHERE queue_number = '$queuenumbercolumn'";

        if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
