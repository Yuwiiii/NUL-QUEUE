<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $hashed_password = md5($password);
    // SQL query to check if the provided credentials exist in the database
    $sql = "SELECT * FROM user_accounts WHERE BINARY username = '$username' AND password = '$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        $row = $result->fetch_assoc();
        $_SESSION["full_name"] = $row["full_name"];
        $_SESSION["office"] = $row["office"];
        $_SESSION["username"] = $row["username"];

        $fullname = $_SESSION["full_name"];
        // Update the status column to 'available'
        $updateStatusSql = "UPDATE user_accounts SET status = 'available' WHERE username = '$username' AND password = '$hashed_password'";
        $updateStatusSql2 = "UPDATE program_chairs SET status = 'available' WHERE full_name='$fullname'";
        if ($conn->query($updateStatusSql) === TRUE && $conn->query($updateStatusSql2) === TRUE) {
            echo "success"; // Login and status update successful
        } else {
            echo "failure"; // Status update failed
        }
    } else {
        // Login failed
        echo "failure";
    }
}

$conn->close();
?>