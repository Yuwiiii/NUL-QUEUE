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
$full_name = $_POST['full_name'];
$office = $_POST['office'];
$window = $_POST['selectWindow'];
$username = $_POST['username'];
$password = $_POST['password'];

// Check if record exists
$checkSql = "SELECT * FROM user_accounts WHERE ID='$ID'";
$checkResult = $conn->query($checkSql);

if ($checkResult) {
    // Check if the record exists in the program_chairs table
    $deleteProgramChairSql = "DELETE FROM program_chairs WHERE user_id='$ID'";
    
    if ($conn->query($deleteProgramChairSql) === TRUE) {
        // Update user account details
        $updateSql = "UPDATE user_accounts 
                      SET full_name = '$full_name',
                          office = '$office',
                          username = '$username',
                          window = '$window',
                          password = '$password'
                      WHERE ID = '$ID'";
                      
        if ($conn->query($updateSql) === TRUE) {
            echo '<script>alert("User details updated successfully!");</script>';
            echo '<script>window.location.href = "users.php";</script>';
            exit();
        } else {
            echo "Error updating user account details: " . $conn->error;
        }
    } else {
        echo "Error deleting from program_chairs table: " . $conn->error;
    }
} else {
    echo "Record not found for ID: $ID";
}

$conn->close();
?>
