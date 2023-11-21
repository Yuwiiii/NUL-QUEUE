<?php

$db_host = "localhost";
$db_username = "root";
$db_password = ""; 
$db_name = "queuing_system";


$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM registrar WHERE status = 0";
$result = $conn->query($sql);

$window1 = $window2 = $window3 = $window4 = 'Loading...'; 

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        switch ($row['window']) {
            case 1:
                $window1 = $row['queue_number'];
                break;
            case 2:
                $window2 = $row['queue_number'];
                break;
            case 3:
                $window3 = $row['queue_number'];
                break;
            case 4:
                $window4 = $row['queue_number'];
                break;
            default:
             
                break;
        }
    }
}


header('Content-Type: application/json');
echo json_encode([
    'window1' => $window1,
    'window2' => $window2,
    'window3' => $window3,
    'window4' => $window4
]);


$conn->close();
?>
