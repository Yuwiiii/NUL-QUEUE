<?php
@include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['office'])) {
    $office = $_POST['office'];

    $officeLimits = [
        'ACCOUNTING' => 3,
        'REGISTRAR' => 3,
        // Add other offices as needed
    ];

    $limit = $officeLimits[$office] ?? 1;

    // Check if the number of rows in the display table exceeds 50
    $checkRowCountSql = "SELECT COUNT(*) as rowCount FROM display WHERE officeName = '$office'";
    $rowCountResult = $conn->query($checkRowCountSql);
    $rowCount = $rowCountResult->fetch_assoc()['rowCount'];

    if ($rowCount >= 50) {
        // Truncate the display table
        $truncateTableSql = "TRUNCATE TABLE display";
        $conn->query($truncateTableSql);
    }

    $officeDataSql = "SELECT * FROM display WHERE officeName = '$office' AND status = 0 ORDER BY 'window', id DESC";
    $officeDataResult = $conn->query($officeDataSql);

    echo '<div data-office="' . $office . ' class="' . $office . '-queue-container">';
    $queues = [];
    $currentWindows = [];

    if ($officeDataResult->num_rows > 0) {
        while ($officeRow = $officeDataResult->fetch_assoc()) {
            $window = $officeRow["window"];
            $queueNumber = $officeRow["queue_number"];
            $status = $officeRow["status"];

            // Display only the latest queue for each window
            if (!in_array($window, $currentWindows)) {
                $queues[] = '<div class="' . $office . '-queue queue"><h2 class="queue-text" data-queue-number="' . $queueNumber .'">Window ' . $window . ': ' . $queueNumber . '</h2></div>';
                $currentWindows[] = $window;

                if ($status == 0) {
                    $updateQueueStatusSql = "UPDATE queue SET status = 1 WHERE office = '$office' AND queue_number = '$queueNumber'";
                    $conn->query($updateQueueStatusSql);
                }

                // Delete the displayed queue_number from the queue table if status is 1 in the display table
                if ($status == 1) {
                    // Move the displayed queue_number to the queue_logs table
                    $insertLogSql = "INSERT INTO queue_logs (office, queue_number) VALUES ('$office', '$queueNumber')";
                    $conn->query($insertLogSql);
                    $deleteQueueSql = "DELETE FROM queue WHERE office = '$office' AND queue_number = '$queueNumber'";
                    $conn->query($deleteQueueSql);
                }


            }

            // Break the loop if the desired limit is reached
            if (count($queues) >= $limit) {
                break;
            }
        }

        // Display the queues in reverse order
        echo implode("", ($queues));
    } else {
        // Display an empty queue container if no data is found for the current office
        echo '<div class="' . $office . '-queue queue"><h2 class="queue-text">-</h2></div>';
    }

    echo '</div>'; // Close queue container
} else {
    echo "Invalid request";
}

$conn->close();
?>