<?php
session_start();

// Include your database connection file (db_connection.php)
include("db_connection.php");

if (isset($_POST['queue_number'])) {
    $queueNumber = $_POST['queue_number'];

    // Prepare and execute a SQL query to fetch data for the specified queue_number
    $sql = "SELECT * FROM academics_queue WHERE queue_number = '$queueNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Format timestamp into a readable date and time format
        $formattedTimestamp = date("M. j, Y \a\t g:i A", strtotime($data['timestamp']));

        // Create an associative array to hold the data
        $response = array(
            'queue_number' => $data['queue_number'],
            'queue_time' => $formattedTimestamp,
            'concern' => $data['concern'],
            'remarks' => $data['remarks'],
            'endorse' => $data['endorsed_from'],
            'transaction' => $data['transaction'],
            'timestamp' => $data['timestamp'],
            'studentid' => $data['student_id']
            
            // Add more columns as needed
        );

        // Set the Content-Type header to indicate JSON response
        header('Content-Type: application/json');

        // Output the JSON response
        echo json_encode($response);
    } else {
        // Handle the case where no data is found
        $response = array('error' => 'No data found for this queue number');
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case where queue_number is not provided
    $response = array('error' => 'Queue number not provided');
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
