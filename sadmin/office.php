<?php
include '../database.php';

// Check if the 'office' parameter is set in the URL
if (isset($_GET['office'])) {
    // Retrieve the selected office name from the URL
    $selectedOffice = urldecode($_GET['office']);

    // Fetch the table name associated with the selected office
    $tableNameQuery = "SELECT officeName FROM offices WHERE officeName = ?";
    $stmtTableName = mysqli_prepare($conn, $tableNameQuery);

    // Check if the statement was prepared successfully
    if ($stmtTableName) {
        mysqli_stmt_bind_param($stmtTableName, "s", $selectedOffice);
        mysqli_stmt_execute($stmtTableName);
        $resultTableName = mysqli_stmt_get_result($stmtTableName);
        $rowTableName = mysqli_fetch_assoc($resultTableName);
    } else {
        // Handle the case when the statement could not be prepared
        echo '<p>Unable to prepare the SQL statement.</p>';
    }
} else {
    // Handle the case when no office is selected
    echo '<p>No office selected.</p>';
}

// Check if the selected office exists in the 'offices' table
if ($rowTableName) {
    //FOR TABLE WITH NO _LOGS
    // $officeTableName = $rowTableName['officeName'];

    //FOR TABLE WITH _LOGS
    $officeTableName = $rowTableName['officeName'];

    // Use prepared statements for security
    $sql = "SELECT * FROM `$officeTableName`";
    $result = $conn->query($sql);

    // Validate the result
    if ($result) {
        // FOR FETCHING THE COMPLETED QUEUE
        $sqlCompleted = "SELECT COUNT(*) AS completed_count FROM `" . $officeTableName . "_logs` WHERE DATE(timestamp) = CURDATE()";
        $stmtCompleted = mysqli_prepare($conn, $sqlCompleted);
        mysqli_stmt_execute($stmtCompleted);
        $resultCompleted = mysqli_stmt_get_result($stmtCompleted);
        $rowCompleted = mysqli_fetch_assoc($resultCompleted);
        $completedCount = $rowCompleted['completed_count'];

        // FOR FETCHING THE PENDING QUEUE
        $sqlPending = "SELECT COUNT(*) AS pending_count FROM `$officeTableName` WHERE status = 0";
        $stmtPending = mysqli_prepare($conn, $sqlPending);
        mysqli_stmt_execute($stmtPending);
        $resultPending = mysqli_stmt_get_result($stmtPending);
        $rowPending = mysqli_fetch_assoc($resultPending);
        $pendingCount = $rowPending['pending_count'];

        // FOR Count all rows in the table
        $sqlCustomerCount = "SELECT COUNT(*) AS customer_count FROM `$officeTableName`";
        $stmtCustomerCount = mysqli_prepare($conn, $sqlCustomerCount);
        mysqli_stmt_execute($stmtCustomerCount);
        $resultCustomerCount = mysqli_stmt_get_result($stmtCustomerCount);
        $rowCustomerCount = mysqli_fetch_assoc($resultCustomerCount);
        $customerCount = $rowCustomerCount['customer_count'];
    } else {
        echo '<p>Error fetching data for the selected office.</p>';
    }
} else {
    echo '<p>No data found for the selected office.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OFFICES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/offices.css">
    <style>
        .clickable-row {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'aside.php'; ?>
            <div class="col-9 offset-3">
                <h4 class="fs-2 pt-5 ps-5 pb-2 nu_color text-start">
                    <?php echo str_replace('_logs', '', $officeTableName); ?>
                </h4>
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
                                <h2 class="mt-2 me-5  fw-bold nu_color float-end" id="office-count">
                                    ...
                                </h2>
                                <p class="fs-5 mt-n4 nu_color float-end">CUSTOMERS</p>

                            </div>
                        </div>
                    </div>

                    <div type="button" data-bs-toggle="modal" data-bs-target="#completedModal" class="col-sm-3 mb-3"
                        style="width: 18rem;">
                        <div class="card card-db">
                            <div class="card-body gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="#FFD41C"
                                    class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h2 class="mt-2 me-5  fw-bold nu_color float-end" id="completed-accounting-count">
                                    <?php echo $completedCount; ?>
                                </h2>
                                <p class="fs-5 mt-n4 nu_color float-end">COMPLETED</p>

                            </div>
                        </div>
                    </div>

                    <div type="button" data-bs-toggle="modal" data-bs-target="#pendingModal" class="col-sm-3 mb-3"
                        style="width: 18rem;">
                        <div class="card card-db">
                            <div class="card-body gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="#FFD41C"
                                    class="bi bi-ticket-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13Z" />
                                </svg>

                                <h2 class="mt-2 me-5  fw-bold nu_color float-end" id="pending-accounting-count">
                                    <?php echo $pendingCount; ?>
                                </h2>
                                <p class="fs-5 mt-n4 nu_color float-end">PENDING</p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- DETAILED NUMBERS IN BOX ENDS -->

                <!-- COMPLETED MODAL STARTS -->


                <div class="modal fade" id="completedModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    <?php echo $officeTableName; ?> (Completed)
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-search-container">
                                    <div class="search-container position-relative d-flex justify-content-end">
                                        <i class="bi bi-search"></i>
                                        <input type="text" class="search" id="myInputcompleted"
                                            onkeyup="mycompletedTable()" placeholder="SEARCH" title="Type">
                                    </div>
                                    <div class="table-container"
                                        style="height: 400px; overflow-y: scroll; overflow-x: auto;">
                                        <?php
                                        // Check if the selected office exists in the 'offices' table
                                        if ($rowTableName) {
                                            $officeTableName = $rowTableName['officeName'];

                                            // Fetch all columns for the selected office's table
                                            $query = "SELECT * FROM  `" . $officeTableName . "_logs`";
                                            $result = mysqli_query($conn, $query);

                                            // Display the selected office information
                                            echo '<table id="myTablecompleted" class="myTable" border="1">';

                                            // Display header row
                                            echo '<tr class="header">';
                                            echo '<th>Queue Number</th>';
                                            echo '<th>Student ID</th>';
                                            echo '<th>Transaction</th>';
                                            echo '<th>Remarks</th>';
                                            echo '<th>Endorsed From</th>';
                                            echo '<th>Endorsed To</th>';
                                            echo '<th>Time Started</th>';
                                            echo '<th>Time Ended</th>';
                                            echo '</tr>';

                                            // Display data rows
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<td>' . $row['queue_number'] . '</td>';
                                                echo '<td>' . $row['student_id'] . '</td>';
                                                echo '<td>' . $row['transaction'] . '</td>';
                                                echo '<td>' . $row['remarks'] . '</td>';
                                                echo '<td>' . $row['endorsed_from'] . '</td>';
                                                echo '<td>' . $row['endorsed_to'] . '</td>';
                                                echo '<td>' . $row['timestamp'] . '</td>';
                                                echo '<td>' . $row['timeout'] . '</td>';
                                                echo '</tr>';
                                            }

                                            echo '</table>';
                                        } else {
                                            echo '<p>No data found for the selected office.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PENDING MODAL STARTS -->
                <div class="modal fade" id="pendingModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    <?php echo $officeTableName; ?> (Pending)
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-search-container">
                                    <div class="search-container position-relative d-flex justify-content-end">
                                        <i class="bi bi-search"></i>
                                        <input type="text" class="search" id="myInputpending" onkeyup="mypendingTable()"
                                            placeholder="SEARCH" title="Type">
                                    </div>
                                    <div class="table-container"
                                        style="max-height: 521px; overflow-y: scroll; overflow-x: auto;">
                                        <?php
                                        // Check if the selected office exists in the 'offices' table
                                        if ($rowTableName) {
                                            $officeTableName = $rowTableName['officeName'];

                                            // Fetch all columns for the selected office's table
                                            $query = "SELECT * FROM `$officeTableName` where status = 0";
                                            $result = mysqli_query($conn, $query);

                                            // Display the selected office information
                                            echo '<table id="myTablepending" class="myTable" border="1">';

                                            // Display header row
                                            echo '<tr class="header">';
                                            echo '<th>Queue Number</th>';
                                            echo '<th>Student ID</th>';
                                            echo '<th>Transaction</th>';
                                            echo '<th>Remarks</th>';
                                            echo '<th>Endorsed From</th>';
                                            echo '<th>Endorsed To</th>';
                                            echo '<th>Time Started</th>';
                                            echo '</tr>';
                                            echo '</tr>';

                                            // Display data rows
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<td>' . $row['queue_number'] . '</td>';
                                                echo '<td>' . $row['student_id'] . '</td>';
                                                echo '<td>' . $row['transaction'] . '</td>';
                                                echo '<td>' . $row['remarks'] . '</td>';
                                                echo '<td>' . $row['endorsed_from'] . '</td>';
                                                echo '<td>' . $row['endorsed_to'] . '</td>';
                                                echo '<td>' . $row['timestamp'] . '</td>';
                                                echo '</tr>';
                                            }

                                            echo '</table>';
                                        } else {
                                            echo '<p>No data found for the selected office.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLE STARTS -->
                <div class="table-search-container">
                    <div class="search-container position-relative d-flex justify-content-end">
                        <i class="bi bi-search"></i>
                        <input type="text" class="search" id="myInput" onkeyup="myTable()" placeholder="SEARCH"
                            title="Type">
                    </div>
                    <div class="table-container" style="max-height: 521px; overflow-y: scroll; overflow-x: auto;">
                        <?php

                        // Check if the selected office exists in the 'offices' table
                        if ($rowTableName) {
                            // FOR TABLE WITH _LOGS
                            $officeTableName = $rowTableName['officeName'];

                            // Fetch all columns excluding 'availability' and 'window'
                            $queryColumns = "SHOW COLUMNS FROM `$officeTableName`";
                            $resultColumns = mysqli_query($conn, $queryColumns);

                            // Extract column names excluding 'availability' and 'window'
                            $columnsToSelect = [];
                            while ($row = mysqli_fetch_assoc($resultColumns)) {
                                $columnName = $row['Field'];
                                if ($columnName !== 'id' && $columnName !== 'availability' && $columnName !== 'window') {
                                    $columnsToSelect[] = $columnName;
                                }
                            }

                            // Fetch all data for the selected office
                            $queryData = "SELECT " . implode(', ', $columnsToSelect) . " FROM `$officeTableName`";
                            $resultData = mysqli_query($conn, $queryData);

                            // Display the selected office information
                            echo '<table id="myTable" class="myTable" border="1">';

                            // Display header row
                            echo '<tr class="header fixed-header">';
                            echo '<th>Queue Number</th>';
                            echo '<th>Student ID</th>';
                            echo '<th>Transaction</th>';
                            echo '<th>Remarks</th>';
                            echo '<th>Status</th>';
                            echo '<th>Timestamp</th>';
                            echo '</tr>';

                            // Display data rows
                            while ($row = mysqli_fetch_assoc($resultData)) {
                                echo '<tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#queueModal">';
                                echo '<td>' . $row['queue_number'] . '</td>';
                                echo '<td>' . $row['student_id'] . '</td>';
                                echo '<td>' . $row['transaction'] . '</td>';
                                echo '<td>' . $row['remarks'] . '</td>';
                                echo '<td>' . $row['status'] . '</td>';
                                echo '<td>' . $row['timestamp'] . '</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                        } else {
                            echo '<p>No data found for the selected office.</p>';
                        }
                        ?>
                    </div>
                </div>
                <!-- TABLE ENDS -->

                <div class="modal fade" id="queueModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog  modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    QUEUE NUMBER DETAILS
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-search-container">
                                    <div class="search-container position-relative d-flex justify-content-end">

                                    </div>
                                    <div class="table-container"
                                        style="height: 400px; overflow-y: scroll; overflow-x: auto;">
                                        <!-- TABLE STARTS -->
                                        <div class="table-search-container">
                                            <div class="table-container"
                                                style="max-height: 521px; overflow-y: scroll; overflow-x: auto;">
                                            </div>
                                        </div>
                                        <!-- TABLE ENDS -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../script/offices.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="chart.js"></script>
        <script src="../script/script.js"></script>
        <script>
        // Function to handle row click
        function handleRowClick(queueNumber, timestamp) {
            // Use AJAX to fetch data for the specific queue number
            $.ajax({
                type: 'POST',
                url: 'queue_details.php', // Replace with the actual path to your PHP script
                data: { queueNumber: queueNumber,
                        timestamp: timestamp
                 },
                success: function (response) {
                    // Update modal content with the fetched data
                    $('#queueModal .modal-body').html(response);
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Add click event listener to rows with class 'clickable-row'
        document.addEventListener("DOMContentLoaded", function () {
            var rows = document.querySelectorAll('.clickable-row');

            rows.forEach(function (row) {
                row.addEventListener('click', function () {
                    var queueNumber = row.cells[0].innerText; // Assuming queue_number is in the first column
                    var timestamp = row.cells[5].innerText; // Assuming timestamp is in the fourth column
                    handleRowClick(queueNumber, timestamp);
                });
            });
        });
    </script>
</body>

</html>