<?php
session_start();
$queueNumber = $_POST['queueNumber'];
$windowNumber = $_POST['windowNumber'];

// Validate $queueNumber and $windowNumber

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the guidance table with the new window number
$updateQuery = "UPDATE guidance SET window = '$windowNumber' WHERE queue_number = '$queueNumber'";
$result = $conn->query($updateQuery);

// Fetch the current window number
$currentWindowQuery = "SELECT window FROM guidance WHERE queue_number = '$queueNumber'";
$currentWindowResult = $conn->query($currentWindowQuery);

if ($currentWindowResult) {
    if ($currentWindowResult->num_rows > 0) {
        $row = $currentWindowResult->fetch_assoc();
        $currentWindow = $row['window'];

        // Log the fetched window number
        echo "Fetched Window: " . $currentWindow;

        // Insert or update the display table
        $updateDisplayQuery = "INSERT INTO display (queue_number, window, officeName) VALUES ('$queueNumber', '$currentWindow', 'Guidance')
                               ON DUPLICATE KEY UPDATE window = '$currentWindow'";
        $resultDisplay = $conn->query($updateDisplayQuery);

        if ($resultDisplay) {
            echo "Display table updated successfully";
        } else {
            echo "Error updating display table: " . $conn->error;
        }
    } else {
        echo "No rows found for the specified queue number.";
    }
} else {
    echo "Error fetching window: " . $conn->error;
}



if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update window']);
}

$conn->close();
?>
