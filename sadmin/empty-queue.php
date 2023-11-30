<?php
@include '../database.php';

$sql = "INSERT INTO queue_logs (student_id, queue_number, office, timestamp, status, remarks, endorsed)
        SELECT student_id, queue_number, office, timestamp, status, remarks, endorsed FROM queue;";

$result = $conn->query($sql);

if ($result) {
    $truncateSql = "TRUNCATE TABLE queue";
    $truncateResult = $conn->query($truncateSql);

    if ($truncateResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error truncating queue table: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error inserting data into queue_logs table: ' . $conn->error]);
}

$conn->close();
?>
