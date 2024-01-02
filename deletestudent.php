<?php
@include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the student ID is set
    if (isset($_POST['studentId'])) {
        $studentId = $_POST['studentId'];

        // Fetch the office name associated with the student from the offices table
        $officeQuery = "SELECT officeName FROM offices";
        $officeResult = $conn->query($officeQuery);

        if ($officeResult->num_rows > 0) {
            // Loop through the office names and delete records from respective tables
            while ($row = $officeResult->fetch_assoc()) {
                $officeName = $row['officeName'];

                // Construct the DELETE query for each office-specific table
                $deleteQuery = "DELETE FROM $officeName WHERE student_id = '$studentId';";
                $deleteResult = $conn->query($deleteQuery);

                // Handle errors if needed
                if (!$deleteResult) {
                    echo json_encode(['status' => 'error', 'message' => 'Error deleting records from office-specific table.']);
                    exit;
                }
            }

            // Additional DELETE queries for specific tables
            $deleteQuery2 = "DELETE FROM queue WHERE student_id = '$studentId';";
            $deleteQuery3 = "DELETE FROM academics_queue WHERE student_id = '$studentId';";

            // Execute additional DELETE queries
            $deleteResult2 = $conn->query($deleteQuery2);
            $deleteResult3 = $conn->query($deleteQuery3);

            // Handle errors if needed
            if (!$deleteResult2 || !$deleteResult3) {
                echo json_encode(['status' => 'error', 'message' => 'Error deleting records from additional tables.']);
                exit;
            }

            // All records deleted successfully
            echo json_encode(['status' => 'success', 'message' => 'Records deleted successfully.']);
            exit;
        } else {
            // No matching office found
            echo json_encode(['status' => 'error', 'message' => 'No matching office found.']);
            exit;
        }
    }
}
?>
