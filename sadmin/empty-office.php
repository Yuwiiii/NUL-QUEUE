<?php

@include '../database.php';

header('Content-Type: application/json');

$getOfficeNamesSql = "SELECT officeName FROM offices";
$result = $conn->query($getOfficeNamesSql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $officeName = $row['officeName'];

        // Check if the table name is "academics_queue"
        if ($officeName === 'academics') {
            $insertLogsSql = "INSERT INTO academics_queue (student_id, queue_number, timestamp, status)
                              SELECT student_id, queue_number, timestamp, status FROM academics;";
        } else {
            $insertLogsSql = "INSERT INTO " . $officeName . "_logs (student_id, queue_number, timestamp, status)
                              SELECT student_id, queue_number, timestamp, status FROM " . $officeName . ";";
        }

        $insertLogsResult = $conn->query($insertLogsSql);

        if ($insertLogsResult) {
            $truncateSql = "TRUNCATE TABLE " . $officeName;
            $truncateResult = $conn->query($truncateSql);

            if (!$truncateResult) {
                echo json_encode(['success' => false, 'error' => 'Error truncating ' . $officeName . ' table: ' . $conn->error]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Error inserting data into ' . $officeName . '_logs table: ' . $conn->error]);
            exit;
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error fetching office names: ' . $conn->error]);
}

$conn->close();

// @include '../database.php';

// header('Content-Type: application/json');

// $getOfficeNamesSql = "SELECT officeName FROM offices";
// $result = $conn->query($getOfficeNamesSql);

// if ($result) {
//     while ($row = $result->fetch_assoc()) {
//         $officeName = $row['officeName'];

//         $insertLogsSql = "INSERT INTO " . $officeName . "_logs (student_id, queue_number, timestamp, status)
//                           SELECT student_id, queue_number, timestamp, status FROM " . $officeName . ";";
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

// $conn->close();
?>
