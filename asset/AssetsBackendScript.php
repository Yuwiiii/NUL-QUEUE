<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queueNumber = $_POST['queue_number'];
    $timestamp = $_POST['timestamp'];
    $studentID = $_POST['student_id'];
    $endorsedTo = $_POST['endorsed_to'];
    $transaction = $_POST['transaction'];
    $remarks = $_POST['remarks'];

    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "queuing_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into itso_logs table
    $sqlInsertAssets = "INSERT INTO assets_logs (queue_number, timestamp, student_id, endorsed_to, transaction, remarks) 
            VALUES ('$queueNumber', '$timestamp', '$studentID', 'ASSETS', 'End Transaction', '$remarks')";
    if ($conn->query($sqlInsertAssets) === TRUE) {
        // Insert data into queue_logs table
        $sqlInsert = "INSERT INTO queue_logs (queue_number, timestamp, student_id, office, remarks, endorsed) 
            VALUES ('$queueNumber', '$timestamp', '$studentID', 'ASSETS', '$remarks', 'ASSETS')";
            if (!$conn->query($sqlInsert)) {
            echo "Error inserting into queue_logs: " . $conn->error;
        }
        // Update status in the accounting table
        $sqlUpdateStatus = "UPDATE assets SET status = 1 WHERE queue_number = '$queueNumber'";
        if ($conn->query($sqlUpdateStatus) !== TRUE) {
            echo "Error updating status: " . $conn->error;
        } else {

            // Additional query to update the display table based on the queue_number and officeName condition
            $sqlUpdateDisplay = "UPDATE display SET status = 1 WHERE queue_number = '$queueNumber' AND officeName = 'Assets'";
            if ($conn->query($sqlUpdateDisplay) !== TRUE) {
                echo "Error updating display table: " . $conn->error;
            } else {
                
            }

        
        }
    } else {
        echo "Error inserting data: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
