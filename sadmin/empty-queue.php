<?php
@include '../database.php';

// Commenting out the INSERT INTO queue_logs
// $sql = "INSERT INTO queue_logs (student_id, queue_number, office, timestamp, status, remarks, endorsed)
//         SELECT student_id, queue_number, office, timestamp, status, remarks, endorsed FROM queue;";

// Commented out the INSERT INTO queue_logs; keeping only the truncation part
$result = true; // Initialize result variable

if ($result) {
    $truncateSql = "TRUNCATE TABLE queue";
    $truncateResult = $conn->query($truncateSql);

    $truncateDisplaySql = "TRUNCATE TABLE display";
    $truncateDisplayResult = $conn->query($truncateDisplaySql);

    if ($truncateResult && $truncateDisplayResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error truncating queue table: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error inserting data into queue_logs table: ' . $conn->error]);
}

$conn->close();
?>
