<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queueNumber = $_POST['queue_number'];
    $timestamp = $_POST['timestamp'];
    $studentID = $_POST['student_id'];
    $endorsedFrom = $_POST['endorsed_from'];

    // Check if the key 'endorsed_to' exists in the $_POST array
    $endorsedTo = isset($_POST['endorsed_to']) ? $_POST['endorsed_to'] : 'None';
    
    $transaction = $_POST['transaction'];
    $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';

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

    // Insert data into guidance_logs table
    $sqlInsertGuidanceLogs = "INSERT INTO guidance_logs (queue_number, timestamp, student_id, endorsed_from, transaction, remarks, endorsed_to) 
            VALUES ('$queueNumber', '$timestamp', '$studentID', '$endorsedFrom', 'Payment', '$remarks', 'Completed')";

    if ($conn->query($sqlInsertGuidanceLogs) === TRUE) {
        // Insert data into queue_logs table after successful insertion into guidance_logs
        $sqlInsertQueueLogs = "INSERT INTO queue_logs (queue_number, student_id, office, remarks, endorsed) 
                               VALUES ('$queueNumber', '$studentID', 'Guidance', '$remarks', 'Completed')";

        if ($conn->query($sqlInsertQueueLogs) !== TRUE) {
            echo "Error inserting data into queue_logs: " . $conn->error;
        }

        // Update status in the guidance table
        $sqlUpdateStatus = "UPDATE guidance SET status = 1 WHERE queue_number = '$queueNumber'";
        if ($conn->query($sqlUpdateStatus) !== TRUE) {
            echo "Error updating status: " . $conn->error;
        } else {
            // Additional query to update the display table based on the queue_number and officeName condition
            $sqlUpdateDisplay = "UPDATE display SET status = 1 WHERE queue_number = '$queueNumber' AND officeName = 'Guidance'";
            if ($conn->query($sqlUpdateDisplay) !== TRUE) {
                echo "Error updating display table: " . $conn->error;
            } else {
                // Query to delete the record from the guidance table
                $sqlDeleteGuidance = "DELETE FROM guidance WHERE queue_number = '$queueNumber'";
                if ($conn->query($sqlDeleteGuidance) !== TRUE) {
                    echo "Error deleting record from guidance table: " . $conn->error;
                } else {
                    // Query to update the studentstatus column in the queue table
                    $sqlUpdateQueue = "UPDATE queue SET studentstatus = 1 WHERE queue_number = '$queueNumber'";
                    if ($conn->query($sqlUpdateQueue) !== TRUE) {
                        echo "Error updating studentstatus in the queue table: " . $conn->error;
                    }
                }
            }
        }
    } else {
        echo "Error inserting data into guidance_logs: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
