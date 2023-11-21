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
    <link rel="stylesheet" href="offices.css">
</head>

<body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script/script.js"></script>

    <div class="container-fluid">
        <div class="row">

            <?php include 'aside.php'; ?>

            <div class="col-9 offset-3">

                <h4 class="fs-2 pt-5 ps-5 pb-2 nu_color text-start">DASHBOARD</h4>
                <hr>

                <div class="row justify-content-center">
                    <div class="col-sm-3 mb-3" style="width: 18rem;">
                        <div class="card card-db">
                            <div class="card-body gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="#FFD41C"
                                    class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h2 class="mt-2 me-5  fw-bold nu_color float-end" id="customer-count">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
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
                                <h2 class="mt-2 me-5 fw-bold nu_color float-end" id="completed-count">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
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

                                <h2 class="mt-2 me-5 fw-bold nu_color float-end" id="pending-count">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </h2>
                                <p class="fs-5 mt-n4 nu_color float-end">PENDING</p>

                            </div>
                        </div>
                    </div>


                    
                    <!-- <div class="col-sm-3 mb-3" style="width: 14rem;">
                        <div class="card card-db">
                            <div class="card-body gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#FFD41C"
                                    class="bi bi-ticket-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13Z" />
                                </svg>

                                <h2 class="mt-0 me-4 fw-bold nu_color float-end" id="accounts-count">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </h2>
                                <p class="fs-6 mt-0 nu_color float-end" style="margin-bottom: -.5rem">ACCOUNTS</p>

                            </div>
                        </div>
                    </div> -->


                </div>



                <div class="row justify-content-center mt-5" style="height:40vh; width:auto;">

                    <?php
                    $query = $conn->query("SELECT office, COUNT(*) AS office_count
                FROM queue
                GROUP BY office
                HAVING office_count > 1;");

                    foreach ($query as $data) {
                        $office[] = $data['office'];
                        $count[] = $data['office_count'];
                    }
                    ?>
                    <canvas class="align-items-center" id="myChartBar"></canvas>
                    <canvas class="align-items-center" id="myChartPie"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>

                        const ctx1 = document.getElementById('myChartPie');

                        new Chart(ctx1, {
                            type: 'pie',
                            data: {
                                labels: <?php echo json_encode($office) ?>,
                                datasets: [{
                                    label: '# of Customers',
                                    data: <?php echo json_encode($count) ?>,
                                    backgroundColor: ["#3EDAD8", "#3EDAD8", "#2D8BBA", "#2F5F98", "#2C92D5"],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'CURRENT NUMBER OF CUSTOMERS PER OFFICE',
                                    }
                                }
                            }
                        });

                        const ctx2 = document.getElementById('myChartBar');

                        new Chart(ctx2, {
                            type: 'bar',
                            data: {
                                labels: ['ADMISSION', 'REGISTRAR', 'ACCOUNTING', 'ACADEMICS', 'OTHER OFFICES'],
                                datasets: [{
                                    label: 'Transaction Time',
                                    data: [12, 19, 3, 5, 2],
                                    backgroundColor: ["#34418E"],
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'AVERAGE TRANSACTION TIME PER OFFICE',
                                    }
                                }
                            }

                        });
                    </script>

                </div>

            </div>
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart.js"></script> -->

</body>


</html>