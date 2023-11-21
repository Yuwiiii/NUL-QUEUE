<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once './database.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM user_accounts WHERE username = '$username' AND password = '$password'";

  $USER = mysqli_fetch_assoc(mysqli_query($conn, $sql));

  if ($USER) {
    $_SESSION['user'] = $USER;

    header('Location: /queue/app/admission');
  } else {
    echo '<script>alert("Invalid input!");</script>';
    echo '<script>window.history.back();</script>';
  }

}

