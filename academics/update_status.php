<<<<<<< HEAD

<?php
session_start(); // Start the session if it hasn't already been started

if (isset($_SESSION["username"])) {
    // Get the selected status from the POST data
    $selectedStatus = $_POST["status"];
    
    include 'db_connection.php';

    // Get the username of the currently logged-in user from the session
    $username = $_SESSION["username"];
    $full_name = $_SESSION["full_name"];
    // SQL query to update the user's status based on their username
    $sql = "UPDATE user_accounts SET status = '$selectedStatus' WHERE username = '$username'";
    $sql1 = "UPDATE program_chairs SET status = '$selectedStatus' WHERE full_name = '$full_name'";
    if ($conn->query($sql) === TRUE && $conn->query($sql1) === TRUE) {
        // Status updated successfully
        echo "success";
    } else {
        // Status update failed
        echo "error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request or user not logged in
    echo "Invalid request";
}


=======

<?php
session_start(); // Start the session if it hasn't already been started

if (isset($_SESSION["username"])) {
    // Get the selected status from the POST data
    $selectedStatus = $_POST["status"];
    
    include 'db_connection.php';

    // Get the username of the currently logged-in user from the session
    $username = $_SESSION["username"];
    $full_name = $_SESSION["full_name"];
    // SQL query to update the user's status based on their username
    $sql = "UPDATE user_accounts SET status = '$selectedStatus' WHERE username = '$username'";
    $sql1 = "UPDATE program_chairs SET status = '$selectedStatus' WHERE full_name = '$full_name'";
    if ($conn->query($sql) === TRUE && $conn->query($sql1) === TRUE) {
        // Status updated successfully
        echo "success";
    } else {
        // Status update failed
        echo "error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request or user not logged in
    echo "Invalid request";
}


>>>>>>> 370c682425903fd586c09a59324ffca61c227b8b
?>