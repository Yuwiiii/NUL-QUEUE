<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$ID = $_POST['ID'];
$acronym = $_POST['acronym'];
$collegeName = $_POST['collegeName'];

// Check if record exists
$checkSql = "SELECT * FROM colleges WHERE ID='$ID'";
$checkResult = $conn->query($checkSql);

if ($checkResult) {
  // update 
  $insertSql = "UPDATE colleges 
                  SET acronym = '$acronym',
                      collegeName = '$collegeName'
                  WHERE ID = '$ID'";

  if ($conn->query($insertSql) === TRUE) {
    echo '<script>alert("College details updated successfully!");</script>';
    echo '<script>window.location.href = "college.php";</script>';
    exit();
  } else {
    echo "Error: " . $insertSql . "<br>" . $conn->error;
  }
}

$conn->close();
?>