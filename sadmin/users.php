<?php
@include '../database.php';
session_start();

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit();
}

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the office name and acronym from the form
    $officeName = $_POST["officeName"];
    $acronym = strtoupper($_POST["acronym"]);
    $otherOffices = isset($_POST["otherOffices"]) ? 1 : 0;

    // Create a sanitized table name from the office name
    $tableName = preg_replace("/[^a-zA-Z0-9_]/", "", $officeName);

    // SQL to check if table exists
    $checkTableExistsSQL = "SHOW TABLES LIKE '$tableName'";
    $result = $conn->query($checkTableExistsSQL);

    if ($result->num_rows > 0) {
        echo '<script>alert("Table ' . $tableName . ' already exists");</script>';
    } else {
        // SQL to create table without acronym
        $sql = "CREATE TABLE $tableName (
            `id` int(11) NOT NULL,
            `queue_number` varchar(255) NOT NULL,
            `student_id` varchar(12) NOT NULL,
            `endorsed_from` varchar(255) DEFAULT NULL,
            `timein` timestamp NOT NULL DEFAULT current_timestamp(),
            `timeout` timestamp NULL DEFAULT NULL,
            `remarks` int(11) DEFAULT NULL,
            `transaction` varchar(255) DEFAULT NULL,
            `status` int(11) DEFAULT NULL
        )";

        if ($conn->query($sql) === TRUE) {
            // Insert the office details into the existing "offices" table with otherOffices value
            $insertOfficeSQL = "INSERT INTO offices (acronym, officeName, office) VALUES ('$acronym', '$officeName', '$otherOffices')";
            if ($conn->query($insertOfficeSQL) === TRUE) {
                echo '<script>alert("Table ' . $tableName . ' created successfully, and office details added to offices table");</script>';
            } else {
                echo '<script>alert("Error inserting office details: ' . $conn->error . '");</script>';
            }
        } else {
            echo '<script>alert("Error creating table: ' . $conn->error . '");</script>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS</title>
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

                <h4 class="fs-2 pt-5 ps-5 pb-2 nu_color text-start">USERS</h4>
                <hr>

                <div class="row no-gutters g-0 text-center">
                    <div class="col-sm-5 col-md-7">
                        <div class="col-sm-3 mb-3" style="width: 14rem;">
                            <div class="card card-db">
                                <div class="card-body gap-3 py-2">
                                    <div class="d-flex gap-4 align-items-center justify-content-center py-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#FFD41C"
                                            class="bi bi-ticket-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13Z" />
                                        </svg>

                                        <div class="align-items-center justify-content-center">
                                            <h2 class="my-0 me-4 fs-2 fw-bold nu_color px-auto mx-auto"
                                                id="accounts-count">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </h2>
                                            <p class="fs-5 mt-0 nu_color">ACCOUNTS</p>
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
                            <input name="searchUser" class="search mb-0 rounded" type="search" placeholder="SEARCH"
                                aria-label="Search" required value="<?php if (isset($_GET['searchUser'])) {
                                    echo $_GET['searchUser'];
                                } ?>" id="searchUserInput">
                        </form>
                    </div>
                    <div class="col-1 col-md-2 align-self-end justify-content-start mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addUser"
                            class="btn btn-green btn-lg my-2 my-sm-0 mx-2" type="submit">ADD USER</a>
                    </div>

                </div>

                <div class="row g-0 text-center">
                    <table class="table-bordered text-center border-black">
                        <thead>
                            <tr class="background-blue">
                                <!-- <th scope="col">ID</th> -->
                                <th scope="col">Full Name</th>
                                <th scope="col">Office</th>
                                <th scope="col">Window</th>
                                <th scope="col">Username</th>
                                <!-- <th scope="col">Password</th> -->
                                <!-- <th scope="col">Role</th> -->
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

                                if (isset($_GET['searchUser'])) {
                                    $filtervalues = $_GET['searchUser'];
                                    $query = "SELECT * FROM user_accounts WHERE CONCAT(full_name,office,username) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $items) {
                                            // Output data for search results
                                            echo "<tr>";
                                            //echo "<td>" . $items['ID'] . "</td>";
                                            echo "<td>" . $items['full_name'] . "</td>";
                                            echo "<td>" . $items['office'] . "</td>";
                                            echo "<td>" . $items['window'] . "</td>";
                                            echo "<td>" . $items['username'] . "</td>";
                                            // echo "<td>" . $items['password'] . "</td>";
                                            echo "<td><button class='btn btn-edit my-2 my-sm-0 mx-2 edit-button' onclick='openEditUserModal(" . $items['ID'] . ", \"" . $items['full_name'] . "\", \"" . $items['office'] . "\", \"" . $items['window'] . "\", \"" . $items['username'] . "\" , \"" . $items['password'] . "\")'>Edit</button>";
                                            echo "<button class='btn btn-red my-2 my-sm-0 mx-2' type='button' onclick='deleteUser(" . $items['ID'] . ")'>Delete</button>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No matching records found</td></tr>";
                                    }
                                } else {
                                    // Retrieve data from the "user_accounts" table when the search bar is empty
                                    $sql = "SELECT * FROM user_accounts LIMIT $start_from, $results_per_page";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Output data for all records
                                        echo "<tr>";
                                        //echo "<td>" . $row['ID'] . "</td>";
                                        echo "<td>" . $row['full_name'] . "</td>";
                                        echo "<td>" . $row['office'] . "</td>";
                                        echo "<td>" . $row['window'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        //echo "<td>" . $row['password'] . "</td>";
                                        // echo "<td>" . $row['role'] . "</td>";
                                        echo "<td><button class='btn btn-edit my-2 my-sm-0 mx-2 edit-button' onclick='openEditUserModal(" . $row['ID'] . ", \"" . $row['full_name'] . "\", \"" . $row['office'] . "\", \"" . $row['window'] . "\", \"" . $row['username'] . "\" , \"" . $row['password'] . "\")'>Edit</button>";
                                        // echo "<button class='btn btn-red my-2 my-sm-0 mx-2' type='button' onclick='deleteUser(" . $row['ID'] . ")'>Delete</button>";
                                        echo "<button class='btn btn-red my-2 my-sm-0 mx-2' type='button' onclick='deleteUser(" . $row['ID'] . ")'>Delete</button>";
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
                        $sql = "SELECT COUNT(*) AS total FROM user_accounts";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $total_pages = ceil($row["total"] / $results_per_page);

                        echo "<span class='page-label1'>PAGE</span>";
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<a href='users.php?page=$i'";
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

    <!-- Modal OFFICE NOTIFY STARTS -->
    <div id="myModal" class="modal">
        <div id="myModalContent">
            <span id="closeModal" onclick="closeModal()">&times;</span>
            <h1>
                <?php echo $modalTitle; ?>
            </h1>
            <p>
                <?php echo $modalMessage; ?>
            </p>
        </div>
    </div>
    <!-- Modal OFFICE NOTIFY ENDS -->

    <!-- add user modal -->
    <div class="modal fade " id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-block border-0 pb-0">
                    <h1 class="modal-title fs-3 text-center custom-bold custom-secondary-color" id="modalTitle2">
                        ADD USER</h1>
                    <p class="modal-secondary fs-4 fst-italic fw-bold text-center custom-primary-color p-0 m-0">
                        Fill out the details for adding a user.</p>
                </div>
                <form id="addUserForm" action="addUsers.php" method="post" onsubmit="return validateForm();">
                    <div class="modal-body pb-0  my-3">
                        <label for="full_name" class="text-start">Full Name</label>
                        <input type="text" id="full_name" name="full_name"
                            class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                        <p class="text-danger" id="error_full_name" style="display: none;">Please enter full name</p>

                        <div class="row">
                            <div class="col">
                                <label for="office" class="text-start">Office</label>
                                <?php
                                @include 'database.php';
                                $sql = "SELECT acronym, officeName FROM offices";
                                $result = $conn->query($sql);
                                ?>
                                <select id="office" name="office"
                                    class="h5 form-select text-start selectpicker rounded border-1 mb-2 border-dark font-weight-bold"
                                    aria-label="Default select example" onchange="checkAcademics()">
                                    <!-- <option value=""></option>
                                    <option value="ADMISSION">Admission</option>
                                    <option value="REGISTRAR">Registrar</option>
                                    <option value="ACCOUNTING">Accounting</option>
                                    <option value="SCS">School of Computer Studies</option>
                                    <option value="SEA">School of Engineering and Architecture</option>
                                    <option value="SAS">School of Arts and Sciences</option>
                                    <option value="SABM">School of Accountancy, Business, and Management</option>
                                    <option value="SHS">Senior High School</option>
                                    <option value="CLINIC">Clinic</option>
                                    <option value="ASSETS">Assets</option>
                                    <option value="ITRO">ITRO</option>
                                    <option value="GUIDANCE">Guidance</option> -->
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $acronym = $row["acronym"];
                                            $officeName = $row["officeName"];
                                            echo '<option value="' . $officeName . '">' . $officeName . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No colleges available</option>';
                                    }
                                    ?>
                                </select>
                                <p class="text-danger" id="error-office" style="display: none;">Please select an office
                                </p>
                            </div>
                        </div>


                        <!-- New select option for ACADEMICS -->
                        <div id="academicsSelectOption" style="display: none;">
                            <div class="row">
                                <div class="col">
                                    <label for="academicDepartment" class="text-start">Academic Department</label>
                                    <?php
                                    @include 'database.php';
                                    $sql = "SELECT acronym, collegeName FROM colleges";
                                    $result = $conn->query($sql);
                                    ?>
                                    <select id="academicDepartment" name="academicDepartment"
                                        class="h5 form-select text-start selectpicker rounded border-1 mb-2 border-dark font-weight-bold"
                                        aria-label="Default select example">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $acronym = $row["acronym"];
                                                $collegeName = $row["collegeName"];
                                                echo '<option value="' . $acronym . '">' . $collegeName . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No colleges available</option>';
                                        }
                                        ?>
                                    </select>
                                    <p class="text-danger" id="error-academicDepartment" style="display: none;">Please
                                        select an academic department</p>
                                </div>
                            </div>
                        </div>

                        <div id="addcourseview" style="display: none;">
                            <label for="full_name" class="text-start">Course</label>
                            <input type="text" id="addcourse" name="addcourse"
                                class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="window" class="text-start">Window</label>
                                <select id="selectWindow" name="selectWindow"
                                    class="h5 form-select text-start selectpicker rounded border-1 mb-2 border-dark font-weight-bold"
                                    aria-label="Default select example">
                                    <option value=""></option>
                                    <option value="1">Window 1</option>
                                    <option value="2">Window 2</option>
                                    <option value="3">Window 3</option>
                                    <option value="4">Window 4</option>
                                    <option value="5">Window 5</option>
                                    <option value="6">Window 6</option>

                                </select>
                                <p class="text-danger" id="error-office" style="display: none;">Please select a window
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="username" class="text-start">username</label>
                                <input type="text"
                                    class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2"
                                    id="username" name="username">
                                <p class="text-danger" id="error-username" style="display: none;">Please enter username
                                </p>
                            </div>

                            <div class="col">
                                <label for="password" class="text-start">Password</label>
                                <input type="password"
                                    class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2"
                                    id="addpassword" name="password">
                                <p class="text-danger" id="error-password" style="display: none;">Please enter password
                                </p>
                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="showaddPasswordCheckbox"
                                        onchange="toggleaddPasswordVisibility()">
                                    <label class="form-check-label float-start" for="showaddPasswordCheckbox">Show
                                        password</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end border-0 col">
                        <button type="button" class="btn btn-white px-4 " data-bs-dismiss="modal">CANCEL</button>
                        <input type="submit" class="btn btn-green px-4" onclick="confirmAddUser()" id="addUserGo"
                            value="ADD USER">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!--edit modal-->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-block border-0 pb-0">
                    <h1 class="modal-title fs-3 text-center custom-bold custom-secondary-color" id="modalTitle2">
                        EDIT USER</h1>
                    <p class="modal-secondary fs-4 fst-italic fw-bold text-center custom-primary-color p-0 m-0">
                        Edit the user details.</p>
                </div>
                <form id="editUserForm" action="editUsers.php" method="post">
                    <div class="modal-body pb-0  my-3">
                        <input type="hidden" id="ID" name="ID">
                        <label for="editFullName" class="text-start">Full Name</label>
                        <input type="text" id="full_name" name="full_name"
                            class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                        <p class="text-danger" id="error_editFullName" style="display: none;">Please enter full name</p>

                        <div class="row">
                            <div class="col">
                                <label for="office" class="text-start">Office</label>
                                <?php
                                @include 'database.php';
                                $sql = "SELECT acronym, officeName FROM offices";
                                $result = $conn->query($sql);
                                ?>
                                <select id="editoffice" name="office"
                                    class="h5 form-select text-start selectpicker rounded border-1 mb-2 border-dark font-weight-bold"
                                    aria-label="Default select example" onchange="editcheckAcademics()">


                                    <!-- <option value="ADMISSION">Admission</option>
                                    <option value="REGISTRAR">Registrar</option>
                                    <option value="ACCOUNTING">Accounting</option>
                                    <option value="SCS">School of Computer Studies</option>
                                    <option value="SEA">School of Engineering and Architecture</option>
                                    <option value="SAS">School of Arts and Sciences</option>
                                    <option value="SABM">School of Accountanc, Business, and Management</option>
                                    <option value="SHS">Senior High School</option>
                                    <option value="CLINIC">Clinic</option>
                                    <option value="ASSETS">Assets</option>
                                    <option value="ITRO">ITRO</option>
                                    <option value="GUIDANCE">Guidance</option> -->

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $acronym = $row["acronym"];
                                            $officeName = $row["officeName"];
                                            echo '<option value="' . $officeName . '">' . $officeName . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No colleges available</option>';
                                    }
                                    ?>
                                </select>
                                <p class="text-danger" id="error-editOffice" style="display: none;">Please select an
                                    office</p>
                            </div>
                        </div>

                        <!-- New select option for ACADEMICS -->
                        <div id="editacademicsSelectOption" style="display: none;">
                            <div class="row">
                                <div class="col">
                                    <label for="academicDepartment" class="text-start">Academic Department</label>
                                    <?php
                                    @include 'database.php';
                                    $sql = "SELECT acronym, collegeName FROM colleges";
                                    $result = $conn->query($sql);
                                    ?>
                                    <select id="editacademicDepartment" name="editacademicDepartment"
                                        class="h5 form-select text-start selectpicker rounded border-1 mb-2 border-dark font-weight-bold"
                                        aria-label="Default select example">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $acronym = $row["acronym"];
                                                $collegeName = $row["collegeName"];
                                                echo '<option value="' . $acronym . '">' . $collegeName . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No colleges available</option>';
                                        }
                                        ?>
                                    </select>
                                    <p class="text-danger" id="error-academicDepartment" style="display: none;">Please
                                        select an academic department</p>
                                </div>
                            </div>
                        </div>

                        <div id="editcourseview" style="display: none;">
                            <label for="full_name" class="text-start">Course</label>
                            <input type="text" id="editcourse" name="editcourse"
                                class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2">
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="window" class="text-start">Window</label>
                                <select id="selectWindow" name="selectWindow"
                                    class="h5 form-select text-start selectpicker rounded border-1 mb-2 border-dark font-weight-bold"
                                    aria-label="Default select example">
                                    <option value=""></option>
                                    <option value="1">Window 1</option>
                                    <option value="2">Window 2</option>
                                    <option value="3">Window 3</option>
                                    <option value="4">Window 4</option>
                                    <option value="5">Window 5</option>
                                    <option value="6">Window 6</option>

                                </select>
                                <p class="text-danger" id="error-window" style="display: none;">Please select a window
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="username" class="text-start">Username</label>
                                <input type="text"
                                    class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2"
                                    id="username" name="username">
                                <p class="text-danger" id="error-editUsername" style="display: none;">Please enter
                                    username</p>
                            </div>

                            <div class="col">
                                <label for="password" class="text-start">Password</label>
                                <input type="password"
                                    class="form-control text-start rounded border-1 border-dark custom-primary-color font-weight-bold mb-2"
                                    id="password" name="password">
                                <p class="text-danger" id="error-editPassword" style="display: none;">Please enter
                                    password</p>
                                    <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="showPasswordCheckbox"
                                        onchange="togglePasswordVisibility()">
                                    <label class="form-check-label float-start" for="showPasswordCheckbox">Show
                                        password</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-end border-0 col">
                        <button type="button" class="btn btn-white px-4" data-bs-dismiss="modal">CANCEL</button>
                        <input type="submit" class="btn btn-green px-4" name="edit_user" value="SAVE CHANGES">
                    </div>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../script/script.js"></script>
        <script src="../script/offices.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="/chart.js"></script>
        <script src="../script/users.js"></script>
</body>
<script>
    function checkAcademics() {
        var officeSelect = document.getElementById('office');
        var academicsSelectOption = document.getElementById('academicsSelectOption');
        var form = document.getElementById('addUserForm');

        if (officeSelect.value === 'ACADEMICS') {

            form.action = 'addprogramchair.php';
            academicsSelectOption.style.display = 'block';
        } else {

            form.action = 'addUsers.php';
            academicsSelectOption.style.display = 'none';
        }
    }

    function editcheckAcademics() {
        var officeSelect = document.getElementById('editoffice');
        var academicsSelectOption = document.getElementById('editacademicsSelectOption');
        var form = document.getElementById('editUserForm');

        if (officeSelect.value === 'ACADEMICS') {

            form.action = 'editprogramchair.php';
            academicsSelectOption.style.display = 'block';
        } else {

            form.action = 'editUsers.php';
            academicsSelectOption.style.display = 'none';
        }
    }


    document.getElementById('office').addEventListener('change', function () {
        var academicsSelectOption = document.getElementById('academicsSelectOption');
        var academicsCourseOption = document.getElementById('addcourseview');
        if (this.value === 'ACADEMICS') {
            academicsSelectOption.style.display = 'block';
            academicsCourseOption.style.display = 'block';
        } else {
            academicsSelectOption.style.display = 'none';
            academicsCourseOption.style.display = 'none';
        }
    });

    document.getElementById('editoffice').addEventListener('change', function () {
        var academicsSelectOption = document.getElementById('editacademicsSelectOption');
        var academicsCourseOption = document.getElementById('editcourseview');
        if (this.value === 'ACADEMICS') {
            academicsSelectOption.style.display = 'block';
            academicsCourseOption.style.display = 'block';
        } else {
            academicsSelectOption.style.display = 'none';
            academicsCourseOption.style.display = 'none';
        }
    });
</script>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var passwordCheckbox = document.getElementById("showPasswordCheckbox");

        if (passwordCheckbox.checked) {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }

    function toggleaddPasswordVisibility() {
        var passwordInput = document.getElementById("addpassword");
        var passwordCheckbox = document.getElementById("showaddPasswordCheckbox");

        if (passwordCheckbox.checked) {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
 
</script>

</html>
