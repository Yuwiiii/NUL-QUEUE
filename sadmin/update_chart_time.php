<?php
include '../database.php';

$selectedMonthStart = $_POST['monthstart'];
$selectedMonthEnd = $_POST['monthend'];
$selectedOffice = $_POST['office'];
$selectedYear = $_POST['year'];

if ($selectedOffice === 'admission') {
    $selectedOfficeWithLogs = 'admissions_logs';
} else {
    $selectedOfficeWithLogs = $selectedOffice . '_logs';
}

if ($selectedOffice === 'ALL-OFFICES') {

    // Total Customers Query
    $totalCustomersQuery = $conn->query("
        SELECT
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


    $logsTableQuery = $conn->query("SELECT table_name
    FROM information_schema.tables
    WHERE table_name LIKE '%_logs'
      AND table_name NOT LIKE 'queue_logs'");

    // Initialize arrays to store data
    $averageTime = [];
    $weekDateRangeAvgTime = [];

    // Process each logs table
    foreach ($logsTableQuery as $tableData) {
        $tableName = $tableData['table_name'];

        // Create a dynamic query for each logs table
        $timeQuery = $conn->query("
        SELECT
        AVG(TIMESTAMPDIFF(SECOND, timestamp, timeout)/60) AS average_time,
        CONCAT(
            DATE_FORMAT(MIN(timestamp), '%M %e, %Y'),
            CASE WHEN MIN(timestamp) <> MAX(timestamp) 
                 THEN CONCAT(' to ', DATE_FORMAT(MAX(timestamp), '%M %e, %Y'))
                 ELSE ''
            END
        ) AS week_date_range
    FROM
    $tableName
    WHERE
        YEAR(timestamp) = $selectedYear
        AND MONTH(timestamp) BETWEEN $selectedMonthStart AND $selectedMonthEnd
    GROUP BY
        WEEK(timestamp);
        ");

        // Process the results for average time
        foreach ($timeQuery as $data) {
            $averageTime[] = $data['average_time'];
            $weekDateRangeAvgTime[] = $data['week_date_range'];
        }
    }


} else {
    // Total Customers Query
    $totalCustomersQuery = $conn->query("
        SELECT
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


    $logsTableQuery = $conn->query("SELECT table_name
    FROM information_schema.tables
    WHERE table_name LIKE '%_logs'
      AND table_name NOT LIKE 'queue_logs'");

    // Initialize arrays to store data
    $averageTime = [];
    $weekDateRangeAvgTime = [];

    // Process each logs table
    foreach ($logsTableQuery as $tableData) {
        $tableName = $tableData['table_name'];

        // Create a dynamic query for each logs table
        $timeQuery = $conn->query("
        SELECT
        AVG(TIMESTAMPDIFF(SECOND, timestamp, timeout)/60) AS average_time,
        CONCAT(
            DATE_FORMAT(MIN(timestamp), '%M %e, %Y'),
            CASE WHEN MIN(timestamp) <> MAX(timestamp) 
                 THEN CONCAT(' to ', DATE_FORMAT(MAX(timestamp), '%M %e, %Y'))
                 ELSE ''
            END
        ) AS week_date_range
    FROM
    $selectedOfficeWithLogs
    WHERE
        YEAR(timestamp) = $selectedYear
        AND MONTH(timestamp) BETWEEN $selectedMonthStart AND $selectedMonthEnd
    GROUP BY
        WEEK(timestamp);
        ");

        // Process the results for average time
        foreach ($timeQuery as $data) {
            $averageTime[] = $data['average_time'];
            $weekDateRangeAvgTime[] = $data['week_date_range'];
        }
    }


}



$response = [
    'averageTime' => $averageTime,
    'weekDateRangeAvgTime' => $weekDateRangeAvgTime,
];


echo json_encode($response);
?>