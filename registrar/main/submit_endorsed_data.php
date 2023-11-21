<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentId'];
    $endorsedTo = $_POST['endorsedTo'];
    $transaction = $_POST['transaction'];
    $remarks = $_POST['remarks'];
    $queueNumber = $_POST['queueNo'];
    $program = $_POST['program'];
    $concern = $_POST['concern'];

    // Fetch the course from the program_chairs table
    $fetchCourseSql = "SELECT course FROM program_chairs WHERE full_name = '$concern'";
    $courseResult = $conn->query($fetchCourseSql);
    $courseRow = $courseResult->fetch_assoc();
    $course = $courseRow['course'];
  
      

    $fetchTimestampSql = "SELECT timestamp FROM registrar WHERE queue_number = '$queueNumber'";
    $timestampResult = $conn->query($fetchTimestampSql);

    if ($timestampResult->num_rows === 1) {
        $timestampRow = $timestampResult->fetch_assoc();
        $originalTimestamp = $timestampRow['timestamp'];

    switch ($endorsedTo) {
            case 'Accounting':
                $tableName = 'accounting';
                $columnNames = "queue_number, student_id, remarks,transaction, endorsed_to";
                $columnValues = "'$queueNumber', '$studentId', '$remarks','$transaction','ACCOUNTING'";
                break;
            case 'Assets':
                $tableName = 'assets';
                $columnNames = "queue_number, student_id, remarks,transaction, endorsed_to";
                $columnValues = "'$queueNumber', '$studentId', '$remarks','$transaction','ASSETS'";
                break;
            case 'ITSO':
                $tableName = 'itso';
                $columnNames = "queue_number, student_id, remarks,transaction, endorsed_to";
                $columnValues = "'$queueNumber', '$studentId', '$remarks','$transaction','ITSO'";
                break;
                case 'Academics':
                    $tableName = 'academics_queue';
                    $columnNames = "queue_number, student_id, remarks, program, concern, transaction, endorsed_to, course";
                    $columnValues = "'$queueNumber', '$studentId', '$remarks', '$program', '$concern', '$transaction','ACADEMICS', '$course'";
                    break;
            case 'Admission':
                    $tableName = 'admission';
                    $columnNames = "queue_number, student_id, transaction, remarks, endorsed_to";
                    $columnValues = "'$queueNumber', '$studentId','$transaction', '$remarks', 'ADMISSION'";
                    break;
            case 'Clinic':
                        $tableName = 'clinic';
                        $columnNames = "queue_number, student_id, remarks,transaction, endorsed_to";
                        $columnValues = "'$queueNumber', '$studentId', '$remarks','$transaction', 'CLINIC'";
                        break;
            case 'Guidance':
                            $tableName = 'guidance';
                            $columnNames = "queue_number, student_id, remarks,transaction, endorsed_to";
                            $columnValues = "'$queueNumber', '$studentId', '$remarks','$transaction','GUIDANCE'";
                            break;
                             default:
                             $_SESSION['notification_message'] = "<span style='color: red;'>Invalid department selected or Queue Number does not exist.</span>";
                             header("Location: registrar_admin.php");
                             exit;
        }

        if (isset($tableName)) {
            $sql = "INSERT INTO $tableName ($columnNames, timestamp) VALUES ($columnValues, '$originalTimestamp')";
    
            if ($conn->query($sql) === true) {
                $updateEndorsedFromSql = "UPDATE $tableName SET endorsed_from = 'REGISTRAR' WHERE queue_number = '$queueNumber'";
    
                if ($conn->query($updateEndorsedFromSql) === true) {
                    // Delete the record from the registrar table
                    $deleteSql = "DELETE FROM registrar WHERE queue_number = '$queueNumber'";
                    $conn->query($deleteSql);
    
                    // Update the status in the display table
                    $updateDisplaySql = "UPDATE display SET status = 1 WHERE queue_number = '$queueNumber' AND officeName = 'REGISTRAR'";
                    $conn->query($updateDisplaySql);
    
                    session_start();
                    $_SESSION['notification_message'] = "Endorsed Successfully in $endorsedTo Office. Your Queue number is $queueNumber";
                    header("Location: registrar_admin.php");
                    exit;
                } else {
                    echo "Error updating endorsed_from: " . $conn->error;
                }
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Invalid department selected.";
        }
    } else {
        session_start();
        $_SESSION['notification_message'] = "No Queue Number Detected";
        header("Location: registrar_admin.php");
        exit;
    }
}
    $conn->close();
    ?>