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
    <title>COLLEGES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/index.css">

    <link rel="stylesheet" href="../styles/offices.css">
    <link rel="stylesheet" href="../styles/users.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'aside.php'; ?>
            <div class="col-9 offset-3">

                <h4 class="fs-2 pt-5 ps-5 pb-2 nu_color text-start">COLLEGES</h4>
                <hr>

                <div class="row no-gutters g-0 text-center">
                    <div class="col-sm-5 col-md-7">
                        <div class="col-sm-3 mb-3" style="width: 14rem;">
                            <div class="card card-db">
                                <div class="card-body gap-3 py-2">
                                    <div class="d-flex gap-4 align-items-center justify-content-center py-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#FFD41C"
                                            class="bi bi-building-fill-gear" viewBox="0 0 16 16">
                                            <path
                                                d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13Z" />
                                        </svg>

                                        <div class="align-items-center justify-content-center">
                                            <h2 class="my-0 me-4 fs-2 fw-bold nu_color px-auto mx-auto"
                                                id="colleges-count">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </h2>
                                            <p class="fs-5 mt-0 nu_color">COLLEGES</p>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div
                        class="col-6 col-md-3 align-self-end mb-3 search-container position-relative d-flex justify-content-end">
                        <form action="" method="get" class="py-0">
                            <i class="bi bi-search"></i>
                            <input name="searchCollege" class="search mb-0 rounded" type="search" placeholder="SEARCH"
                                aria-label="Search" required value="<?php if (isset($_GET['searchUser'])) {
                                    echo $_GET['searchUser'];
                                } ?>" id="searchUserInput">
                        </form>
                    </div>
                    <div class="col-1 col-md-2 align-self-end justify-content-start mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addCollege"
                            class="btn btn-green btn-lg my-2 my-sm-0 mx-2" type="submit">ADD COLLEGE</a>
                    </div>

                </div>

                <div class="row g-0 text-center">
                    <table class="table-bordered text-center border-black">
                        <thead>
                            <tr class="background-blue">
                                <!-- <th scope="col">ID</th> -->
                                <th scope="col">Acronym</th>
                                <th scope="col">College Name</th>
                                <th scope="col" class="col-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php

                                $results_per_page = 8;

                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = 1;
                                }

                                $start_from = ($page - 1) * $results_per_page;

                                if (isset($_GET['searchCollege'])) {
                                    $filtervalues = $_GET['searchCollege'];
                                    $query = "SELECT * FROM colleges WHERE CONCAT(acronym, collegeName) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $items) {
                                            // Output data for search results
                                            echo "<tr>";
                                            //echo "<td>" . $items['ID'] . "</td>";
                                            echo "<td>" . $items['acronym'] . "</td>";
                                            echo "<td>" . $items['collegeName'] . "</td>";
                                            echo "<td><button class='btn btn-edit my-2 my-sm-0 mx-2' type='submit'>Edit</button>";
                                            echo "<button class='btn btn-red my-2 my-sm-0 mx-2' type='submit'>Delete</button></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No matching records found</td></tr>";
                                    }
                                } else {
                                    // Retrieve data from the "user_accounts" table when the search bar is empty
                                    $sql = "SELECT * FROM colleges LIMIT $start_from, $results_per_page";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Output data for all records
                                        echo "<tr>";
                                        //echo "<td>" . $row['ID'] . "</td>";
                                        echo "<td>" . $row['acronym'] . "</td>";
                                        echo "<td>" . $row['collegeName'] . "</td>";
                                        echo "<td><button class='btn btn-edit my-2 my-sm-0 mx-2 edit-button' onclick='openEditCollegeModal(" . $row['ID'] . ", \"" . $row['acronym'] . "\", \"" . $row['collegeName'] . "\")'>Edit</button>";
                                        echo "<button class='btn btn-red my-2 my-sm-0 mx-2' type='button' onclick='deleteCollege(" . $row['ID'] . ")'>Delete</button>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container d-flex justify-content-between align-items-center">
                    <span class="page-label" style="align-self-end"></span>
                    <div class="pagination">
                        <?php
                        $sql = "SELECT COUNT(*) AS total FROM colleges";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $total_pages = ceil($row["total"] / $results_per_page);

                        echo "<span class='page-label1'>PAGE</span>";
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<a href='college.php?page=$i'";
                            if ($i == $page)
                                echo " class='active'";
                            echo ">$i</a>";
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- add college modal -->
    <div class="modal fade " id="addCollege" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-block border-0 pb-0">
                    <h1 class="modal-title fs-3 text-center custom-bold custom-secondary-color" id="modalTitle2">
                        ADD COLLEGE</h1>
                    <p class="modal-secondary fs-4 fst-italic fw-bold text-center custom-primary-color p-0 m-0">
                        Fill out the details for adding a College.</p>
                </div>
                <form action="addCollege.php" method="post" onsubmit="return validateForm();">
                    <div class="modal-body pb-0  my-3">
                        <label for="acronym" class="text-start">Acronym</label>
                        <input type="text" id="acronym" name="acronym"
                            class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                        <p class="text-danger" id="error_acronym" style="display: none;">Please enter Acronym for the
                            department</p>

                        <div class="row">
                            <div class="col">
                                <label for="collegeName" class="text-start"> College Name</label>
                                <input type="text" id="collegeName" name="collegeName"
                                    class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                                <p class="text-danger" id="error_collegeName" style="display: none;">Please enter
                                    college name
                                </p>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end border-0 col">
                        <button type="button" class="btn btn-white px-4 " data-bs-dismiss="modal">CANCEL</button>
                        <input type="submit" class="btn btn-green px-4" onclick="confirmAddCollege()" id="addCollegeGo"
                            value="ADD COLLEGE">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


    <!--edit modal-->
    <div class="modal fade" id="editCollegeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-block border-0 pb-0">
                    <h1 class="modal-title fs-3 text-center custom-bold custom-secondary-color" id="modalTitle2">
                        EDIT COLLEGE</h1>
                    <p class="modal-secondary fs-4 fst-italic fw-bold text-center custom-primary-color p-0 m-0">
                        Edit the college details.</p>
                </div>
                <form action="editCollege.php" method="post">
                    <div class="modal-body pb-0  my-3">
                        <input type="hidden" id="ID" name="ID">
                        <label for="acronym" class="text-start">Acronym</label>
                        <input type="text" id="acronym" name="acronym"
                            class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                        <p class="text-danger" id="error_acronym" style="display: none;">Please enter
                            Acronym</p>

                    <div class="row">
                        <div class="col">
                            <label for="collegeName" class="text-start">College Name</label>
                            <input type="text" id="collegeName" name="collegeName"
                                class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                            <p class="text-danger" id="error-collegeName" style="display: none;">Please enter College
                                Name</p>
                    </div>
            </div>
        </div>

        <div class="modal-footer d-flex justify-content-end border-0 col">
            <button type="button" class="btn btn-white px-4" data-bs-dismiss="modal">CANCEL</button>
            <input type="submit" class="btn btn-green px-4" name="edit_College" value="SAVE CHANGES">
        </div>
        </form>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script/script.js"></script>
    <script src="../script/offices.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/chart.js"></script>
    <script src="../script/college.js"></script>
</body>

</html>
