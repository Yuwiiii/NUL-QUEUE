<?php
session_start();

include("db_connection.php");

if (isset($_SESSION['full_name']) && isset($_SESSION['office'])) {
    $office = $_SESSION['office'];
    $full_name = $_SESSION['full_name'];
    if (isset($_GET['program'])) {
        $selectedProgram = $_GET['program'];
        $selectedConcern = isset($_GET['concern']) ? $_GET['concern'] : '';

        $sql = "SELECT * FROM academics_queue WHERE program = '$selectedProgram'";

        if (!empty($selectedConcern)) {
            $sql .= " AND concern = '$selectedConcern'";
        }

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
            $sql = "SELECT * FROM academics_queue WHERE program = '$office' AND concern = '$full_name' ORDER BY timestamp ASC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div id="tn-list">'; // Start the container for queue number buttons
        
                while ($row = $result->fetch_assoc()) {
                   
                    echo '<div class="kahitano-div">';
                    // Call the fetchInfo function and set the queue_number in session
                    echo '<button class="data-button queue-button" onclick="fetchInfo(\'' . $row['queue_number'] . '\')">' . $row['queue_number'] . '</button>';
                    
                }
        
                echo '</div>'; // Close the container for queue number buttons
                
            } else {
                echo '<b><i>No queuing number for this person.</i></b>';
            }
        }
    } else {
        echo 'Program not set in the request.';
    }

    $conn->close();
} else {
    echo 'User not logged in or office not set in the session.';
}
?>
