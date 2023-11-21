<?php
session_start();
$_SESSION['username'] = '';
$username = $_SESSION['username'];

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "queuing_system";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
    <body>
    <div class="top-bar">
    <div class="logo-container">
      <img class="logo" src="img/NU_shield.svg" alt="NU Logo" width="40" height="40">
      <span> NU LAGUNA<br>QUEUING SYSTEM</span>
    </div>
    <div class="profile-icon" onclick="toggleProfileInfo()">
  <span id="greeting"><h4>Howdy,</span>
  <span id="userName"><?php echo $_SESSION["user_name"]; ?> </h4></span>
</div>

<div class="profile-info" id="profileInfo">
   
<a href="#" onclick="logout()" class="logout-link">
        <span class="glyphicon glyphicon-log-out"></span> Log out
      </a>

</div>

<script>
  function toggleProfileInfo() {
    var profileInfo = document.getElementById("profileInfo");
    var profileName = document.getElementById("profileName");
    var userName = document.getElementById("userName");
    var greeting = document.getElementById("greeting");

    if (profileInfo.style.display === "block") {
      // If profile info is visible, hide it
      profileInfo.style.display = "none";
      greeting.style.display = "inline";
      userName.style.display = "none";
    } else {
      // If profile info is hidden, show it
      profileInfo.style.display = "block";
      greeting.style.display = "none";
      userName.style.display = "inline";
    }
  }

  function logout() {
    // Implement your logout logic here
    alert("Logout clicked");
  }
</script>

  </div>
      
  <div class="main">
        <div class="sidebar">
            <div class="queue-header">
                <h2>CLINIC QUEUEING</h2>
            </div>

            <div class="queue-list">
            <div id="queueItemsContainer">
            <?php

    $sql = "SELECT queue_number, student_id, remarks, transaction, timestamp, endorsed_from FROM clinic";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo '<div class="queue-item" onclick="changeQueueInfo(\'' . $row['queue_number'] . '\')">';
          echo '<h4>Queue Number: ' . $row['queue_number'] . '</h4>';
          echo '<p>Student ID: ' . $row['student_id'] . '</p>';
          echo '<p>Endorsed From: ' . $row['endorsed_from'] . '</p>';
          echo '<p>Transaction: ' . $row['transaction'] . '</p>';
          echo '<p>Remarks: ' . $row['remarks'] . '</p>';
          echo '<p>Time Received: ' . $row['timestamp'] . '</p>';
          echo '</div>';
      }
  } else {
      echo "No queue numbers available.";
  }
    ?>
            </div>
  </div>
  <button id="nextButton" class="next-btn" onclick="showNextQueueNumbers()">NEXT</button>
<button id="prevButton" class="prev-btn" onclick="showPrevQueueNumbers()">PREVIOUS</button>
        </div>

        <div class="output-div">
    <div class="outinfo-div">
        <div class="btn-div">
            <button id="notifyButton" class="right-button" onclick="notifyQueueNumber()">Notify</button>
        </div>
        <h1>No Queue Number</h1>
        <div class="stamp-div">
            <p>Queued in <span id="receivedTime">........</span></p>
        </div>
        <div class="SID-div">
            <p><b>Student I.D:</b> <span id="studentId">........</span></p>
        </div>
        <div class="endorsed-div">
            <p><b>Endorsed From:</b> <span id="endorsedFrom">........</span></p>
        </div>
        <div class="transc-div">
            <p><b>Transaction:</b> <span id="transaction">........</span></p>
        </div>
        <div class="rmk-div">
            <p><b>Remarks:</b></p>
            <div class="msg-div">
                <textarea id="messageTextArea" rows="10" cols="255" readonly>No Remarks</textarea>
            </div>
            <div class="btn-div">
                <button id="endorseButton" class="right-button" onclick="openEndorseModal('<?php echo $queueNumberValue; ?>')">ENDORSE</button>
            </div>

      
        <div class="btn-div" style="text-align: right;">
    <button id="endTransactionButton" class="right-button" onclick="endTransaction()">End Transaction</button>
</div>

        <!-- Comment Form Modal -->
        
  
<div class="modal" id="endorseModal">
  <div class="center-container">
    <div class="f-modal">
      <h1>ENDORSING FORM</h1>
      <form action="clinic_submit_endorsed_data.php" method="post">
        <div class="form-group">
          <label for="queueNo">Queue No:</label>
          <input type="text" id="queueNo" name="queueNo" required />
        </div>
        <div class="form-group">
          <label for="studentId">Student I.D:</label>
          <input type="text" id="studentId" name="studentId" required />
        </div>
        <div class="form-group">
          <label for="endorsedTo">Endorsed To:</label>
          <select id="endorsedTo" name="endorsedTo" required onchange="toggleAcademicsInfo()">
          <option value="Registrar">Registrar</option>
            <option value="Admission">Admission</option>
            <option value="Accounting">Accounting</option>
            <option value="Academics">Academics</option>

          </select>
        </div>
        <!-- Additional fields for Academics -->
        <div id="academicsInfo" style="display: none;">
        <div class="form-group">
    <label for="program">Program: (For Academics)</label>
    <select id="program" name="program">
        <option value="SCS">SCS</option>
        <option value="SAS">SAS</option>
        <option value="SEA">SEA</option>
        <option value="SABM">SABM</option>
        <option value="SHS">SHS</option>
    </select>
</div>

<div class="form-group">
    <label for="concern">Concern: (For Academics)</label>
    <select id="concern" name="concern">
        <option value="">Select a program first</option>
    </select>
</div>
        </div>
        <!-- End of additional fields for Academics -->
        <div class="form-group">
          <label for="transaction">Transaction:</label>
          <input type="text" id="transaction" name="transaction" required />
        </div>
        <div class="form-group">
          <label for="remarks">Remarks:</label>
          <textarea id="remarks" name="remarks" rows="5" cols="50"></textarea>
        </div>
        <div class="button-group">
          <button id="cancelButton" class="left-button">CANCEL</button>
          <button id="doneButton" class="right-button">SUBMIT</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="notification-message" id="notificationMessage">Endorsed Successfully</div>

  
  <script>
  function notifyQueueNumber() {
  const queueNumber = document.querySelector(".output-div h1").textContent;
  const windowNumber = "<?php echo $_SESSION['window']; ?>";

  if (queueNumber && windowNumber) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);

      }
    };

    xhr.open('POST', 'ClinicUpdateWindow.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    const data = "queueNumber=" + queueNumber + "&windowNumber=" + windowNumber;
    xhr.send(data);
  } else {
    console.error("Queue number or window number is missing.");
  }
}
</script>



<script>





  function endTransaction() {
  location.reload();
    const queueNumberInput = document.getElementById('queueNo');
    const queueNumber = queueNumberInput.value;

    if (queueNumber) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    // Remove the queue number from the sidebar
                    removeQueueNumberFromSidebar(queueNumber);
                    // Optionally, you can update the output-div to display a message or clear the information
                    updateOutputDiv(""); // Assuming this function exists to update the output-div
                } else {
                    console.error("Failed to end transaction:", response.message);
                }
            }
        };

        xhr.open('POST', 'clinic_end_transaction.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        const data = "queueNumber=" + queueNumber;
        xhr.send(data);
    } else {
        console.error("Queue number is missing.");
    }
}
</script>
  <script>




// Function to remove the queue number from the sidebar
function removeQueueNumberFromSidebar(queueNumber) {
    const queueItem = document.querySelector('.queue-item[data-queue-number="' + queueNumber + '"]');
    if (queueItem) {
        queueItem.remove();
    }
}

function openEndorseModal() {
    var endorseModal = document.getElementById("endorseModal");
    endorseModal.style.display = "block";
  }
  

  function closeEndorseModal() {
    var endorseModal = document.getElementById("endorseModal");
    endorseModal.style.display = "none";
  }

  document.getElementById("endorseButton").addEventListener("click", openEndorseModal);

  document.getElementById("cancelButton").addEventListener("click", closeEndorseModal);
 
  <?php
 
 $sql = "SELECT queue_number FROM clinic";
 $result = $conn->query($sql);

 if ($result->num_rows > 0) {
     $queueNumbers = array();
     while ($row = $result->fetch_assoc()) {
         $queueNumbers[] = $row['queue_number'];
     }
     echo "var queueNumbers = " . json_encode($queueNumbers) . ";";
 }
 ?>

 var currentIndex = 0;

 function showQueueNumbers() {
 var container = document.getElementById('queueItemsContainer');
 container.innerHTML = '';

 for (var i = currentIndex; i < currentIndex + 4; i++) {
     if (i < queueNumbers.length) {
         var queueNumber = queueNumbers[i];
         container.innerHTML += '<div class="queue-item" data-queue-number="' + queueNumber + '" onclick="changeQueueInfo(\'' + queueNumber + '\')"><h4> ' + queueNumber + '</h4></div>';
     }
 }
}


 function showNextQueueNumbers() {
     if (currentIndex + 4 < queueNumbers.length) {
         currentIndex += 4;
     } else {
      
         document.getElementById("nextButton").disabled = true;
     }
     showQueueNumbers();
     document.getElementById("prevButton").disabled = false;
 }

 function showPrevQueueNumbers() {
     if (currentIndex > 0) {
         currentIndex -= 4;
     } else {
        
         document.getElementById("prevButton").disabled = true;
     }
     showQueueNumbers();
     document.getElementById("nextButton").disabled = false;
 }

 showQueueNumbers();

 function changeQueueInfo(queueNumber) {
 const outputDiv = document.querySelector('.output-div');
 const queueNumberText = document.querySelector('.outinfo-div h1');
 const receivedTime = document.querySelector('.stamp-div p');
 const studentId = document.querySelector('.SID-div p');
 const endorsedFrom = document.querySelector('.endorsed-div p');
 const transaction = document.querySelector('.transc-div p');
 const remarks = document.querySelector('.rmk-div textarea');
 const queueNumberInput = document.getElementById('queueNo');
 queueNumberInput.value = queueNumber;

 
 const xhr = new XMLHttpRequest();
 xhr.onreadystatechange = function () {
 if (xhr.readyState === 4 && xhr.status === 200) {
   const queueData = JSON.parse(xhr.responseText);

         queueNumberText.textContent = '' + queueData.queue_number;
         receivedTime.textContent = 'Queued in: ' + queueData.timestamp;
         studentId.textContent = 'Student I.D: ' + queueData.student_id;
         endorsedFrom.textContent = 'Endorsed From: ' + queueData.endorsed_from;
         transaction.textContent = 'Transaction: ' + queueData.transaction;
         remarks.value = queueData.remarks;

         const windowNumber = queueData.window ? `Window ${queueData.window}` : 'Not assigned';
   document.querySelector('.output-div .window-div p').textContent = windowNumber;
     }
 };

 xhr.open('GET', 'clinic_fetch_queue_data.php?queueNumber=' + queueNumber, true);
 xhr.send();
}



document.getElementById('nextButton').addEventListener('click', () => {
    if (activeIndex + 7 < queueOrder.length) {
        activeIndex++;
        updateQueueList();
    }
});

document.getElementById('prevButton').addEventListener('click', () => {
    if (activeIndex > 0) {
        activeIndex--;
        updateQueueList();
    }
});


updateQueueList();
changeQueueInfo(queueOrder[activeIndex]);


  function toggleProfileInfo() {
    var profileInfo = document.getElementById("profileInfo");
    profileInfo.style.display = profileInfo.style.display === "block" ? "none" : "block";
  }

  function logout() {
    var confirmLogout = confirm("Are you sure you want to log out?");
    if (confirmLogout) {
      window.location.href = "../admin_login.php";
    }
  }

  const queueItems = document.querySelectorAll(".queue-item");

  queueItems.forEach((item) => {
    item.addEventListener("click", function () {
      const queueNumber = item.querySelector("h4").textContent;
      updateOutputDiv(queueNumber);
    });
  });
  
  
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var notificationMessage = document.getElementById("notificationMessage");
    var notificationText = "<?php echo $_SESSION['notification_message']; ?>";

    if (notificationText) {
        notificationMessage.textContent = notificationText;
        notificationMessage.style.display = "block";

        setTimeout(function () {
            notificationMessage.style.display = "none";
        }, 5000); 
    }
});

function toggleAcademicsInfo() {
  const endorsedToSelect = document.getElementById("endorsedTo");
  const academicsInfo = document.getElementById("academicsInfo");

  if (endorsedToSelect.value === "Academics") {
    academicsInfo.style.display = "block";
  } else {
    academicsInfo.style.display = "none";
  }
}

const programConcerns = {
        SCS: ["Vincent Rivera ", "Marlon Diloy "],
        SAS: ["Carlito Loyola Jr. ", "Marijualita Malapo ", "Frederick Dalena ", "Jude Thaddeus Bartolome "],
        SEA: ["Brian De Guzman ", "Juliet Niega ", "Joseph Alcoran "],
        SABM: ["Florenda De Vero ", "Johnny Boy Tizon ", "Arnel Villamin "],
        SHS: ["Richard Miguel Butial ", "Jhanna Mae Tadique ", "Maria Carina Pontanar "]
    };

    const programDropdown = document.getElementById("program");
    const concernDropdown = document.getElementById("concern");

    
    function updateConcernOptions() {
        const selectedProgram = programDropdown.value;
        const concerns = programConcerns[selectedProgram] || [];


        concernDropdown.innerHTML = "";


        for (const concern of concerns) {
            const option = document.createElement("option");
            option.value = concern;
            option.text = concern;
            concernDropdown.appendChild(option);
        }
    }


    programDropdown.addEventListener("change", updateConcernOptions);

    updateConcernOptions();


    
    </script>
<script>

function removeQueueNumberFromSidebar(queueNumber) {
    const queueItem = document.querySelector('.queue-item[data-queue-number="' + queueNumber + '"]');
    if (queueItem) {
        queueItem.remove();
    }
}

</script>


<script>
 document.addEventListener("DOMContentLoaded", function () {
    var notificationMessage = document.getElementById("notificationMessage");
    var notificationText = "<?php echo $_SESSION['notification_message']; ?>";

    if (notificationText) {
        notificationMessage.textContent = notificationText;
        notificationMessage.style.display = "block";

        setTimeout(function () {
            notificationMessage.style.display = "none";
            <?php
         
            unset($_SESSION['notification_message']);
            ?>
        }, 5000); 
    }
});




    function removeQueueNumberFromSidebar(queueNumber) {
    const queueItem = document.querySelector('.queue-item[data-queue-number="' + queueNumber + '"]');
    if (queueItem) {
        queueItem.remove();
    }
}
</script>



    </body>
    </html>
