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

$ID = $_POST['ID'];
$full_name = $_POST['full_name'];
$office = $_POST['office'];
$window = $_POST['selectWindow'];
$username = $_POST['username'];
$password = $_POST['password'];
$program = $_POST['editacademicDepartment'];
$course = $_POST['editcourse'];

// Check if record exists
$checkSql = "SELECT * FROM user_accounts WHERE ID='$ID'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    // Check if the program exists in the colleges table
    $checkProgramSql = "SELECT * FROM colleges WHERE acronym='$program'";
    $checkProgramResult = $conn->query($checkProgramSql);

    if ($checkProgramResult->num_rows > 0) {
        // Update the user details
        $updateSql = "UPDATE user_accounts 
                      SET full_name = '$full_name',
                          office = '$program',
                          username = '$username',
                          window = '$window',
                          password = '$password'
                      WHERE ID = '$ID'";

        if ($conn->query($updateSql) === TRUE) {

            // Retrieve full_name from user_accounts table
            $fullNameQuery = "SELECT full_name FROM user_accounts WHERE ID='$ID'";
            $fullNameResult = $conn->query($fullNameQuery);

            if ($fullNameResult->num_rows > 0) {
                $row = $fullNameResult->fetch_assoc();
                $userFullName = $row['full_name'];


                // Check if the record already exists in the program_chairs table
                $checkChairSql = "SELECT * FROM program_chairs WHERE user_id='$ID'";
                $checkChairResult = $conn->query($checkChairSql);

                if ($checkChairResult->num_rows > 0) {
                    // Update the program_chairs table
                    $updateChairSql = "UPDATE program_chairs 
                                       SET full_name = '$full_name',
                                           program = '$program',
                                           course = '$course'
                                       WHERE user_id = '$ID'";

                    if ($conn->query($updateChairSql) === TRUE) {
                        echo '<script>alert("User details updated successfully!");</script>';
                    } else {
                        echo "Error updating program_chairs table: " . $conn->error;
                    }
                } else {
                    // Insert into program_chairs table
                    $insertChairSql = "INSERT INTO program_chairs (full_name, program, user_id) 
                                        VALUES ('$full_name', '$program', '$ID')";

                    if ($conn->query($insertChairSql) === TRUE) {
                        echo '<script>alert("User details updated successfully!");</script>';
                    } else {
                        echo "Error inserting into program_chairs table: " . $conn->error;
                    }
                }
            } else {
                echo "Error retrieving full name: " . $conn->error;
            }

            // Redirect to users.php
            echo '<script>window.location.href = "users.php";</script>';
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error: Program '$program' not found in the colleges table.";
    }
} else {
    echo "Record not found for ID: $ID";
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

$ID = $_POST['ID'];
$full_name = $_POST['full_name'];
$office = $_POST['office'];
$window = $_POST['selectWindow'];
$username = $_POST['username'];
$password = $_POST['password'];
$program = $_POST['editacademicDepartment'];
$course = $_POST['editcourse'];

// Check if record exists
$checkSql = "SELECT * FROM user_accounts WHERE ID='$ID'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    // Check if the program exists in the colleges table
    $checkProgramSql = "SELECT * FROM colleges WHERE acronym='$program'";
    $checkProgramResult = $conn->query($checkProgramSql);

    if ($checkProgramResult->num_rows > 0) {
        // Update the user details
        $updateSql = "UPDATE user_accounts 
                      SET full_name = '$full_name',
                          office = '$program',
                          username = '$username',
                          window = '$window',
                          password = '$password'
                      WHERE ID = '$ID'";

        if ($conn->query($updateSql) === TRUE) {

            // Retrieve full_name from user_accounts table
            $fullNameQuery = "SELECT full_name FROM user_accounts WHERE ID='$ID'";
            $fullNameResult = $conn->query($fullNameQuery);

            if ($fullNameResult->num_rows > 0) {
                $row = $fullNameResult->fetch_assoc();
                $userFullName = $row['full_name'];


                // Check if the record already exists in the program_chairs table
                $checkChairSql = "SELECT * FROM program_chairs WHERE user_id='$ID'";
                $checkChairResult = $conn->query($checkChairSql);

                if ($checkChairResult->num_rows > 0) {
                    // Update the program_chairs table
                    $updateChairSql = "UPDATE program_chairs 
                                       SET full_name = '$full_name',
                                           program = '$program',
                                           course = '$course'
                                       WHERE user_id = '$ID'";

                    if ($conn->query($updateChairSql) === TRUE) {
                        echo '<script>alert("User details updated successfully!");</script>';
                    } else {
                        echo "Error updating program_chairs table: " . $conn->error;
                    }
                } else {
                    // Insert into program_chairs table
                    $insertChairSql = "INSERT INTO program_chairs (full_name, program, user_id) 
                                        VALUES ('$full_name', '$program', '$ID')";

                    if ($conn->query($insertChairSql) === TRUE) {
                        echo '<script>alert("User details updated successfully!");</script>';
                    } else {
                        echo "Error inserting into program_chairs table: " . $conn->error;
                    }
                }
            } else {
                echo "Error retrieving full name: " . $conn->error;
            }

            // Redirect to users.php
            echo '<script>window.location.href = "users.php";</script>';
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error: Program '$program' not found in the colleges table.";
    }
} else {
    echo "Record not found for ID: $ID";
}

$conn->close();
?>
>>>>>>> 370c682425903fd586c09a59324ffca61c227b8b
