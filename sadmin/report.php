<?php
@include '../database.php';
session_start();

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTS</title>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script/script.js"></script>


    <div class="container-fluid">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>



            $(document).ready(function () {

                $('#btn-empty-queue').click(function () {
                    if (confirm('Are you sure you want to empty the queue?')) {
                        $.ajax({
                            url: 'empty-queue.php',
                            method: 'POST',
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    alert('Queue emptied successfully!');
                                    location.reload();
                                } else {
                                    alert('Error emptying queue: ' + response.error);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX request failed with status ' + status + ': ' + error);
                            }
                        });
                    }
                });


                document.getElementById('btn-empty-queue').addEventListener('click', function (e) {
                    e.preventDefault(); // Prevent the form from being submitted
                });

                document.getElementById('btn-print-this').addEventListener('click', function (e) {
                    e.preventDefault(); // Prevent the form from being submitted
                });

                selectOffice = document.querySelector('#officeSelect');
                officeout = selectOffice.value;
                document.querySelector('.officeout').textContent = officeout;


                var e = document.getElementById("monthSelectStart");
                monthout = e.options[e.selectedIndex].text;
                document.querySelector('.monthout').textContent = monthout;

                selectYear = document.querySelector('#yearSelect');
                yearout = selectYear.value;
                document.querySelector('.yearout').textContent = yearout;

                $("#monthSelectStart").on("change", function () {

                    var e = document.getElementById("monthSelectStart");
                    monthout = e.options[e.selectedIndex].text;
                    document.querySelector('.monthout').textContent = monthout;

                });

                $("#monthSelectEnd").on("change", function () {

                    var e = document.getElementById("monthSelectEnd");
                    monthoutend = 'to ' + e.options[e.selectedIndex].text;
                    document.querySelector('.monthoutend').textContent = monthoutend;

                });

                $("#yearSelect").on("change", function () {

                    var e = document.getElementById("yearSelect");
                    yearout = ' ' + e.options[e.selectedIndex].text;
                    document.querySelector('.yearout').textContent = yearout;

                });

                $("#monthSelectStart, #monthSelectEnd, #yearSelect, #officeSelect").on("change", function () {
                    // Get selected month and office values
                    var selectedMonthStart = $("#monthSelectStart").val();
                    var selectedMonthEnd = $("#monthSelectEnd").val();
                    var selectedOffice = $("#officeSelect").val();
                    var selectedYear = $("#yearSelect").val();

                    // Perform an AJAX request to retrieve updated data
                    $.ajax({
                        type: "POST",
                        url: "update_chart.php",
                        data: {
                            monthstart: selectedMonthStart,
                            monthend: selectedMonthEnd,
                            office: selectedOffice,
                            year: selectedYear
                        },
                        success: function (response) {
                            // Update the content div with the updated data
                            const newData = JSON.parse(response);
                            myChart.data.datasets[0].data = newData.customer;
                            myChart.data.labels = newData.week;
                            myChart.update();
                            console.log(newData.customer);
                        }
                    });

                    // Perform an AJAX request to retrieve updated data
                    $.ajax({
                        type: "POST",
                        url: "update_chart_time.php",
                        data: {
                            monthstart: selectedMonthStart,
                            monthend: selectedMonthEnd,
                            office: selectedOffice,
                            year: selectedYear
                        },
                        success: function (response) {
                            // Update the content div with the updated data
                            const newData = JSON.parse(response);
                            myChartLine.data.datasets[0].data = newData.averageTime;
                            myChartLine.data.labels = newData.weekDateRangeAvgTime;
                            myChartLine.update();
                            console.log(newData.averageTime);
                        }
                    });
                });


            });
        </script>


        <div class="row">


            <?php include 'aside.php'; ?>

            <div class="col-9 offset-3">

                <h4 class="fs-2 pt-5 ps-5 pb-2 nu_color text-start">REPORT</h4>
                <hr>

                <h4 class="fs-2 pt-3 ps-5 pb-2 nu_color text-center"> Please select an office to generate a report </h4>

                <div class="text-center">
                    <form action="export.php" method="post">
                        <select class="form-select-sm" name="officeSelect" id="officeSelect"
                            aria-label="Default select example">
                            <?php
                            @include 'database.php';
                            $sql = "SELECT * FROM offices";
                            $result = $conn->query($sql);
                            ?>
                            <option value="ALL-OFFICES">All Offices</option>

                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $officeName = $row["officeName"];
                                    echo '<option value="' . $officeName . '">' . $officeName . '</option>';
                                }
                            } else {
                                echo '<option value="">No offices available</option>';
                            }
                            ?>
                        </select>
                        <select class="form-select-sm" name="monthSelectStart" id="monthSelectStart"
                            aria-label="Default select example">
                            <option selected value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>

                        -

                        <select class="form-select-sm" name="monthSelectEnd" id="monthSelectEnd"
                            aria-label="Default select example">
                            <option selected value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>

                        <select class="form-select-sm" name="yearSelect" id="yearSelect"
                            aria-label="Default select example">
                            <option selected value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>

                        <button id="btn-print-this" class="btn btn-success btn-sm"> Print
                        </button>
                        <input type="submit" value="Export CSV">
                        <button id="btn-empty-queue" class="btn btn-danger btn-sm"> Empty Queue</button>
                    </form>


                </div>


                <div id="content">

                    <div class="row justify-content-center mt-5" style="height:35vh; width:auto;">
                        <span class="officeout text-center fs-5 fw-bold nu_color"></span>
                        <div style="display: inline-block;" class="text-center">
                            <span class="monthout text-center fs-5 fw-bold nu_color"></span>
                            <span class="monthoutend text-center fs-5 fw-bold nu_color"></span>
                            <span class="yearout text-center fs-5 fw-bold nu_color"></span>
                        </div>



                        <canvas class="align-items-center" id="myChartBar"></canvas>
                        <canvas class="align-items-center" id="myLineChart"></canvas>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        <script>

                            const ctx1 = document.getElementById('myLineChart');

                            const myChartLine = new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: ["WEEK 1", "WEEK 2", "WEEK 3", "WEEK 4"],
                                    datasets: [{
                                        label: 'Time',
                                        data: ["0", "0", "0", "0"],
                                        borderColor: "#3EDAD8",
                                        backgroundColor: ["#3EDAD8", "#3EDAD8", "#2D8BBA", "#2F5F98", "#2C92D5"],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'AVERAGE SERVING TIME',
                                        }
                                    }
                                }
                            });

                            const ctx2 = document.getElementById('myChartBar');

                            const myChart = new Chart(ctx2, {
                                type: 'bar',
                                data: {
                                    labels: ["WEEK 1", "WEEK 2", "WEEK 3", "WEEK 4"],
                                    datasets: [{
                                        label: 'Customers',
                                        data: ["0", "0", "0", "0"],
                                        backgroundColor: ["#34418E"],
                                        borderWidth: 0
                                    }]
                                },
                                options: {
                                    indexAxis: 'y',
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'AVERAGE CUSTOMERS',
                                        }
                                    }
                                }

                            });




                        </script>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    </div>

                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="chart.js"></script>
            <script src="../script/printThis.js"></script>
            <script src="../script/custom.js"></script>
        </div>
</body>


</html>