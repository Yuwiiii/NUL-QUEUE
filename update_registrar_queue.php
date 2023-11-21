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

// Fetch updated data from the registrar table, excluding entries with window number 0
$query = "SELECT * FROM registrar WHERE status = 0 AND window <> 0 ORDER BY window, timestamp ASC LIMIT 6"; // Adjust the query as needed
$result = mysqli_query($conn, $query);

// Create an array to store the fetched data
$registrar_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $registrar_data[] = $row;
}

// Create an array to track displayed windows
$displayed_windows = [];

// Generate HTML content for registrar queue
$htmlContent = '';
if (!empty($registrar_data)) {
    foreach ($registrar_data as $queue_item) {
        if (!in_array($queue_item['window'], $displayed_windows)) {
            $htmlContent .= '<div class="registrar-queue">';
            $htmlContent .= '<h2>Window ' . $queue_item['window'] . ':</h2>';
            $htmlContent .= '<h2>' . $queue_item['queue_number'] . '</h2>';
          
            
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
