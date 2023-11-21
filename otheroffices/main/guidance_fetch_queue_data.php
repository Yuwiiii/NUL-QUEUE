<?php
// Connect to the database (modify the connection details)
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['queueNumber'])) {
    $queueNumber = $_GET['queueNumber'];

    // Query the database to fetch data for the selected queue number, including "Endorsed_From"
    $sql = "SELECT queue_number, timestamp, student_id, transaction, remarks, endorsed_from FROM guidance WHERE queue_number = '$queueNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Return the data as JSON
        echo json_encode($row);
    } else {
        // No data found for the selected queue number
        echo json_encode(array());
    }
} else {
    // Queue number not provided
    echo json_encode(array());
}


$conn->close();
?>
