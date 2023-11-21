<?php
session_start();

include("db_connection.php");

if (isset($_SESSION['full_name']) && isset($_SESSION['office'])) {
    $defaultConcern = $_SESSION['full_name'];

    // Fetch data for the default concern
    $sql = "SELECT * FROM academics_queue WHERE concern = '$defaultConcern' ORDER BY timestamp ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div id="tn-list">';

        while ($row = $result->fetch_assoc()) {
            echo '<div class="kahitano-div">';
            echo '<button class="data-button queue-button" onclick="fetchInfo(\'' . $row['queue_number'] . '\')">' . $row['queue_number'] . '</button>';
            echo '</div>';
        }

        echo '</div>';
    } else {
        echo '<b>No queuing number for this person.<b>';
    }

    $conn->close();
} else {
    echo 'User not logged in or office not set in the session.';
}
?>
