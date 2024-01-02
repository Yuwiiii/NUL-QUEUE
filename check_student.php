<?php
@include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the student ID is set
    if (isset($_POST['studentId'])) {
        $studentId = $_POST['studentId'];

        // Check if the student ID exists in the queue table and has status 1
        $sqlCheckQueue = "SELECT * FROM queue WHERE student_id = '$studentId' AND studentstatus = 0";
        $resultCheckQueue = $conn->query($sqlCheckQueue);

        if ($resultCheckQueue->num_rows > 0) {
            // Student has an ongoing queue

            // Fetch the queue_number for the student
            $sqlFetchQueueNumber = "SELECT queue_number FROM queue WHERE student_id = '$studentId'";
            $resultFetchQueueNumber = $conn->query($sqlFetchQueueNumber);

            if ($resultFetchQueueNumber->num_rows > 0) {
                $row = $resultFetchQueueNumber->fetch_assoc();
                $queueNumber = $row['queue_number'];

                // Provide the queue_number in the response
                echo json_encode(['status' => 'error', 'message' => 'You have an ongoing queue.', 'queueNumber' => $queueNumber]);
                exit;
            } else {
                // Handle the case where the queue_number couldn't be fetched
                echo json_encode(['status' => 'error', 'message' => 'Error fetching queue_number.']);
                exit;
            }
        }
    }
}
?>
