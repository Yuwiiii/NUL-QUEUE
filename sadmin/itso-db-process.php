<?php
@include '../database.php';

// Assuming your offices table has a column named 'officeName'
$officeSql = "SELECT DISTINCT officeName FROM offices";
$officeResult = $conn->query($officeSql);

if ($officeResult) {
    while ($officeRow = $officeResult->fetch_assoc()) {
        $officeName = $officeRow['officeName'];

        $sql = "SELECT * FROM your_table_name WHERE officeName = '$officeName'";
        $result = $conn->query($sql);

        if ($result) {
            $customerRowCount = $result->num_rows;
            echo $customerRowCount . ",";
        }
    }
}
?>
