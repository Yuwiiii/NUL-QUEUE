<<<<<<< HEAD
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
$program = $_POST['academicDepartment'];
$course = $_POST['addcourse'];

// Check if a record with the same full_name or username already exists
$checkSql = "SELECT * FROM user_accounts WHERE full_name = '$full_name' OR username = '$username'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows == 0) {

    $insertUserSql = "INSERT INTO user_accounts (full_name, office, window, username, password) 
        VALUES ('$full_name', '$program', '$window', '$username', '$password')";

    if ($conn->query($insertUserSql) === TRUE) {
        // Retrieve the ID of the newly inserted user
        $userID = $conn->insert_id;

        $insertChairSql = "INSERT INTO program_chairs (full_name, program, user_id, course) 
            VALUES ('$full_name', '$program', '$userID', '$course')";

        if ($conn->query($insertChairSql) === TRUE) {
            // User and program chair added successfully
            // Redirect or display a success message
            echo '<script>alert("User and program chair added successfully!");</script>';
            echo '<script>window.location.href = "users.php";</script>';
            exit();
        } else {
            echo "Error inserting into program_chairs: " . $insertChairSql . "<br>" . $conn->error;
        }
    } else {
        echo "Error inserting into user_accounts: " . $insertUserSql . "<br>" . $conn->error;
    }
} else {
    // A record with the same full_name or username already exists
    echo '<script>alert("A user with the same name or username already exists.");</script>';
    echo '<script>window.location.href = "users.php";</script>';
    exit();
}

$conn->close();
?>
=======
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
$program = $_POST['academicDepartment'];
$course = $_POST['addcourse'];

// Check if a record with the same full_name or username already exists
$checkSql = "SELECT * FROM user_accounts WHERE full_name = '$full_name' OR username = '$username'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows == 0) {

    $insertUserSql = "INSERT INTO user_accounts (full_name, office, window, username, password) 
        VALUES ('$full_name', '$program', '$window', '$username', '$password')";

    if ($conn->query($insertUserSql) === TRUE) {
        // Retrieve the ID of the newly inserted user
        $userID = $conn->insert_id;

        $insertChairSql = "INSERT INTO program_chairs (full_name, program, user_id, course) 
            VALUES ('$full_name', '$program', '$userID', '$course')";

        if ($conn->query($insertChairSql) === TRUE) {
            // User and program chair added successfully
            // Redirect or display a success message
            echo '<script>alert("User and program chair added successfully!");</script>';
            echo '<script>window.location.href = "users.php";</script>';
            exit();
        } else {
            echo "Error inserting into program_chairs: " . $insertChairSql . "<br>" . $conn->error;
        }
    } else {
        echo "Error inserting into user_accounts: " . $insertUserSql . "<br>" . $conn->error;
    }
} else {
    // A record with the same full_name or username already exists
    echo '<script>alert("A user with the same name or username already exists.");</script>';
    echo '<script>window.location.href = "users.php";</script>';
    exit();
}

$conn->close();
?>
>>>>>>> 370c682425903fd586c09a59324ffca61c227b8b
