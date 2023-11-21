<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "queuing_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $queueData = array();

   //SHS
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Marlon Diloy'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSITBSIS"] = $row["queue_number"];
    } else {
        $queueData["BSITBSIS"] = "Loading...";
    }

    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Vincent Rivera'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSCS"] = $row["queue_number"];
    } else {
        $queueData["BSCS"] = "Loading...";
    }

    //SABM
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Florenda De Vero'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSTM"] = $row["queue_number"];
    } else {
        $queueData["BSTM"] = "Loading...";
    }

    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Johnny Boy Tizon'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSBA"] = $row["queue_number"];
    } else {
        $queueData["BSBA"] = "Loading...";
    }
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Arnel Villamin'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSA"] = $row["queue_number"];
    } else {
        $queueData["BSA"] = "Loading...";
    }

    //SEA
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Brian De Guzman'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSCE"] = $row["queue_number"];
    } else {
        $queueData["BSCE"] = "Loading...";
    }

    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Juliet Niega'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSCpE"] = $row["queue_number"];
    } else {
        $queueData["BSCpE"] = "Loading...";
    }
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Joseph Alcoran'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSArch"] = $row["queue_number"];
    } else {
        $queueData["BSArch"] = "Loading...";
    }

    
    //SAS
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Carlito Loyola Jr.'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["MMAABCOMM"] = $row["queue_number"];
    } else {
        $queueData["MMAABCOMM"] = "Loading...";
    }

    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Marjualita Malapo'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSPsych"] = $row["queue_number"];
    } else {
        $queueData["BSPsych"] = "Loading...";
    }
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Frederick Dalena'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSESS"] = $row["queue_number"];
    } else {
        $queueData["BSESS"] = "Loading...";
    }
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Jude Thaddeus Bartolome'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["BSCrim"] = $row["queue_number"];
    } else {
        $queueData["BSCrim"] = "Loading...";
    }



    //SHS
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Richard Miguel Butial'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["ABM"] = $row["queue_number"];
    } else {
        $queueData["ABM"] = "Loading...";
    }
    
    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Jhanna Mae Tadique'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["STEM"] = $row["queue_number"];
    } else {
        $queueData["STEM"] = "Loading...";
    }

    $sql = "SELECT queue_number FROM academics_queue WHERE status = 1 AND concern = 'Maria Carina Pontanar'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $queueData["HUMSS"] = $row["queue_number"];
    } else {
        $queueData["HUMSS"] = "Loading...";
    }
    // Return the queue numbers as a single JSON response
    echo json_encode($queueData);
}

$conn->close();
?>
