<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$queryWindow1 = "SELECT * FROM registrar WHERE window = 1 AND status = 0 ORDER BY id ASC LIMIT 1";
$resultWindow1 = $conn->query($queryWindow1);

$window1Data = null;

if ($resultWindow1->num_rows > 0) {
    $window1Data = $resultWindow1->fetch_assoc();
}

$queryWindow2 = "SELECT * FROM registrar WHERE window = 2 AND status = 0 ORDER BY id ASC LIMIT 1";
$resultWindow2 = $conn->query($queryWindow2);

$window2Data = null;

if ($resultWindow2->num_rows > 0) {
    $window2Data = $resultWindow2->fetch_assoc();
}

$queryWindow3 = "SELECT * FROM registrar WHERE window = 3 AND status = 0 ORDER BY id ASC LIMIT 1";
$resultWindow3 = $conn->query($queryWindow3);

$window3Data = null;

if ($resultWindow3->num_rows > 0) {
    $window3Data = $resultWindow3->fetch_assoc();
}


$queueToDisplay = null;


if ($window1Data !== null && $window2Data !== null) {
    
    if ($window1Data['timestamp'] < $window2Data['timestamp']) {
        $queueToDisplay = $window1Data['queue_number'];
    } else {
        $queueToDisplay = $window2Data['queue_number'];
    }
} elseif ($window1Data !== null) {
   
    $queueToDisplay = $window1Data['queue_number'];
} elseif ($window2Data !== null) {
   
    $queueToDisplay = $window2Data['queue_number'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/displayqueue.css">
    <link href='http://fonts.googleapis.com/css?family=' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="main-container">
        <!-- TOP CONTAINER STARTS (REGISTRAR ACCOUNTING ADMISSIONS ASSETS) -->
        <div class="registrar-container araa-office">
            <h1 class="office-title">REGISTRAR</h1>
            <ul>
            <li class="queue-list">
            <p class="window">Window 1:</p>
            <p class="window-q"><?php echo isset($window1Data) ? $window1Data['queue_number'] : 'Not Available'; ?></p>
            </li>
            <li class="queue-list">
            <p class="window">Window 2:</p>
            <p class="window-q"><?php echo isset($window2Data) ? $window2Data['queue_number'] : 'Not Available'; ?></p>
            </li>
             <li class="queue-list">
            <p class="window">Window 3:</p>
            <p class="window-q"><?php echo isset($window3Data) ? $window3Data['queue_number'] : 'Not Available'; ?></p>
        </li>
            </ul>
        </div>

        <div class="accounting-container araa-office">
            <h1 class="office-title">ACCOUNTING</h1>
            <ul>
                <li class="queue-list"><p class="window">Window 1:</p><p class="window-q">AC0001</p></li>
                <li class="queue-list"><p class="window">Window 2:</p><p class="window-q">Loading...</p></li>
                <li class="queue-list"><p class="window">Window 3:</p><p class="window-q">Loading...</p></li>
                <li class="queue-list"><p class="window">Window 4:</p><p class="window-q">Loading...</p></li>
            </ul>
        </div>

        <div class="admissions-assets-container">
            <div class="admissions-container araa-office">
                <h1 class="office-title">ADMISSIONS</h1>
                <p>Loading...</p>
            </div>

            <div class="assets-container araa-office">
                <h1 class="office-title">ASSETS</h1>
                <p>Loading...</p>
            </div>
        </div>
        <!-- TOP CONTAINER ENDS (REGISTRAR ACCOUNTING ADMISSIONS ASSETS) -->

        <!-- BOTTOM CONTAINER STARTS (DATE ACADEMICS CLINIC ITRO GUIDANCE) -->
        <div class="date-container dac-container">
            <h3 id="date"></h3>
            <h1 id="time"></h1>
        </div>

        <div class="academics-container dac-container">
            <h1>ACADEMICS</h1>
            <ul>
                <li class="queue-list"><p class="window">SCS:</p><p class="window-q">SCS0001</p></li>
                <li class="queue-list"><p class="window">SABM:</p><p class="window-q">Loading...</p></li>
                <li class="queue-list"><p class="window">CEA:</p><p class="window-q">Loading...</p></li>
                <li class="queue-list"><p class="window">CAS:</p><p class="window-q">Loading...</p></li>
                <li class="queue-list"><p class="window">SHS:</p><p class="window-q">Loading...</p></li>
                <!-- <li>SABM: Loading...</li>
                <li>CEA: Loading...</li>
                <li>CAS: Loading...</li>
                <li>SHS: Loading...</li> -->
            </ul>
        </div>

        <div class="cig-container dac-container">
            <div class="clinic-container">
                <h1>CLINIC</h1>
                <p>CL0001</p>
            </div>

            <div class="itro-container">
                <h1>ITRO</h1>
                <p>Loading...</p>
            </div>

            <div class="guidance-container">
                <h1>GUIDANCE</h1>
                <p>Loading...</p>
            </div>
        </div>
        <!-- BOTTOM CONTAINER ENDS (DATE ACADEMICS CLINIC ITRO GUIDANCE) -->
    </div>











    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script/displayscript.js"></script>

</body>

</html>