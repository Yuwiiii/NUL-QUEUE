<?php
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queueNumber = $_POST['queue_number'];
    $timestamp = $_POST['timestamp'];
    $studentID = $_POST['student_id'];
    $endorsedFrom = $_POST['endorsed_from'];

    // Check if the key 'endorsed_to' exists in the $_POST array
    $endorsedTo = isset($_POST['endorsed_to']) ? $_POST['endorsed_to'] : 'None';
    
    $transaction = $_POST['transaction'];
    $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';

  
    // Insert data into clinic_logs table
    $sqlInsertClinicLogs = "INSERT INTO clinic_logs (queue_number, timestamp, student_id, endorsed_from, transaction, remarks, endorsed_to) 
            VALUES ('$queueNumber', '$timestamp', '$studentID', '$endorsedFrom', 'Payment', '$remarks', 'Completed')";

    if ($conn->query($sqlInsertClinicLogs) === TRUE) {
        // Insert data into queue_logs table after successful insertion into clinic_logs
        $sqlInsertQueueLogs = "INSERT INTO queue_logs (queue_number, timestamp, student_id, office, remarks, endorsed) 
                               VALUES ('$queueNumber', '$timestamp', '$studentID', 'Clinic', '$remarks', 'Completed')";

        if ($conn->query($sqlInsertQueueLogs) !== TRUE) {
            echo "Error inserting data into queue_logs: " . $conn->error;
        }

        // Update status in the clinic table
        $sqlUpdateStatus = "UPDATE clinic SET status = 1 WHERE queue_number = '$queueNumber'";
        if ($conn->query($sqlUpdateStatus) !== TRUE) {
            echo "Error updating status: " . $conn->error;
        } else {
            // Additional query to update the display table based on the queue_number and officeName condition
            $sqlUpdateDisplay = "UPDATE display SET status = 1 WHERE queue_number = '$queueNumber' AND officeName = 'Clinic'";
            if ($conn->query($sqlUpdateDisplay) !== TRUE) {
                echo "Error updating display table: " . $conn->error;
            } else {
                // Query to delete the record from the clinic table
                $sqlDeleteClinic = "DELETE FROM clinic WHERE queue_number = '$queueNumber'";
                if ($conn->query($sqlDeleteClinic) !== TRUE) {
                    echo "Error deleting record from clinic table: " . $conn->error;
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
        echo "Error inserting data into clinic_logs: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
