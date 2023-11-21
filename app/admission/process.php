<?php
require_once './database.php';
session_start();

global $conn;
global $DbOfficeEnumLabels;
global $currentOffice;
$currentOffice = $_SESSION['user']['office'];

if (isset($_GET['action'])) {
  if ($_GET['action'] == 'getQueue') {
    getQueue($_GET['office']);
  } elseif ($_GET['action'] == 'getOffices') {
    // getOffices();
  }
}

if (isset($_POST['action'])) {
  if($_POST['action'] == 'finishTransaction') {
    finishTransaction($_POST);
  } elseif ($_POST['action'] == 'endorse') {
    endorse($_POST);
  } else if ($_POST['action'] == 'insertQueueToDisplayTable') {
    insertQueueToDisplayTable($_POST);
  } else if ($_POST['action'] == 'getProgramChairsByProgram') {
    $program = $_POST['data']['program'];
    getProgramChairsByProgram($program);
  }
}

function getQueue($office) {
  global $conn;
  global $currentOffice;
  $sql = "SELECT * FROM $currentOffice WHERE status = 0 ORDER BY timestamp ASC";
  $result = mysqli_query($conn, $sql);
  $queue = mysqli_fetch_all($result, MYSQLI_ASSOC);

  echo json_encode($queue);
}

function insertQueueToDisplayTable($post_data) {
  global $conn;
  global $currentOffice;

  $data = $post_data['data'];
  $queue_number = $data['queue_number'];
  $window = $data['window'];

  if (isInDisplay($queue_number)) {
      $sql = "UPDATE display SET `window` = '$window' WHERE queue_number = '$queue_number'";
      $result = mysqli_query($conn, $sql);

      if ($result) {
          echo "Queue updated successfully."; // Output a success message
      } else {
          echo "Error updating queue: " . mysqli_error($conn); // Output the specific error for debugging
      }
  } else {
      $sql = "INSERT INTO display (queue_number, officeName, `window`, status) VALUES ('$queue_number', '$currentOffice', '$window', 0)";
      $result = mysqli_query($conn, $sql);

      if ($result) {
          echo "Queue inserted successfully."; // Output a success message
      } else {
          echo "Error inserting queue: " . mysqli_error($conn); // Output the specific error for debugging
      }
  }
}



function isInDisplay($queue_number) {
  global $conn;
  global $currentOffice;

  $sql = "SELECT * FROM display WHERE queue_number = '$queue_number' AND status = 0 AND officeName = '$currentOffice'";
  $result = mysqli_query($conn, $sql);
  $queue = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (count($queue) > 0) {
    return true;
  }
}

function getCollegesFromAcademics() {
  global $conn;

  $sql = "SELECT * FROM colleges";
  $result = mysqli_query($conn, $sql);
  $queue = mysqli_fetch_all($result, MYSQLI_ASSOC);

  return $queue;
}



// function getOffices() {
//   global $DbOfficeEnumLabels;
//   global $conn;
//   global $currentOffice;
//   $sql = "SELECT * FROM offices WHERE officeName != '$currentOffice'";
//   $offices = mysqli_query($conn, $sql);

//   echo json_encode($offices);
// }

function endorse($post_data) {
  global $conn;
  global $DbOfficeEnumLabels;
  global $currentOffice;

  // $colleges = getCollegesFromAcademics();

  $data = $post_data['data'];

  $CURRENT_OFFICE = $_SESSION['user']['office'];
  $window = $_SESSION['user']['window'];

  $id = $data['id'];
  $queue_number = $data['queue_number'];
  $office = $data['endorse_to'];
  $remarks = $data['remarks'];
  $transaction = $data['transaction'];
  $student_id = $data['student_id'];
  $time_stamp = $data['timestamp'];
  $endorsed_from = $CURRENT_OFFICE;
  $status = 0;

  if ($office == "ACADEMICS") {
    $concern = $data['concern'];
    $program = $data['program'];
    $sql = "SELECT course FROM program_chairs WHERE full_name = '$concern' ";
    $sqlResult = $conn->query($sql);
    if ($sqlResult->num_rows > 0) {
      if ($programRow = $sqlResult->fetch_assoc()) {
          // Convert to uppercase using strtoupper
          $course = $programRow['course'];
          $insertIntoOfficeQuery = "INSERT INTO academics_queue (queue_number, student_id, remarks, timestamp, endorsed_from, status, program, concern, course, transaction) VALUES ('$queue_number', '$student_id', '$remarks', '$time_stamp', '$endorsed_from', $status, '$program', '$concern', '$course', '$transaction')";
      }
       
  }
   
  } else {
    $insertIntoOfficeQuery = "INSERT INTO $office (queue_number, student_id, remarks, timestamp, endorsed_from, status, transaction) VALUES ('$queue_number', '$student_id', '$remarks', '$time_stamp', '$endorsed_from', $status, '$transaction')";
  }


  $result = $conn->query($insertIntoOfficeQuery);

 

  setQueueStatus($id, 1, $queue_number);

  $sql = "UPDATE display SET `window` = '$window', `status` = 1 WHERE queue_number = '$queue_number' AND officeName = '$CURRENT_OFFICE'";
  $result = mysqli_query($conn, $sql);

  insertQueueLog($data);

  echo json_encode($result);
}


  function getProgramChairsByProgram($program) {
    global $conn;

    $sql = "SELECT * FROM program_chairs WHERE program = '$program'";
    $result = mysqli_query($conn, $sql);
    $program_chairs = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode($program_chairs);
  }

function setQueueStatus($id, $status, $queue_number) {
  global $conn;
  global $currentOffice;

  $updateQueueOfOfficeQuery = "UPDATE $currentOffice SET status = '$status' WHERE queue_number = '$queue_number'";

  $conn->query($updateQueueOfOfficeQuery);
}

function setQueueStatusOfQueueNumberInQueueTable($id, $status, $queue_number) {
  global $conn;
  global $currentOffice;

  $updateQueueQuery = "UPDATE queue SET status = '$status' WHERE id = '$id'";

  $conn->query($updateQueueQuery);
}

function finishTransaction($post_data) {
  global $conn;
  global $DbOfficeEnumLabels;
  global $currentOffice;

  $WINDOW = $_SESSION['user']['window'];
  $CURRENT_OFFICE = $_SESSION['user']['office'];

  $data = $post_data['data'];
  $queue_number = $data['queue_number'];

  $id = $data['id'];

  $updateQueueQuery = "UPDATE queue SET status = 1 WHERE id = '$id'";
  $updateQueueQuery = "UPDATE $currentOffice SET status = 1 WHERE  queue_number = '$queue_number'";
  $result = $conn->query($updateQueueQuery);

  $sql = "UPDATE display SET `window` = '$WINDOW', `status` = 1 WHERE queue_number = '$queue_number' AND officeName = '$CURRENT_OFFICE'";
  $res = mysqli_query($conn, $sql);


  insertQueueLog($data);

  echo json_encode($result);
}

function insertQueueLog($data) {
  global $conn;
  global $DbOfficeEnumLabels;
  global $currentOffice;

  $log_table = $currentOffice . "_logs";

  $queue_number = $data['queue_number'];
  $student_id = $data['student_id'];
  $remarks = $data['remarks'];
  $timestamp = $data['timestamp'];
  $timeout = date('Y-m-d H:i:s');
  $endorsed_from = $data['endorsed_from'];
  $transaction = $data['transaction'];
  $status = $data['status'];

  $insertIntoQueueLogQuery = "INSERT INTO $log_table (queue_number, student_id, remarks, timestamp, timeout, endorsed_from, transaction, status) VALUES ('$queue_number', '$student_id', '$remarks', '$timestamp', '$timeout', '$endorsed_from', '$transaction', $status)";

  $result = $conn->query($insertIntoQueueLogQuery);

  echo json_encode($result);
}
