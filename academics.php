<?php
@include 'database.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['program'])) {
        $program = $_GET['program'];
        $query = "SELECT id, full_name, status FROM program_chairs WHERE program = '$program'";
        $result = mysqli_query($conn, $query);

        $data = array();

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[$row['id']] = array(
                    'full_name' => $row['full_name'],
                );
            }
        }

        echo json_encode($data);
    } else {
        echo json_encode(array());
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the POST request
    $concern = $_POST["concern"];
    $program = $_POST["program"];
    $studentId = $_POST["studentId"];
    $queueNumber = getNextQueueNumber($program);

    // Fetch $course from program_chairs table
    $fetchCourseQuery = "SELECT course FROM program_chairs WHERE full_name = '$concern'";
    $courseResult = $conn->query($fetchCourseQuery);

    if ($courseResult && $courseResult->num_rows > 0) {
        $row = $courseResult->fetch_assoc();
        $course = $row["course"];

        $endorse = 'kiosk';
        // Database insert into academics and academics_queue tables
        $sql = "INSERT INTO academics (concern, program, student_id, queue_number, transaction, endorsed_from) VALUES ('$concern', '$program', '$studentId', '$queueNumber', 'Subject Registration' , '$endorse')";
        $sql2 = "INSERT INTO academics_queue (concern, program, student_id, queue_number, transaction, course, endorsed_from) VALUES ('$concern', '$program', '$studentId', '$queueNumber', 'Subject Registration', '$course', '$endorse')";

        if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
            // Insert into queue table
            $office = $_POST["office"];
            $program_queue = $_POST["program_queue"];
            $endorsed = "kiosk";

            // Check if the office exists in the colleges table
            $officeExistsQuery = "SELECT acronym FROM colleges WHERE acronym = '$office'";
            $officeExistsResult = $conn->query($officeExistsQuery);

            if ($officeExistsResult->num_rows > 0) {
                $office = "ACADEMICS";
            }

            $queueSql = "INSERT INTO queue (student_id, program, queue_number, office, endorsed) VALUES ('$studentId', '$program_queue', '$queueNumber', '$office', '$endorsed')";
            $queuelogssql = "INSERT INTO queue_logs (queue_number, student_id, office, endorsed) VALUES ('$queueNumber', '$studentId', '$office', 'Kiosk')";
            if ($conn->query($queueSql) === TRUE && $conn->query($queuelogssql) === TRUE) {
                echo json_encode(["success" => true, "queue_number" => $queueNumber]);
            } else {
                echo json_encode(["success" => false, "message" => "Error inserting into queue table: " . $conn->error]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Error inserting into academics table or academics_queue table: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching course from program_chairs table: " . $conn->error]);
    }
} else {
    echo "Invalid request";
}

function getNextQueueNumber($program)
{
    global $conn;
    // Fetch the acronym from the offices table
    $acronymSql = "SELECT acronym FROM colleges WHERE acronym = '$program'";
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

    $sql = "SELECT MAX(queue_number) as max_queue FROM academics WHERE program = '$program'";
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
?>