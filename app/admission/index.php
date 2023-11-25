<?php
session_start();
$STATUS_COMPLETE = 1;

// if(!$(_SESSION['user']) ) {
//   header('Location: /queue/app/auth');
// }

require_once './database.php';
$sql = "SELECT * FROM admission  where (status != $STATUS_COMPLETE OR status IS NULL) ORDER BY timestamp ASC";
$result = $conn->query($sql);
$admissionsQueue = $result->fetch_all(MYSQLI_ASSOC);

$userOffice = $_SESSION['user']['office'];

$sql = "SELECT DISTINCT officeName FROM offices WHERE officeName != '$userOffice'";
$result = $conn->query($sql);

$offices = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM colleges";

$colleges = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM program_chairs WHERE program = 'SCS'";
$programChairsSCS = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $_SESSION['user']['office'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="./style/style.css">
</head>
<body>

  <body>
    <div class="nav container-fluid d-flex align-items-center p-1 border justify-content-between px-2">
      <div class="d-flex align-items-center">
        <div class="logo p-2">
          <img src="/queue/assets/NU_shield.svg" alt="logo" id="logo">
        </div>
        <div>
          <h1 class=""><strong>NU LAGUNA</strong></h1>
          <h4>QUEUEING SYSTEM</h4>
        </div>

      </div>
      <div class="d-flex flex-column">
        <h5 id="user-data" data-office="<?= $_SESSION['user']['office'] ?>" data-window="<?= $_SESSION['user']['window'] ?>" data-user-id="<?= $_SESSION['user']['ID'] ?>" data-user-name="<?= $_SESSION['user']['full_name'] ?>"><?= $_SESSION['user']['full_name'] ?></h5>
        <span id="logout-btn" class="cursor-pointer">Logout</span>
      </div>
    </div>

    <main class="d-flex">
      <section class="w-25 p-0">
        <div class="container-fluid border p-0">
          <div class="row">
            <div>
              <div class="bg-yellow">
                <h4 class="m-0 text-center p-2"><strong><?= $_SESSION['user']['office'] ?></strong></h4>
              </div>
              <div class="queue-container">
                <!-- 
                <div class="queue-item">
                  <h5 scope="row" class="pending-queue-number" data-office="<?= $queue['id'] ?>" data-timestamp="<?= $queue['timestamp'] ?>" data-remarks="<?= $queue['remarks'] ?>" data-student-id="<?= $queue['student_id'] ?>" data-id="<?= $queue['id'] ?>" data-queue-number="<?= $queue['queue_number'] ?>">
                    <?= $queue['queue_number'] ?>
                  </h5>
                </div> -->

              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="d-flex flex-column align-items-center w-75 p-0 border">
        <div class="m-auto">
          <h1 id="queue-number" data-key="">Select Queue Number</h1>
          <i id="timestamp"></i>
          <p><strong>Student No.:</strong> <i id="student-id"></i></p>
          <p><strong>Endorsed From:</strong> <i id="endorsed-from"></i></p>
          <p><strong>Remarks:</strong></p>
          <div class="remarks w-75 p-2 border" id="student-remarks">
            Select a queue number to view remarks.
          </div>
          <div class="d-flex justify-content-around w-75 mt-5">
            <button class="btn btn-blue" id="endorse-btn" data-bs-toggle="modal" data-bs-target="#firstModal" disabled>Endorse</button>
            <button class="btn btn-yellow" id="transaction-complete-btn"  data-bs-toggle="modal" data-bs-target="#secondModal" disabled>Done</button>
            <button class="btn btn-yellow" id="notify-btn" disabled>Notify</button>
          </div>
      </section>


      <div class="modal fade" id="firstModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header d-block border-0">
              <h1 class="modal-title fs-4 text-center custom-bold custom-primary-color" id="modalTitle1">Loading...
              </h1>
            </div>
            <div class="modal-body">
            <p>Student Id: <span id="modal-student-id"></span></p>
              <label for="modal-transaction">Transaction: </label>
              <input type="text" id="modal-transaction" required>
              <br>
              <label for="office">Endorse To: </label>
              <select name="office" id="office">
                <?php foreach ($offices as $office) : ?>
                  <option><?= $office['officeName'] ?></option>
                <?php endforeach; ?>
              </select>
              <div id="academics-colleges-dropdown" style="display: none;">
                <label for="college">College: </label>
                <select name="college" id="college">
                  <?php foreach ($colleges as $college) : ?>
                    <option><?= $college['acronym'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div id="program-chairs-dropdown" style="display: none;">
                <label for="program-chair">Program Chairs: </label>
                <select name="program-chair" id="program-chair">
                  <?php foreach ($programChairsSCS as $program_chair) : ?>
                    <option><?= $program_chair['full_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <p>Remarks:</p>
              <div>
                <textarea id="remarks" name="remarks" id="" cols="40" rows="5" required></textarea>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
              <button type="button" class="btn btn-yes px-4 rounded-pill" id="endorse">YES</button>
              <button type="button" class="btn btn-no px-4 rounded-pill" data-bs-dismiss="modal" id="reject-endorsement-btn">NO</button>
            </div>
          </div>
        </div>
      </div>

      <!--2nd modal-->
      <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header d-block border-0">
              <h1 class="modal-title fs-4 text-center custom-bold custom-primary-color" id="modalTitle2">Loading...
              </h1>
            </div>
            <div class="modal-body">       
              <p>Remarks:</p>
              <div>
                <textarea id="done-remarks" name="remarks" id="" cols="55" rows="5" required></textarea>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
              <button type="button" class="btn btn-yes px-4 rounded-pill" id="end-transaction-btn">YES</button>
              <button type="button" class="btn btn-no px-4 rounded-pill" data-bs-dismiss="modal">NO</button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.socket.io/4.3.1/socket.io.min.js"></script>
    <script src="script.js"></script>
  </body>
</body>

</html>