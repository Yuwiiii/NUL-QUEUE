<?php
include '../database.php';
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
                    ALL OFFICES
                </h4>
                <hr>

                <!-- TABLE STARTS -->
                <div class="table-search-container">
                    <div class="search-container position-relative d-flex justify-content-end">
                        <i class="bi bi-search"></i>
                        <input type="text" class="search" id="myInput" onkeyup="myTable()" placeholder="SEARCH"
                            title="Type">
                    </div>
                    <div class="table-container" style="max-height: 620px; overflow-y: scroll; overflow-x: auto;">
                        <?php

                        $query = "     SELECT
                        queue_number,
                        MAX(student_id) AS student_id,
                        office,
                        MAX(timestamp) AS timestamp
                    FROM
                        queue_logs
                    GROUP BY
                        queue_number,
                        DATE(timestamp)
                    ORDER BY
                    DATE(timestamp) DESC,
                    TIME(timestamp) DESC;
                        ";


                        $result = mysqli_query($conn, $query);

                        // Display the selected office information
                        echo '<table id="myTable" class="myTable" border="1">';

                        // Display header row
                        echo '<tr class="header fixed-header">';
                        echo '<th>Queue Number</th>';
                        echo '<th>Student ID</th>';
                        echo '<th>Office</th>';
                        echo '<th>Timestamp</th>';
                        echo '</tr>';

                        // Display data rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#queueModal">';
                            echo '<td>' . $row['queue_number'] . '</td>';
                            echo '<td>' . $row['student_id'] . '</td>';
                            echo '<td>' . $row['office'] . '</td>';
                            echo '<td>' . $row['timestamp'] . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                        ?>
                    </div>
                </div>
                <!-- TABLE ENDS -->

                <div class="modal fade" id="queueModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script/offices.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart.js"></script>
    <script src="../script/script.js"></script>
    <!-- Inside the <script> tag at the end of your file -->
    <script>
        // Function to handle row click
        function handleRowClick(queueNumber, timestamp) {
            // Use AJAX to fetch data for the specific queue number
            $.ajax({
                type: 'POST',
                url: 'queue_details.php', // Replace with the actual path to your PHP script
                data: {
                    queueNumber: queueNumber,
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
                    var timestamp = row.cells[3].innerText; // Assuming timestamp is in the fourth column
                    handleRowClick(queueNumber, timestamp);
                });
            });
        });
    </script>


</body>

</html>