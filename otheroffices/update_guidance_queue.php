<?php
session_start();

// Include database connection logic (use your existing connection logic)
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch updated data from the registrar table
$query = "SELECT * FROM guidance WHERE status = 0 ORDER BY timestamp ASC LIMIT 1"; // Adjust the query as needed
$result = mysqli_query($conn, $query);

// Create an array to store the fetched data
$guidance_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $guidance_data[] = $row;
}

// Create an array to track displayed windows
$displayed_windows = [];

// Generate HTML content for registrar queue
$htmlContent = '';
if (!empty($guidance_data)) {
    foreach ($guidance_data as $queue_item) {
        // Check if the window is not null and has not been displayed before
        if ($queue_item['window'] !== null && !in_array($queue_item['window'], $displayed_windows)) {
            $htmlContent .= '<div class="guidance-queue">';
            $htmlContent .= '<h2>' . $queue_item['queue_number'] . '</h2>';
            $htmlContent .= '<h2>' . $queue_item['window'] . '</h2>';
            $htmlContent .= '</div>';

            // Add the displayed window to the array
            $displayed_windows[] = $queue_item['window'];
        }
    }
} else {
    // Display default values when the queue is empty
    // Modify this part based on your requirement
}

// Return the HTML content
echo $htmlContent;

// Close the database connection
$conn->close();
?>
