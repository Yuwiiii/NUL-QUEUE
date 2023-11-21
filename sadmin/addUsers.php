<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$full_name = $_POST['full_name'];
$office = $_POST['office'];
$window = $_POST['selectWindow'];
$username = $_POST['username'];
$password = $_POST['password'];


// Check if a record with the same full_name or username already exists
$checkSql = "SELECT * FROM user_accounts WHERE full_name = '$full_name' OR username = '$username'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows == 0) {
    // No record with the same full_name or username exists, proceed with the insert
    $insertSql = "INSERT INTO user_accounts (full_name, office, window, username, password) 
        VALUES ('$full_name', '$office', '$window', '$username', '$password')";

    if ($conn->query($insertSql) === TRUE) {
        echo '<script>alert("User added successfully!");</script>';
        echo '<script>window.location.href = "users.php";</script>';
        exit();
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
} else {
    // A record with the same full_name or username already exists
    echo '<script>alert("A user with the same name or username already exists.");</script>';
    echo '<script>window.location.href = "users.php";</script>';
    exit();
}

$conn->close();
?>
