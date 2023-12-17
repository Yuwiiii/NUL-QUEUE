<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./styles.css">
</head>

<body>

  <div class="container-fluid">
    <div class="row">
      <div class="rounded-end-5 col-4 blue-bg">
        <img src="/nul-queue/assets/NU_shield.svg" alt="Image" class="img-fluid img_logo" style="max-height: auto; max-width: 40%;">
        <div class="mt-4">
          <h1 class="fw-bolder text-light text-center">NU LAGUNA</h1>
          <h4 class="fw-bold text-light text-center">QUEUING SYSTEM</h4>
        </div>

      </div>
      <div class="col-8 p-5">
        <h4 class="fst-italic fs-3 p-5 fw-bold text-center nu_color">Admission Office</h4>

        <!-- log in page goes here-->

        <div class="login">
          <form id="login" method="post" action="./login.php">
            <h2 class="fst-italic fw-bold">Admin Access</h2>
            <label><b>Username
              </b>
            </label>
            <input type="text" name="username" id="username" placeholder="Username">
            <br><br>
            <label><b>Password
              </b>
            </label>
            <input type="Password" name="password" id="password" placeholder="Password">
            <br><br>
            <input type="submit" name="log" id="log" value="Log In">
            <br><br>


          </form>
        </div>


        <!-- end of log page-->

      </div>
    </div>
  </div>
  </div>
  </div>
  </div>


</body>

</html>