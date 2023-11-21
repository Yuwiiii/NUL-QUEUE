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

// Fetch updated data from the accounting table, excluding entries with window number 0
$query = "SELECT * FROM accounting WHERE window IN (1, 2, 3, 4) AND status = 0 ORDER BY window, timestamp ASC LIMIT 6"; // Adjust the query as needed
$result = mysqli_query($conn, $query);

// Create an array to store the fetched data
$accounting_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $accounting_data[] = $row;
}

// Create an array to track displayed windows
$displayed_windows = [];

// Generate HTML content for accounting queue
$htmlContent = '';
// Display "Window" text for windows 1 to 4
for ($i = 1; $i <= 4; $i++) {
    // Check if there is data in the accounting queue for the current window
    $windowData = array_filter($accounting_data, function ($item) use ($i) {
        return $item['window'] == $i;
    });

    // Only display if there is data for the current window
    if (!empty($windowData)) {
        $htmlContent .= '<div class="accounting-queue">';
        $htmlContent .= '<h2>Window ' . $i . ':</h2>';

        foreach ($windowData as $queue_item) {
            $htmlContent .= '<h2>' . $queue_item['queue_number'] . '</h2>';
        }

        $htmlContent .= '</div>';
        
        // Add the displayed window to the array
        $displayed_windows[] = $i;
    }
}

// Display a message if there is no data for any window
if (empty($accounting_data)) {
    $htmlContent .= '<div class="accounting-queue">';
    $htmlContent .= '<h2>No data available</h2>';
    $htmlContent .= '</div>';
}

// Return the HTML content
echo $htmlContent;

// Close the database connection
$conn->close();
?>
