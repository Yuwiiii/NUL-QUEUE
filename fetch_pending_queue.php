<?php
session_start();

if (!isset($_SESSION['officeSelected'])) {
    header("Location: displayqueue.php");
    exit();
}

@include 'database.php';

$officeSelected = $_SESSION['officeSelected'];

// Fetch up to 15 most recent queue numbers from the 'queue' table
if ($officeSelected == 'all') {
    $pendingQueueSql = "SELECT * FROM queue WHERE status = 0 ORDER BY timestamp ASC LIMIT 15";
} else {
    $pendingQueueSql = "SELECT * FROM queue WHERE status = 0 AND OFFICE = '$officeSelected' ORDER BY timestamp ASC LIMIT 15";
}

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