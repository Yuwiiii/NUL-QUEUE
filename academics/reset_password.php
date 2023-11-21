<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $new_password = md5($_POST["password"]); // Hash the new password with MD5

    // SQL query to update the user's hashed password
    $updatePasswordSql = "UPDATE user_accounts SET password = '$new_password' WHERE username = '$username'";

    if ($conn->query($updatePasswordSql) === TRUE) {
        echo "success";
    } else {
        echo "failure";
    }
}

$conn->close();
?>
