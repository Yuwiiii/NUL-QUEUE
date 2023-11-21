<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "queuing_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle form submission and update user data
  $ID = $_POST['ID'];
  $full_name = $_POST['full_name'];
  $office = $_POST['office'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  $checkSql = "SELECT * FROM user_accounts WHERE full_name = '$full_name' OR username = '$username'";
  $checkResult = $conn->query($checkSql);

  if ($checkResult->num_rows == 0) {
    $updateSql = "UPDATE user_accounts SET full_name = '$full_name', office = '$office', username = '$username', password = '$password' WHERE ID = '$ID'";

    if ($conn->query($updateSql) === TRUE) {
      echo '<script>alert("User updated successfully!");</script>';
      echo '<script>window.location.href = "users.php";</script>';
      exit();
    } else {
      echo "Error: " . $updateSql . "<br>" . $conn->error;
    }
  } else {
    echo '<script>alert("A user with the same name or username already exists.");</script>';
    echo '<script>window.location.href = "users.php";</script>';
    exit();
  }
} else {
  // Fetch user data based on userId
  $ID= $_GET['ID'];
  $fetchSql = "SELECT * FROM user_accounts WHERE ID = '$ID'";
  $fetchResult = $conn->query($fetchSql);
  $user = $fetchResult->fetch_assoc();

  // Prepare user data for JSON response
  $userData = array(
    'full_name' => $user['full_name'],
    'office' => $user['office'],
    'username' => $user['username'],
    'password' => $user['password']
  );

  // Encode user data as JSON and echo it
  echo json_encode($userData);
}

$conn->close();
?>
