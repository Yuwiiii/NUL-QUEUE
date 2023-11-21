<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$acronym = $_POST['acronym'];
$collegeName = $_POST['collegeName'];

// Check if a record with the same college already exists
$checkSql = "SELECT * FROM colleges WHERE collegeName = '$collegeName'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows == 0) {
    // No record with the same full_name or username exists, proceed with the insert
    $insertSql = "INSERT INTO colleges (acronym, collegeName) 
        VALUES ('$acronym', '$collegeName')";

    if ($conn->query($insertSql) === TRUE) {
        echo '<script>alert("Department added successfully!");</script>';
        echo '<script>window.location.href = "college.php";</script>';
        exit();
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
} else {
    // A record with the same department already exists
    echo '<script>alert("A department with the same name already exists.");</script>';
    echo '<script>window.location.href = "college.php";</script>';
    exit();
}

$conn->close();
?>
