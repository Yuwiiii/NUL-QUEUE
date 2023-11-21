<?php
@include '../database.php';
session_start();

if (isset($_POST['collegeId'])) {
    $collegeId = $_POST['collegeId'];

    // Perform the deletion
    $query = "DELETE FROM colleges WHERE ID = $collegeId";
    if (mysqli_query($conn, $query)) {
        // Return a success response if the deletion was successful
        echo "College deleted successfully";
    } else {
        // Return an error response if there was an issue with the deletion
        echo "Error deleting college";
    }
}
?>
