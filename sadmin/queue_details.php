<?php
include '../database.php';

if (isset($_POST['queueNumber'])) {
    $queueNumber = $_POST['queueNumber'];
    $timestamp = $_POST['timestamp'];

    // Use $queueNumber in your SQL query to fetch specific data
    $query = "SELECT queue_number, student_id, office, remarks, endorsed, timestamp
    FROM QUEUE_LOGS
    WHERE QUEUE_NUMBER = '$queueNumber' AND DATE(TIMESTAMP) = DATE('$timestamp')
    ORDER BY TIMESTAMP DESC;";
    $result = mysqli_query($conn, $query);

    // Build HTML for the modal content
    $html = '<table id="myTable" class="myTable" border="1">';
    // Add header row
    $html .= '<tr class="header fixed-header">';
    $html .= '<th>Queue Number</th>';
    $html .= '<th>Student ID</th>';
    $html .= '<th>Office</th>';
    $html .= '<th>Timestamp</th>';
    $html .= '<th>Remarks</th>';
    $html .= '<th>Endorsed From</th>';
    $html .= '</tr>';

    // Add data rows
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>';
        $html .= '<td>' . $row['queue_number'] . '</td>';
        $html .= '<td>' . $row['student_id'] . '</td>';
        $html .= '<td>' . $row['office'] . '</td>';
        $html .= '<td>' . $row['timestamp'] . '</td>';
        $html .= '<td>' . $row['remarks'] . '</td>';
        $html .= '<td>' . $row['endorsed'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    echo $html;
} else {
    echo 'Error: Queue number not provided.';
}
?>