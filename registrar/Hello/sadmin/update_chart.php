<?php
include '../database.php';

$selectedMonth = $_POST['month'];
$selectedOffice = $_POST['office'];

if ($selectedOffice === 'ALL-OFFICES') {
    $query = $conn->query("SELECT IFNULL(COUNT(q2.timestamp), 0) AS customer_week, 
    week.week_name
    FROM (
         SELECT 'WEEK 1' AS week_name
         UNION
         SELECT 'WEEK 2' AS week_name
         UNION
         SELECT 'WEEK 3' AS week_name
         UNION
         SELECT 'WEEK 4' AS week_name
    ) AS week
    LEFT JOIN queue q2 ON
        (DAY(q2.timestamp) BETWEEN 
             CASE week.week_name
                 WHEN 'WEEK 1' THEN 1
                 WHEN 'WEEK 2' THEN 8
                 WHEN 'WEEK 3' THEN 15
                 WHEN 'WEEK 4' THEN 22
             END
         AND
             CASE week.week_name
                 WHEN 'WEEK 1' THEN 7
                 WHEN 'WEEK 2' THEN 14
                 WHEN 'WEEK 3' THEN 21
                 WHEN 'WEEK 4' THEN DAY(LAST_DAY(q2.timestamp))
             END)

         AND MONTH(q2.timestamp) = $selectedMonth
    GROUP BY week.week_name;");
} else {
    $query = $conn->query("SELECT IFNULL(COUNT(q2.timestamp), 0) AS customer_week, 
        week.week_name
        FROM (
             SELECT 'WEEK 1' AS week_name
             UNION
             SELECT 'WEEK 2' AS week_name
             UNION
             SELECT 'WEEK 3' AS week_name
             UNION
             SELECT 'WEEK 4' AS week_name
        ) AS week
        LEFT JOIN queue q2 ON
            (DAY(q2.timestamp) BETWEEN 
                 CASE week.week_name
                     WHEN 'WEEK 1' THEN 1
                     WHEN 'WEEK 2' THEN 8
                     WHEN 'WEEK 3' THEN 15
                     WHEN 'WEEK 4' THEN 22
                 END
             AND
                 CASE week.week_name
                     WHEN 'WEEK 1' THEN 7
                     WHEN 'WEEK 2' THEN 14
                     WHEN 'WEEK 3' THEN 21
                     WHEN 'WEEK 4' THEN DAY(LAST_DAY(q2.timestamp))
                 END)

             AND MONTH(q2.timestamp) = $selectedMonth
             AND q2.office = '$selectedOffice'
        GROUP BY week.week_name;");
}

$customer = [];
$week = [];

foreach ($query as $data) {
    $customer[] = $data['customer_week'];
    $week[] = $data['week_name'];
}

echo json_encode($customer);
?>
