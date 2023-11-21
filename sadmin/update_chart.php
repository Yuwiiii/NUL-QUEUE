<?php
include '../database.php';

$selectedMonthStart = $_POST['monthstart'];
$selectedMonthEnd = $_POST['monthend'];
$selectedOffice = $_POST['office'];
$selectedYear = $_POST['year'];

if ($selectedOffice === 'ALL-OFFICES') {
    $query = $conn->query("SELECT
    SUM(IFNULL(customer_count, 0)) AS total_customers,
    CONCAT(
        DATE_FORMAT(MIN(specific_date), '%M %e, %Y'),
        CASE WHEN MIN(specific_date) <> MAX(specific_date) 
             THEN CONCAT(' to ', DATE_FORMAT(MAX(specific_date), '%M %e, %Y'))
             ELSE ''
        END
    ) AS week_date_range
FROM (
    SELECT
        IFNULL(COUNT(q2.timestamp), 0) AS customer_count,
        DATE(q2.timestamp) AS specific_date
    FROM
        queue_logs q2
    WHERE
        YEAR(q2.timestamp) = $selectedYear
        AND MONTH(q2.timestamp) BETWEEN $selectedMonthStart AND $selectedMonthEnd
    GROUP BY
        specific_date
) AS subquery
GROUP BY
    WEEK(specific_date);");
} else {
    $query = $conn->query("SELECT
    SUM(IFNULL(customer_count, 0)) AS total_customers,
    CONCAT(
        DATE_FORMAT(MIN(specific_date), '%M %e, %Y'),
        CASE WHEN MIN(specific_date) <> MAX(specific_date) 
             THEN CONCAT(' to ', DATE_FORMAT(MAX(specific_date), '%M %e, %Y'))
             ELSE ''
        END
    ) AS week_date_range
FROM (
    SELECT
        IFNULL(COUNT(q2.timestamp), 0) AS customer_count,
        DATE(q2.timestamp) AS specific_date
    FROM
        queue_logs q2
    WHERE
        YEAR(q2.timestamp) = $selectedYear
        AND MONTH(q2.timestamp) BETWEEN $selectedMonthStart AND $selectedMonthEnd
        AND q2.office = '$selectedOffice'
    GROUP BY
        specific_date
) AS subquery
GROUP BY
    WEEK(specific_date);
");
}

$customer = [];
$week = [];

foreach ($query as $data) {
    $customer[] = $data['total_customers'];
    $week[] = $data['week_date_range'];
}

// Combine data into a single associative array
$response = [
    'customer' => $customer,
    'week' => $week,
];

// Encode the combined array as JSON
echo json_encode($response);
?>