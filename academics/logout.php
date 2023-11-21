<?php
session_start(); // Start the session if it's not already started

// Include the database connection file
include("db_connection.php");

// Check if the user is logged in
if (isset($_SESSION['username']) && isset($_SESSION['full_name'])) {
    // Get the username from the session
    $username = $_SESSION['username'];
    $full_name = $_SESSION['full_name'];
    
    // Unset and destroy the session variables
    session_unset();
    session_destroy();

    // Update the user status to 'offline' in the 'academics_accounts' table
    $sql1 = "UPDATE user_accounts SET status = 'offline' WHERE username = '$username'";
    
    // Update the user status to 'offline' in the 'program_chairs' table
    $sql2 = "UPDATE program_chairs SET status = 'offline' WHERE full_name = '$full_name'";
    
    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        echo "success"; // Send a success message
    } else {
        echo "error"; // Send an error message
    }
} else {
    echo "error"; // Send an error message
}

// Close the database connection
$conn->close();
?>