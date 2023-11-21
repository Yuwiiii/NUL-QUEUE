<?php
@include '../database.php';
session_start();

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Perform the deletion
    $query = "DELETE FROM user_accounts WHERE ID = $userId";
    if (mysqli_query($conn, $query)) {
        // Return a success response if the deletion was successful
        echo "User deleted successfully";
    } else {
        // Return an error response if there was an issue with the deletion
        echo "Error deleting user";
    }
}
?>
