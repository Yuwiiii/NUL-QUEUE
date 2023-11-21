<?php
include '../database.php';

// Retrieve selected start month, end month, and year from the form
$selectedStartMonth = $_POST['monthSelectStart'];
$selectedEndMonth = $_POST['monthSelectEnd'];
$selectedYear = $_POST['yearSelect'];
$selectedOffice = $_POST['officeSelect'];

if ($selectedOffice === 'ALL-OFFICES') {
// Prepare and execute the query based on the selected parameters
$query = "SELECT
            COUNT(queue_logs.timestamp) AS customer_count,
            DATE_FORMAT(queue_logs.timestamp, '%M %e, %Y') AS specific_date,
            queue_logs.office AS specific_office
        FROM queue_logs
        WHERE
            YEAR(queue_logs.timestamp) = $selectedYear
            AND MONTH(queue_logs.timestamp) BETWEEN $selectedStartMonth AND $selectedEndMonth
        GROUP BY
            specific_date, specific_office
        ORDER BY
            specific_date, specific_office";
} else {
    $query = "SELECT
            COUNT(queue_logs.timestamp) AS customer_count,
            DATE_FORMAT(queue_logs.timestamp, '%M %e, %Y') AS specific_date,
            queue_logs.office AS specific_office
        FROM queue_logs
        WHERE
            YEAR(queue_logs.timestamp) = $selectedYear
            AND MONTH(queue_logs.timestamp) BETWEEN $selectedStartMonth AND $selectedEndMonth
            AND queue_logs.office = '$selectedOffice'
        GROUP BY
            specific_date, specific_office
        ORDER BY
            specific_date, specific_office";
}

try {
    $result = $conn->query($query);
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// Generate the CSV file if no error occurs
if ($result) {
    $csvContent = "";
    $csvContent .= "Customer Count,Date,Year,Office\n";

    while ($row = $result->fetch_assoc()) {
        $csvContent .= "{$row['customer_count']},{$row['specific_date']},{$row['specific_office']}\n";
    }

    // Set headers and output the CSV content
    $today = date('Ymd');
    header('Content-Type: application/csv');
    header("Content-Disposition: attachment; filename=customer_data_{$today}.csv");
    echo $csvContent;
}
?>