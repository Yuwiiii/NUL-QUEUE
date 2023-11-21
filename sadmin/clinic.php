<?php
@include '../database.php';
session_start();

//FOR LOGIN CREDENTIALS
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit();
}

// FOR FETCHING THE DATA IN MYSQL
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM clinic";
$result = $conn->query($sql);

// FOR FETCHING THE COMPLETED QUEUE
$sqlCompleted = "SELECT COUNT(*) AS completed_count FROM clinic WHERE status = 1";
$resultCompleted = $conn->query($sqlCompleted);
$rowCompleted = $resultCompleted->fetch_assoc();
$completedCount = $rowCompleted['completed_count'];

// FOR FETCHING THE PENDING QUEUE
$sqlPending = "SELECT COUNT(*) AS pending_count FROM clinic WHERE status = 0";
$resultPending = $conn->query($sqlPending);
$rowPending = $resultPending->fetch_assoc();
$pendingCount = $rowPending['pending_count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLINIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/offices.css">
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'aside.php'; ?>
        <div class="col-9 offset-3">
            <h4 class="fs-2 pt-5 ps-5 pb-2 nu_color text-start">CLINIC</h4>
            <hr>

            <!-- DETAILED NUMBERS IN BOX STARTS -->
            <div class="row justify-content-center">
                    <div class="col-sm-3 mb-3" style="width: 18rem;">
                        <div class="card card-db">
                            <div class="card-body gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="#FFD41C"
                                    class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h2 class="mt-2 me-5  fw-bold nu_color float-end" id="clinic-count">
                                    ...
                                </h2>
                                <p class="fs-5 mt-n4 nu_color float-end">CUSTOMERS</p>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3" style="width: 18rem;">
                        <div class="card card-db">
                            <div class="card-body gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="#FFD41C"
                                    class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h2 class="mt-2 me-5  fw-bold nu_color float-end" id="completed-clinic-count">
                                    <?php echo $completedCount; ?>
                                </h2>
                                <p class="fs-5 mt-n4 nu_color float-end">COMPLETED</p>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3" style="width: 18rem;">
                        <div class="card card-db">
                            <div class="card-body gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="#FFD41C"
                                    class="bi bi-ticket-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13Z" />
                                </svg>

                                <h2 class="mt-2 me-5  fw-bold nu_color float-end" id="pending-clinic-count">
                                    <?php echo $pendingCount; ?>
                                </h2>
                                <p class="fs-5 mt-n4 nu_color float-end">PENDING</p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- DETAILED NUMBERS IN BOX ENDS -->

                <!-- TABLE STARTS -->
                <div class="table-search-container">
                    <div class="search-container position-relative d-flex justify-content-end">
                        <i class="bi bi-search"></i>
                        <input type="text" class="search" id="myInput" onkeyup="myTable()" placeholder="SEARCH" title="Type">
                    </div>
                    <div class="table-container" style="overflow-x:auto;">
                        <table id="myTable" class="myTable">
                            <tr class="header">
                                <th>ID</th>
                                <th>queue_number</th>
                                <th>student_id</th>
                                <th>timeout</th>
                                <th>remarks</th>
                                <th>status</th>
                            </tr>
                            <?php
                                // Loop through the database results and generate table rows
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['queue_number'] . "</td>";
                                    echo "<td>" . $row['student_id'] . "</td>";
                                    echo "<td>" . $row['sent_time_stop'] . "</td>";
                                    echo "<td>" . $row['remarks'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <!-- TABLE ENDS -->
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script/offices.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart.js"></script>
    <script src="../script/script.js"></script>
</body>

</html>