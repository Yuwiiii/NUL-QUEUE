<?php

@include '../database.php';
session_start();

if (isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, ($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `admin` WHERE email = '$email' AND password = '$password'") or die('query failed');

   if (mysqli_num_rows($select) > 0) {
      $row = mysqli_fetch_assoc($select);
      $_SESSION['email'] = $row['email'];
      header('location:dashboard.php');
   } else {
      $message[] = 'Incorrect email or password';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<script>
   function togglePasswordVisibility() {
      var passwordInput = document.getElementById("passwordInput");
      var passwordCheckbox = document.getElementById("showPasswordCheckbox");

      if (passwordCheckbox.checked) {
         passwordInput.type = "text";
      } else {
         passwordInput.type = "password";
      }
   }
</script>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SADMIN LOGIN</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>
   <link rel="stylesheet" type="text/css" href="../styles/index.css">
</head>

<body>

   <div class="container-fluid">
      <div class="row">
         <div class="rounded-end-5 col-4 blue-bg position-fixed">
            <img src="../assets/NU_shield.svg" alt="Image" class="img-fluid img_logo"
               style="max-height: auto; max-width: 40%;">
            <div class="mt-4">
               <h1 class="fw-bolder text-light text-center">NU LAGUNA</h1>
               <h4 class="fw-bold text-light text-center">QUEUING SYSTEM</h4>
            </div>

         </div>
         <div class="col-8 p-5 offset-4 align-center-form">
            <div class="d-flex justify-content-center flex-wrap">
               <div class="text-center row mt-5 mx-2" style="margin-bottom: 10rem;">

                  <!-- Large Screens -->
                  <div class="d-none d-lg-block ">
                     <div class="card p-4 px-5" style="min-width: 40rem;">
                        <form action="index.php" method="post">
                           <h2 class="fw-bold">ADMIN LOGIN</h2>
                           <p class="custom-primary-color fw-bold">PLEASE INPUT USERNAME AND PASSWORD</p>
                           <div class="mb-4">
                              <input type="email" name="email" placeholder="Username / Email" class="form-control"
                                 required>
                           </div>
                           <div class="mb-4">
                              <input type="password" name="password" id="passwordInput" placeholder="Password"
                                 class="form-control" required>
                           </div>
                           <div class="mb-4 form-check">
                              <input type="checkbox" class="form-check-input" id="showPasswordCheckbox"
                                 onchange="togglePasswordVisibility()">
                              <label class="form-check-label float-start" for="showPasswordCheckbox">Show
                                 password</label>
                           </div>
                           <div class="d-grid gap-2 mb-4">
                              <button type="submit" name="submit" class="btn btn-select-yellow fw-bold">Login</button>
                           </div>
                           <?php
                           if (isset($message)) {
                              foreach ($message as $message) {
                                 echo '<div class="text-danger"><span>' . $message . '</span> </div>';
                              }
                           }
                           ?>

                        </form>
                     </div>


                     <!-- Small Screens -->
                  </div>

                  <div class="d-lg-none">
                     <div class="card p-4 px-5" style="min-width: 20rem;">
                        <form action="index.php" method="post">
                           <h2 class="fw-bold">ADMIN LOGIN</h2>
                           <p class="custom-primary-color fw-bold">PLEASE INPUT USERNAME AND PASSWORD</p>
                           <div class="mb-4">
                              <input type="email" name="email" placeholder="Username / Email" class="form-control"
                                 required>
                           </div>
                           <div class="mb-4">
                              <input type="password" name="password" placeholder="Password" class="form-control"
                                 required>
                           </div>
                           <div class="mb-4 form-check">
                              <input type="checkbox" class="form-check-input" id="exampleCheck1">
                              <label class="form-check-label float-start" for="exampleCheck1">Show password</label>
                           </div>
                           <div class="d-grid gap-2 mb-4">
                              <button type="submit" name="submit" class="btn btn-select-yellow fw-bold">Login</button>
                           </div>
                           <?php
                           if (isset($message)) {
                              foreach ($message as $message) {
                                 echo '<div class="text-danger"><span>' . $message . '</span> </div>';
                              }
                           }
                           ?>

                        </form>
                     </div>
                  </div>


               </div>
            </div>
         </div>
      </div>
   </div>
</body>


</html>