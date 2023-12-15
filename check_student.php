<?php
@include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the student ID is set
    if (isset($_POST['studentId'])) {
        $studentId = $_POST['studentId'];

        // Check if the student ID exists in the queue table and has status 1
        $sql = "SELECT * FROM queue WHERE student_id = '$studentId' AND status = 0";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Student has an ongoing queue
            echo json_encode(['status' => 'error', 'message' => 'You have an ongoing queue.']);
            exit;
        }
    }
}
?>
