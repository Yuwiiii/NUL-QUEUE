<?php
@include 'database.php';

// Fetch up to 15 most recent queue numbers from the 'queue' table
$pendingQueueSql = "SELECT * FROM queue WHERE status = 0 ORDER BY timestamp ASC LIMIT 15";
$pendingQueueResult = $conn->query($pendingQueueSql);

echo '<div class="pending-queue queue">';
    
if ($pendingQueueResult->num_rows > 0) {
    while ($pendingRow = $pendingQueueResult->fetch_assoc()) {
        $queueNumber = $pendingRow["queue_number"];
        echo '<h2>' . $queueNumber . '</h2>';
    }
} else {
    echo '<h2>No pending queue</h2>';
}

echo '</div>';

$conn->close();
?>
