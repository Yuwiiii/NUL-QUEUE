<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

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
    $sql = "SELECT * FROM user_accounts WHERE username = ? AND password = ? AND office = 'REGISTRAR'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User authentication successful
        $row = $result->fetch_assoc();
        if (isset($row["ID"])) {
            $_SESSION["user_id"] = $row["ID"];
            $_SESSION["user_name"] = $row["full_name"];
            $_SESSION["window"] = $row["window"]; // Store window information in the session

            header("Location: main/registrar_admin.php"); // Redirect to the admin page
            exit(); // Make sure to exit after redirection
        }
    } else {
        // User authentication failed
        $_SESSION["login_error"] = "Login Failed. Wrong Credentials ";
        header("Location: admin_login.php");
        exit(); // Make sure to exit after redirection
    }

    // Close the database connection
    $conn->close();
}
?>
