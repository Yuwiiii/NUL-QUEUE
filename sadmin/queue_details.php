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
    $html .= '<th>' . ucfirst('Queue Number') . '</th>';
    $html .= '<th>' . ucfirst('Student ID') . '</th>';
    $html .= '<th>' . ucfirst('Office') . '</th>';
    $html .= '<th>' . ucfirst('Timestamp') . '</th>';
    $html .= '<th>' . ucfirst('Remarks') . '</th>';
    $html .= '<th>' . ucfirst('Endorsed To') . '</th>';
    $html .= '</tr>';

    // Add data rows
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>';
        $html .= '<td>' . $row['queue_number'] . '</td>';
        $html .= '<td>' . ucfirst(strtolower($row['student_id'])) . '</td>';
        $html .= '<td>' . ucfirst(strtolower($row['office'])) . '</td>';
        $html .= '<td>' . ucfirst(strtolower($row['timestamp'])) . '</td>';
        $html .= '<td>' . ucfirst(strtolower($row['remarks'])) . '</td>';
        $html .= '<td>' . ucfirst(strtolower($row['endorsed'])) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    echo $html;
} else {
    echo 'Error: Queue number not provided.';
}
?>
