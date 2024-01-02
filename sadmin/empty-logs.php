<?php
@include '../database.php';

$success = true;
$error = '';

// para sa office tables
$getOfficeNamesSql = "SELECT officeName FROM offices";
$result = $conn->query($getOfficeNamesSql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $officeName = $row['officeName'];

        $truncateSql = "TRUNCATE TABLE " . $officeName . "_logs";
        $truncateResult = $conn->query($truncateSql);

        if (!$truncateResult) {
            $success = false;
            $error = 'Error truncating ' . $officeName . ' table: ' . $conn->error;
            break;
        }
    }
} else {
    $success = false;
    $error = 'Error fetching office names: ' . $conn->error;
}
// Commenting out the INSERT INTO queue_logs
// $sql = "INSERT INTO queue_logs (student_id, queue_number, office, timestamp, status, remarks, endorsed)
//         SELECT student_id, queue_number, office, timestamp, status, remarks, endorsed FROM queue;";

// Commented out the INSERT INTO queue_logs; keeping only the truncation part
$result = true; // Initialize result variable

if ($result) {
    $truncateSql = "TRUNCATE TABLE queue_logs";
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
