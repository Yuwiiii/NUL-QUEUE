<?php
session_start();
include("db_connection.php");

if (isset($_POST['program'])) {
    $program = $_POST['program'];
    $full_name = $_SESSION['full_name'];

    $sql = "SELECT * FROM academics_queue WHERE program = '$program' AND concern = '$full_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div id="tn-list">'; // Start the container for queue number buttons

        while ($row = $result->fetch_assoc()) {
            echo '<div class="kahitano-div">';
            echo '<button class="data-button queue-button" onclick="fetchInfo(\'' . $row['queue_number'] . '\')">' . $row['queue_number'] . '</button>';
        }

        echo '</div>'; // Close the container for queue number buttons
    } else {
        echo 'No queuing number for this person.';
    }

    $conn->close();
} else {
    echo 'Program not specified.';
}
?>
