<?php
@include '../database.php';

header('Content-Type: application/json');

$success = true;
$error = '';

// para sa office tables
$getOfficeNamesSql = "SELECT officeName FROM offices";
$result = $conn->query($getOfficeNamesSql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $officeName = $row['officeName'];

        $insertLogsSql = "INSERT INTO " . $officeName . "_logs (student_id, queue_number, timestamp, remarks, status)
                          SELECT student_id, queue_number, timestamp, remarks, status FROM " . $officeName . ";";

        $insertLogsResult = $conn->query($insertLogsSql);

        if ($insertLogsResult) {
            $truncateSql = "TRUNCATE TABLE " . $officeName;
            $truncateResult = $conn->query($truncateSql);

            if (!$truncateResult) {
                $success = false;
                $error = 'Error truncating ' . $officeName . ' table: ' . $conn->error;
                break;
            }
        } else {
            $success = false;
            $error = 'Error inserting data into ' . $officeName . '_logs table: ' . $conn->error;
            break;
        }
    }
} else {
    $success = false;
    $error = 'Error fetching office names: ' . $conn->error;
}

// para sa academics_queue
$academicsQueueTableName = "academics_queue";


$insertLogsResult = $conn->query($insertLogsSql);

if ($insertLogsResult) {
    $truncateSql = "TRUNCATE TABLE $academicsQueueTableName";
    $truncateResult = $conn->query($truncateSql);

    if (!$truncateResult) {
        $success = false;
        $error = 'Error truncating ' . $academicsQueueTableName . ' table: ' . $conn->error;
    }
} else {
    $success = false;
    $error = 'Error inserting data into academics_logs table: ' . $conn->error;
}

echo json_encode(['success' => $success, 'error' => $error]);

$conn->close();
// @include '../database.php';

// header('Content-Type: application/json');

// $getOfficeNamesSql = "SELECT officeName FROM offices";
// $result = $conn->query($getOfficeNamesSql);

// if ($result) {
//     while ($row = $result->fetch_assoc()) {
//         $officeName = $row['officeName'];

//         $insertLogsSql = "INSERT INTO " . $officeName . "_logs (student_id, queue_number, timestamp, remarks, status)
//                           SELECT student_id, queue_number, timestamp, remarks, status FROM " . $officeName . ";";
//         // $insertLogsSql = "INSERT INTO " . $officeName . "_logs (" . implode(", ", $columns) . ")
//         // SELECT " . implode(", ", $columns) . " FROM " . $officeName;

//         $insertLogsResult = $conn->query($insertLogsSql);

//         if ($insertLogsResult) {
//             $truncateSql = "TRUNCATE TABLE " . $officeName;
//             $truncateResult = $conn->query($truncateSql);

//             if (!$truncateResult) {
//                 echo json_encode(['success' => false, 'error' => 'Error truncating ' . $officeName . ' table: ' . $conn->error]);
//                 exit;
//             }
//         } else {
//             echo json_encode(['success' => false, 'error' => 'Error inserting data into ' . $officeName . '_logs table: ' . $conn->error]);
//             exit;
//         }
//     }

//     echo json_encode(['success' => true]);
// } else {
//     echo json_encode(['success' => false, 'error' => 'Error fetching office names: ' . $conn->error]);
// }

// //academics_queue
// $academicsQueueTableName = "academics_queue";

// $insertLogsSql = "INSERT INTO academics_logs (student_id, queue_number, timestamp, remarks, status)
//                   SELECT student_id, queue_number, timestamp, remarks, status FROM $academicsQueueTableName;";
// $insertLogsResult = $conn->query($insertLogsSql);

// if ($insertLogsResult) {
//     $truncateSql = "TRUNCATE TABLE $academicsQueueTableName";
//     $truncateResult = $conn->query($truncateSql);

//     if ($truncateResult) {
//         echo json_encode(['success' => true]);
//     } else {
//         echo json_encode(['success' => false, 'error' => 'Error truncating ' . $academicsQueueTableName . ' table: ' . $conn->error]);
//     }
// } else {
//     echo json_encode(['success' => false, 'error' => 'Error inserting data into academics_logs table: ' . $conn->error]);
// }
// $conn->close();
?>
