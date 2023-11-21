<?php
@include '../database.php';

$countquery = $conn->query("SELECT office, COUNT(*) AS office_count
FROM queue
GROUP BY office
");

foreach ($countquery as $data) {
    $officecount[] = $data['office'];
    $customercount[] = $data['office_count'];
}
// Fetch all table names ending with "_logs"
$tableQuery = $conn->query("SELECT table_name
FROM information_schema.tables
WHERE table_name LIKE '%_logs'
  AND table_name NOT LIKE 'queue_logs';");

// Initialize arrays to store data
$office = [];
$count = [];
$name = [];
$time = [];

// Process each table
foreach ($tableQuery as $tableData) {
    $tableName = $tableData['table_name'];

    // Create a dynamic query for each table
    $query = "SELECT '$tableName' AS name, COUNT(*) AS office_count FROM $tableName";
    $tquery = "SELECT '$tableName' AS name, AVG(TIMESTAMPDIFF(SECOND, timestamp, timeout)/60) AS average_time FROM $tableName WHERE timestamp IS NOT NULL AND timeout IS NOT NULL;";

    // Execute the queries
    $officeQuery = $conn->query($query);
    $timeQuery = $conn->query($tquery);

    // Process the results
    foreach ($officeQuery as $data) {
        $count[] = $data['office_count'];
    }

    foreach ($timeQuery as $data) {
        $name[] = $data['name'];
        $time[] = $data['average_time'];
    }
}

echo json_encode([
    'name' => $name,
    'time' => $time,
    'customercount' => $customercount,
    'officecount' => $officecount
]);
?>