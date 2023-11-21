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
    

    switch ($endorsedTo) {

        case 'Registrar':
            $tableName = 'registrar';
            $columnNames = "queue_number, student_id, remarks,transaction";
            $columnValues = "'$queueNumber', '$studentId', '$remarks','$transaction'";
            break;
        case 'Accounting':
            $tableName = 'accounting';
            $columnNames = "queue_number, student_id, remarks,transaction";
            $columnValues = "'$queueNumber', '$studentId', '$remarks','$transaction'";
            break;
        case 'Academics':
            $tableName = 'academics';
            $columnNames = "queue_number, student_id, remarks, program, concern, transaction";
            $columnValues = "'$queueNumber', '$studentId', '$remarks', '$program', '$concern', '$transaction'";
            break;
        case 'Admission':
                $tableName = 'admission';
                $columnNames = "queue_number, student_id, remarks, transaction";
                $columnValues = "'$queueNumber', '$studentId', '$remarks', '$transaction'";
                break;
    
        default:
            echo "Invalid department selected.";
            break;
    }

    if (isset($tableName)) {
        $sql = "INSERT INTO $tableName ($columnNames) VALUES ($columnValues)";
    
        if ($conn->query($sql) === true) {
            
            $deleteSql = "DELETE FROM assets WHERE queue_number = '$queueNumber'";
            $conn->query($deleteSql);
    
            session_start();
            $_SESSION['notification_message'] = "$queueNumber Endorsed Successfully to $endorsedTo";
            header("Location: assets_admin.php"); 
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
} else {
    echo "Form submission not detected.";
}

$conn->close();
?>