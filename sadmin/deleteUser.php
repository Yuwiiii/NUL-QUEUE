<?php
@include '../database.php';
session_start();

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Use a transaction to ensure both deletions are successful or none at all
    mysqli_autocommit($conn, false);

    $success = true;

    // Perform deletion on user_accounts table
    $queryUserAccounts = "DELETE FROM user_accounts WHERE ID = $userId";

    if (!mysqli_query($conn, $queryUserAccounts)) {
        $success = false;
    }

    // Perform deletion on program_chairs table based on full_name
    $queryProgramChairs = "DELETE FROM program_chairs WHERE user_id = '$userId'";

    if (!mysqli_query($conn, $queryProgramChairs)) {
        $success = false;
    }

    if ($success) {
        // Commit the changes if both deletions were successful
        mysqli_commit($conn);
        echo "User and associated program chair deleted successfully";
    } else {
        // Rollback the changes if there was an issue with any deletion
        mysqli_rollback($conn);
        echo "Error deleting user or associated program chair";
    }

    // Restore autocommit mode
    mysqli_autocommit($conn, true);
}
?>
