<?php
// Fetch the currently logged-in username using your authentication mechanism
// For example, if you are using sessions:
session_start();
$currentUsername = $_SESSION['username']; // Replace with your actual session variable

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform the database query
$sqlFetchWindow = "SELECT window FROM user_accounts WHERE username = '$currentUsername'";
$resultWindow = $conn->query($sqlFetchWindow);

// Check for errors and send the result back to the client
if ($resultWindow) {
    if ($resultWindow->num_rows > 0) {
        $rowWindow = $resultWindow->fetch_assoc();
        $userWindow = isset($rowWindow['window']) ? $rowWindow['window'] : null;

        // Output the fetched window value
        echo $userWindow;
    } else {
        echo "No rows found for the current user.";
    }
} else {
    echo "Error fetching window: " . $conn->error;
}

// Close the connection
$conn->close();
?>