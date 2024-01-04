<!-- validate_selection.php -->
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $officeSelected = $_POST["officeSelected"];

    // Store the selected office in the session
    $_SESSION['officeSelected'] = $officeSelected;

    // Redirect to the main page
    header("Location: displayqueue.php");
    exit();
} else {
    // If accessed directly without POST, redirect to login page
    header("Location: selectdisplay.php");
    exit();
}
?>
