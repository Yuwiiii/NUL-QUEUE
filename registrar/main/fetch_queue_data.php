<?php

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['queueNumber'])) {
    $queueNumber = $_GET['queueNumber'];

   
    $sql = "SELECT queue_number, timestamp, student_id, transaction, remarks, endorsed_from, window FROM registrar WHERE queue_number = '$queueNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

      
        echo json_encode($row);
    } else {
       
        echo json_encode(array());
    }
} else {
   
    echo json_encode(array());
}



$conn->close();
?>
