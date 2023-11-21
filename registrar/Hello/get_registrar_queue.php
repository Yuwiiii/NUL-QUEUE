<?php
// Establish a database connection (similar to registrar_admin.php)
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the registrar table
$sql = "SELECT window, queue_number FROM registrar WHERE window IS NOT NULL AND window != ''";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialize an array to store queue numbers for each window
    $windowData = array_fill_keys(['Window 1', 'Window 2', 'Window 3', 'Window 4'], 'Loading...');

    while ($row = $result->fetch_assoc()) {
        $windowData[$row['window']] = $row['queue_number'];
    }

    // Build the HTML content for the queue numbers
    $htmlContent = '';
    foreach ($windowData as $window => $queueNumber) {
        $htmlContent .= '<li class="queue-list"><p class="window">' . $window . ':</p><p class="window-q">' . $queueNumber . '</p></li>';
        $htmlContent .= '<li><p> </p></li>';
    }

    // Send the HTML content as the response
    echo $htmlContent;
} else {
    // Display placeholder if no data is available
    
}

// Close the database connection
$conn->close();
?>
