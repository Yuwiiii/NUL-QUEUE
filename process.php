<?php
@include 'database.php';

// clone data to admission table.
function insertQueueToAdmission($data)
{
    global $conn;
    $studentId = $data['studentId'];
    $program = $data['program'] ?? null;
    $queueNumber = $data['queue_number'];
    $timeStamp = date('Y-m-d H:i:s');
    $transaction = $data['transaction'] ?? null;
    $remarks = $data['remarks'] ?? null;
    $endorsed = 'Kiosk';

    $sql = "INSERT INTO admission (queue_number, student_id, timestamp, transaction, remarks, program, endorsed_from) VALUES ('$queueNumber', '$studentId', '$timeStamp', '$transaction', '$remarks', '$program', '$endorsed')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function insertQueueToTables($tabledata)
{
    global $conn;
    $studentId = $tabledata['studentId'];
    $queueNumber = $tabledata['queue_number'];
    $timeStamp = date('Y-m-d H:i:s');
    $office = strtolower(str_replace(' ', '', $tabledata['office']));
    $transaction = ''; // Initialize transaction variable

    // Set transaction based on the selected office
    switch ($office) {
        case 'accounting':
            $transaction = 'Payments';
            break;
        // Add more cases for other offices if needed
        // case 'another_office':
        //     $transaction = 'Another Transaction';
        //     break;
        default:
            // Default transaction value if the office doesn't match any case
            $transaction = 'Default Transaction';
            break;
    }

    // Build the SQL query
    $sql = "INSERT INTO $office (queue_number, student_id, endorsed_from, transaction) VALUES ('$queueNumber', '$studentId', 'Kiosk', '$transaction')";
    $sql2 = "INSERT INTO queue_logs (queue_number, student_id, office, endorsed) VALUES ('$queueNumber', '$studentId', '$office', 'Kiosk')";

    // Execute the query
    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Handle the request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $office = $_POST["office"];
    $studentId = $_POST["studentId"];
    $program = $_POST["program"];
    $endorsed = "kiosk";


    // Get the next queue number for the selected office
    $queueNumber = getNextQueueNumber($office);

    // Insert the record into the database
    $sql = "INSERT INTO queue (student_id, program, queue_number, office, endorsed) VALUES ('$studentId', '$program', '$queueNumber', '$office', '$endorsed')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "queue_number" => $queueNumber]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }

    if ($office === "ADMISSION") {
        $admissionData = [
            "studentId" => $studentId,
            "program" => $program,
            "queue_number" => $queueNumber,
            "transaction" => null,
            "remarks" => null
        ];

        insertQueueToAdmission($admissionData);
    }

    if ($office !== "ADMISSION" && $office !== "ACADEMICS"){
        $tabledata = [
            "studentId" => $studentId,
            "queue_number" => $queueNumber,
            "office" => $office
        ];

        insertQueueToTables($tabledata);
    }
} else {
    echo "Invalid request";
}


// Function to get the next queue number for a given office
function getNextQueueNumber($office)
{
    global $conn;

    // Fetch the acronym from the offices table
    $acronymSql = "SELECT acronym FROM offices WHERE officeName = '$office'";
    $acronymResult = $conn->query($acronymSql);

    if ($acronymResult->num_rows > 0) {
        $acronymRow = $acronymResult->fetch_assoc();
        $acronym = $acronymRow['acronym'];
    } else {
        // Default to a generic prefix if no acronym is found
        $acronym = "DEFAULT";
    }

    // Use the fetched or default acronym as the prefix
    $prefix = $acronym;

    $sql = "SELECT MAX(queue_number) as max_queue FROM queue WHERE office = '$office'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maxQueue = $row['max_queue'];
        // Extract the numeric part of the queue number
        $numericPart = (int) substr($maxQueue, strlen($prefix));
        // Increment the numeric part
        $nextNumericPart = $numericPart + 1;
        // Format the next queue number
        $nextQueue = $prefix . str_pad($nextNumericPart, 3, '0', STR_PAD_LEFT);
        return $nextQueue;
    } else {
        // If no records exist for the office, start from 001
        return $prefix . "001";
    }
}


$conn->close();
