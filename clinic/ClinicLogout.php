<?php
session_start();

// Retrieve the previously selected queue number from the session
$previouslySelectedQueueNumber = isset($_SESSION['previouslySelectedQueueNumber']) ? $_SESSION['previouslySelectedQueueNumber'] : null;

// Reset the "availability" column to 0 for the previously selected queue number
if ($previouslySelectedQueueNumber !== null) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "queuing_system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlResetAvailability = "UPDATE clinic SET availability = 0 WHERE queue_number = '$previouslySelectedQueueNumber'";
    $conn->query($sqlResetAvailability);

    $conn->close();
}



// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location: ClinicLogin.php");
exit();
?>
