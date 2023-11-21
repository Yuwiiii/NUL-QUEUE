<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NU Laguna Queuing System</title>
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* Add CSS for the shadow box notification */
    .notification-box {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #ff0000;
      color: #fff;
      padding: 10px;
      border-radius: 5px;
      display: none;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }


  </style>
</head>
<body>

<div class="sidebar">
  <div class="logo">
    <img src="img/NU_shield.svg" alt="School Logo">
    <h1>NU Laguna Queuing System</h1>
  </div>
</div>

<div class="form-container">
  <div class="heading">
    <h2>Admin Login</h2>
  </div>

  <form action="login.php" method="post">
    <div class="form-group">
      <label for="username">Username / Email</label>
      <input type="text" id="username" name="username" placeholder="Enter your Username or Email" required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your Password" required>
    </div>

   
    <div class="form-group">
      <label for="office">Choose your office:</label>
      <select id="office" name="office" onchange="redirect()" style="width: 150px";>
        <option value="CLINIC">CLINIC</option>
        <option value="ITSO">ITSO</option>
        <option value="ASSETS">ASSETS</option>
        <option value="GUIDANCE">GUIDANCE</option>
      </select>
    </div>

    <div class="form-group login-button">
      <button class="btn-login" type="submit">Login</button>
    </div>
  </form>

<div id="notification" class="notification-box">
  <?php
    session_start();
    if (isset($_SESSION["login_error"])) {
      echo '<div style="color: white;">' . $_SESSION["login_error"] . '</div>';
      unset($_SESSION["login_error"]); // Clear the error message
      echo '<script>
        document.getElementById("notification").style.display = "block";
      </script>';
    }
  ?>
</div>



<script>
function showPassword() {
  var passwordField = document.getElementById("password");
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
}


<script>
function redirect() {
  var office = document.getElementById("office").value;
  if (office === "CLINIC") {
    window.location.href = "main/clinic_admin.php";
  } else if (office === "ITSO") {
    window.location.href = "main/itso_admin.php";
  } else if (office === "ASSETS") {
    window.location.href = "main/assets_admin.php";
  } else if (office === "GUIDANCE") {
    window.location.href = "main/guidance_admin.php";
  }
}
</script>
</body>
</html>
