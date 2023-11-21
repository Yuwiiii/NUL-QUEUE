<?php
@include '../database.php';

// Fetch distinct office names from the 'offices' table
$officeSql = "SELECT DISTINCT officeName FROM offices";
$officeResult = $conn->query($officeSql);

$response = [];

if ($officeResult) {
    while ($officeRow = $officeResult->fetch_assoc()) {
        $officeName = $officeRow['officeName'];

        // Check if the selected office exists in the 'offices' table
        $sqlCheckOffice = "SELECT * FROM offices WHERE officeName = '$officeName'";
        $resultCheckOffice = $conn->query($sqlCheckOffice);

        if ($resultCheckOffice->num_rows > 0) {
            // Use prepared statements for security
            $sql = "SELECT COUNT(*) AS customer_count FROM `$officeName`";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $customerCount = $row['customer_count'];

            // Add the office and customer count to the response array
            $response[] = ["office" => $officeName, "customer_count" => $customerCount];
        } else {
            // Add a placeholder for non-existent offices
            $response[] = ["office" => $officeName, "customer_count" => 0];
        }
    }
}

// Output the response as JSON
echo json_encode($response);
?>
