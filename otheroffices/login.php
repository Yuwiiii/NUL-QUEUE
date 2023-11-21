<?php
session_start(); // Start a session to store user information

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get user input from the form
  $username = $_POST["username"];
  $password = $_POST["password"];
  $office = $_POST["office"];

  // Connect to the database (replace with your database credentials)
  $servername = "localhost";
  $username_db = "root";
  $password_db = "";
  $dbname = "queuing_system";

  $conn = new mysqli($servername, $username_db, $password_db, $dbname);

  // Check for database connection errors
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare a SQL query to check if the user exists in the database
  $sql = "SELECT * FROM user_accounts WHERE username = ? AND password = ? AND office = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $username, $password, $office);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if a matching record is found
  if ($result->num_rows === 1) {
    // User authentication successful
    $row = $result->fetch_assoc();
    $_SESSION["user_name"] = $row["full_name"];
    $_SESSION["office"] = $row["office"];
    $_SESSION["window"] = $row["window"];


    // Redirect the user to the appropriate admin page depending on the office selected
    if ($office === "CLINIC") {
      header("Location: main/clinic_admin.php");
    } else if ($office === "ITSO") {
      header("Location: main/itso_admin.php");
    } else if ($office === "ASSETS") {
      header("Location: main/assets_admin.php");
    } else if ($office === "GUIDANCE") {
      header("Location: main/guidance_admin.php");
    }
  } else {
    // User authentication failed
    // Log the error
    $error_message = "Login failed for user $username. Wrong credentials.";
    error_log($error_message); // This will log the error message to the system error log file.

    // Display an error message to the user
    $_SESSION["login_error"] = "Incorrect credentials. Please try again.";
    header("Location: admin_login.php");
    exit(); // Make sure to exit after redirection
  }

  // Close the database connection
  $conn->close();
}
?>
