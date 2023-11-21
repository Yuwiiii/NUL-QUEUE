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
    <title>SADMIN DASHBOARD</title>
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
                selectOffice = document.querySelector('#officeSelect');
                officeout = selectOffice.value;
                document.querySelector('.officeout').textContent = officeout;


                var e = document.getElementById("monthSelect");
                monthout = e.options[e.selectedIndex].text;
                document.querySelector('.monthout').textContent = monthout;

                $("#monthSelect").on("change", function () {

                    var e = document.getElementById("monthSelect");
                    monthout = e.options[e.selectedIndex].text;
                    document.querySelector('.monthout').textContent = monthout;

                });

                $("#officeSelect").on("change", function () {

                    selectOffice = document.querySelector('#officeSelect');
                    officeout = selectOffice.value;
                    document.querySelector('.officeout').textContent = officeout;


                    // Get selected month and office values
                    var selectedMonth = $("#monthSelect").val();
                    var selectedOffice = $("#officeSelect").val();


                    // Perform an AJAX request to retrieve updated data
                    $.ajax({
                        type: "POST",
                        url: "update_chart.php", // Replace with the URL of your PHP script
                        data: {
                            month: selectedMonth,
                            office: selectedOffice
                        },
                        success: function (datas) {
                            // Update the content div with the updated data
                            const newData = JSON.parse(datas);
                            myChart.data.datasets[0].data = newData;
                            myChart.update();
                            console.log(datas);

                        }
                    });
                });

                $("#monthSelect").on("change", function () {
                    // Get selected month and office values
                    var selectedMonth = $("#monthSelect").val();
                    var selectedOffice = $("#officeSelect").val();

                    // Perform an AJAX request to retrieve updated data
                    $.ajax({
                        type: "POST",
                        url: "update_chart.php", // Replace with the URL of your PHP script
                        data: {
                            month: selectedMonth,
                            office: selectedOffice
                        },
                        success: function (data) {
                            // Update the content div with the updated data
                            const newData = JSON.parse(data);
                            myChart.data.datasets[0].data = newData;
                            myChart.update();
                            console.log(data);

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
                    <select class="form-select-sm" id="officeSelect" aria-label="Default select example">
                        <option value="ALL-OFFICES">All Offices</option>
                        <option selected value="ADMISSION">Admission</option>
                        <option value="REGISTRAR">Registrar</option>
                        <option value="ACCOUNTING">Accounting</option>
                        <option value="ACADEMICS">Academics</option>
                        <option value="CLINIC">Clinic</option>
                        <option value="ASSETS">Assets</option>
                        <option value="ITRO">ITRO</option>
                        <option value="GUIDANCE">Guidance</option>
                    </select>
                    <select class="form-select-sm" id="monthSelect" aria-label="Default select example">
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

                    <button id="btn-print-this" class="btn btn-success btn-sm"> Print
                    </button>

                </div>


                <div id="content">

                    <div class="row justify-content-center mt-5" style="height:35vh; width:auto;">
                        <span class="officeout text-center fs-5 fw-bold nu_color"></span>
                        <span class="monthout text-center fs-5 fw-bold nu_color"></span>




                        <canvas class="align-items-center" id="myChartBar"></canvas>
                        <canvas class="align-items-center" id="myLineChart"></canvas>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        <script>

                            const ctx1 = document.getElementById('myLineChart');

                            new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: ['ADMISSION', 'REGISTRAR', 'ACCOUNTING', 'ACADEMICS', 'OTHER OFFICES'],
                                    datasets: [{
                                        label: 'Time',
                                        data: [12, 19, 3, 5, 2],
                                        borderColor: "#3EDAD8",
                                        backgroundColor: ["#3EDAD8", "#3EDAD8", "#2D8BBA", "#2F5F98", "#2C92D5"],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'SERVING TIME ',
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
                                            text: 'CUSTOMERS PER WEEK',
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