<?php
@include '../database.php';
// session_start();

// FOR DELETING TABLE OF OFFICE IN DB
if (isset($_POST['officeId'])) {
    $officeId = $_POST['officeId'];

    // Fetch the officeName for the given officeId
    $officeQuery = "SELECT officeName FROM offices WHERE ID = $officeId";
    $officeResult = mysqli_query($conn, $officeQuery);

    if ($officeResult) {
        $officeRow = mysqli_fetch_assoc($officeResult);
        $officeName = $officeRow['officeName'];

        // Perform the deletion of the row
        $deleteRowQuery = "DELETE FROM offices WHERE ID = $officeId";
        $deleteRowResult = mysqli_query($conn, $deleteRowQuery);

        // Perform the deletion of the table
        $deleteTableQuery = "DROP TABLE IF EXISTS `$officeName`, `$officeName" . "_logs`";
        $deleteTableResult = mysqli_query($conn, $deleteTableQuery);

        if ($deleteRowResult && $deleteTableResult) {
            // Return a success response if both deletions were successful
            echo "Office and related tables deleted successfully";
        } else {
            // Return an error response if there was an issue with any deletion
            echo "Error deleting office or related tables";
        }
    } else {
        // Return an error response if fetching officeName fails
        echo "Error fetching officeName";
    }
}

// FOR DELETING OFFICE IN THE OFFICES TABLE
if (isset($_POST['officeId'])) {
    $officeId = $_POST['officeId'];

    // Perform the deletion
    $query = "DELETE FROM offices WHERE ID = $officeId";
    if (mysqli_query($conn, $query)) {
        // Return a success response if the deletion was successful
        echo "Office deleted successfully";
    } else {
        // Return an error response if there was an issue with the deletion
        echo "Error deleting Office";
    }
}
?>
