<?php
// Assuming you have a database connection
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the notify button is clicked
if (isset($_POST['notify_button'])) {
    // Assuming you get the queue number from somewhere, for example, a form input
    $queue_number = $_POST['queue_number'];

    // You may also need to get other values like window and Officename from the form

    // Insert data into the display table
    $sql = "INSERT INTO display (ID, queue_number, window, officeName) VALUES ('$queue_number', '$window_value', '$officeName_value')";

    if ($conn->query($sql) === TRUE) {
        echo "Queue number added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notify Button Example</title>
</head>
<body>
    <form method="post" action="">
        <!-- Add other form fields for window, Officename, etc. -->
        <label for="queue_number">Queue Number:</label>
        <input type="text" name="queue_number" id="queue_number" required>

        <button type="submit" name="notify_button">Notify</button>
    </form>
</body>
</html>
