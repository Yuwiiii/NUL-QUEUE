<?php
session_start();

// Check if the user is not logged in or does not have the necessary session variables set
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_name"]) || !isset($_SESSION["window"])) {
    header("Location: ../admin_login.php");
    exit();
}

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
      <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
      <div class="top-bar">
        <div class="logo-container">
          <img class="logo" src="img/NU_shield.svg" alt="NU Logo" width="40" height="40">
          <span> NU LAGUNA<br>QUEUING SYSTEM</span>
        </div>
        <div class="profile-icon" onclick="toggleProfileInfo()">
          <img src="img/profile.png" alt="Profile Icon" width="40" height="40">
        </div>
        <div class="profile-info" id="profileInfo">
          <div class="profile-info-content">
            <p class="profile-name"><?php echo $_SESSION["user_name"]; ?></p>
            <p class="profile-window" style="color: black;">Window:<?php echo $_SESSION["window"]; ?></p>
            <div class="profile-separator"></div> 
            <button class="logout-button" onclick="logout()"><i class="bi bi-box-arrow-right"></i>Log out</button>
          </div>
        </div>
      </div>
      
      <div class="main">
        <div class="sidebar">
            <div class="queue-header">
                <h2>REGISTRAR QUEUEING</h2>
            </div>
            
            <div class="queue-list">
            <div id="queueItemsContainer">
            <?php
    

    
    $sql = "SELECT queue_number, student_id, remarks, transaction, timestamp, endorsed_from FROM registrar";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo '<div class="queue-item" onclick="changeQueueInfo(\'' . $row['queue_number'] . '\')">';
          echo '<h4>Queue Number: ' . $row['queue_number'] . '</h4>';
          echo '<p>Student ID: ' . $row['student_id'] . '</p>';
          echo '<p>Endorsed From: ' . $row['endorse_from'] . '</p>';
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
        <div class="new-queue-button-container">
            <button id="addqueuenumber" button class="new-queue-button" onclick="openNewQueueTab()">Add Queue No:</button>
        </div>
    <div class="outinfo-div">
        <div class="btn-div">
            <button id="notifyButton" class="right-button" onclick="notifyQueueNumber()">Notify</button>
        </div>
        <h1>No Queue Number</h1>
        <div class="stamp-div">
        <p>Queued in <span id="receivedTime"></span></p>
        </div>
        <div class="SID-div">
            <p><b>Student I.D:</b> <span id="studentId">0000-0000</span></p>
        </div>
        <div class="endorsed-div">
            <p><b>Endorsed From:</b> <span id="endorsedFrom"></span></p>
        </div>
        <div class="transc-div">
            <p><b>Transaction:</b> <span id="transaction"></span></p>
        </div>
        <div class="rmk-div">
            <p><b>Remarks:</b></p>
            <div class="msg-div">
                <textarea id="messageTextArea" rows="10" cols="255" readonly></textarea>
            </div>
            <div class="btn-div">
                <button id="endorseButton" class="right-button" onclick="openEndorseModal('<?php echo $queueNumberValue; ?>')">ENDORSE</button>
            </div>
            <div class="btn-div" style="text-align: right;">
    <button id="endTransactionButton" class="right-button" onclick="endTransaction()">End Transaction</button>
</div>

        </div>
    </div>
</div>

<div class="modal" id="commentFormModal">
    <div class="center-container">
        <div class="f-modal">
            <h1>End Transaction Form</h1>
            <p><b>Queue Number: </b><span id="commentFormQueueNumber"></span></p>
            <div class="form-group">
                <label for="commentTextArea">Feedback:</label>
                <textarea id="commentTextArea" name="commentTextArea" rows="10" cols="255" style="border: 2px solid #34418E; resize: none;" required></textarea>
            </div>
            <!-- Add 'required' attribute to the input field -->
            <div class="button-group">
                <button id="cancelCommentButton" class="button">CANCEL</button>
                <button id="submitCommentButton" class="right-button">SUBMIT</button>
            </div>
        </div>
    </div>
</div>

    <div class="modal" id="endorseModal">
  <div class="center-container">
    <div class="f-modal">
      <h1>ENDORSING FORM</h1>
      <form action="submit_endorsed_data.php" method="post">
      <div class="form-group">
    <label for="queueNo">Queue No:</label>
    <input type="text" id="queueNo" name="queueNo" required readonly />
</div>

        <div class="form-group">
          <label for="studentId">Student I.D: </label>
          <input type="text" id="studentId" name="studentId" required readonly />
        </div>
        <div class="form-group">
          <label for="endorsedTo">Endorsed To:</label>
          <select id="endorsedTo" name="endorsedTo" required onchange="toggleAcademicsInfo()">
            <option value="Admission">Admission</option>
            <option value="Accounting">Accounting</option>
            <option value="Academics">Academics</option>
            <option value="Assets">Assets</option>
            <option value="ITSO">ITSO</option>
            <option value="Clinic">Clinic</option>
            <option value="Guidance">Guidance</option>
          </select>
        </div>
        <!-- Additional fields for Academics -->
        <div id="academicsInfo" style="display: none;">
        <div class="form-group">
    <label for="program">Program: (For Academics)</label>
    <select id="program" name="program" >
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
          <input type="text" id="transaction" name="transaction" required/>
        </div>
        <div class="form-group">
          <label for="remarks">Remarks:</label>
          <textarea id="remarks" name="remarks" rows="10" cols="255" style="border: 2px solid #34418E; resize: none;" required></textarea>
        </div>
        <div class="button-group">
        <button id="cancelButton" type="reset" class="button" onclick="document.getElementById('endorseModal').style.display = 'none';">CANCEL</button>
         <button id="doneButton" type="Submit" class="right-button">SUBMIT</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="notification-message" id="notificationMessage">Endorsed Successfully</div>
  

  
<script>
 function notifyQueueNumber() {
    const queueNumberInput = document.getElementById('queueNo');
    const queueNumber = queueNumberInput.value;

    if (queueNumber) {
        const windowNumber = "<?php echo $_SESSION['window']; ?>";
        const officeName = "REGISTRAR";

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    const message = ` ${queueNumber} has been notified for processing at Window ${windowNumber}`;
                    if ('speechSynthesis' in window) {
                        const speech = new SpeechSynthesisUtterance(message);
                        window.speechSynthesis.speak(speech);
                    } else {
                        alert(message);
                    }

                    // Add the following code to update the display table
                    const displayXhr = new XMLHttpRequest();
                    displayXhr.onreadystatechange = function () {
                        if (displayXhr.readyState === 4 && displayXhr.status === 200) {
                            // Handle the response if needed
                        }
                    };

                    displayXhr.open('POST', 'update_display.php', true);
                    displayXhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    const displayData = "queueNumber=" + queueNumber + "&windowNumber=" + windowNumber + "&officeName=" + officeName;
                    displayXhr.send(displayData);
                } else {
                    console.error("Failed to notify:", response.message);
                }
            }
        };

        xhr.open('POST', 'update_window.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        const data = "queueNumber=" + queueNumber + "&windowNumber=" + windowNumber;
        xhr.send(data);
    } else {
        console.error("Queue number is missing. Please select a queue number from the sidebar.");
    }
}

</script>
<script>
function endTransaction() {
    const queueNumberInput = document.getElementById('queueNo');
    const queueNumber = queueNumberInput.value;

    if (queueNumber) {
        // Open the comment form modal
        openCommentFormModal(queueNumber);
    } else {
        console.error("Queue number is missing.");
    }
}   

function openCommentFormModal(queueNumber) {
    // Set the queue number in the comment form modal
    document.getElementById('commentFormQueueNumber').textContent = queueNumber;
    // Show the comment form modal
    document.getElementById('commentFormModal').style.display = 'block';
}

document.getElementById('cancelCommentButton').addEventListener('click', function () {
    // Close the comment form modal
    document.getElementById('commentFormModal').style.display = 'none';
    // Reload the page
    location.reload();
});

document.getElementById('submitCommentButton').addEventListener('click', function () {
    const comments = document.getElementById('commentTextArea').value;
    const queueNumber = document.getElementById('commentFormQueueNumber').textContent;

    // Check if the comments (feedback) is not empty before submitting
    if (comments.trim() === "") {
        alert("Please enter feedback before submitting.");
        return; // Stop the function if feedback is empty
    }

    // Continue with the AJAX request to submit comments to the server
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                document.getElementById('commentFormModal').style.display = 'none';
                updateOutputDiv(""); // Assuming this function exists to update the output-div
            } else {
                console.error("Failed to submit comments:", response.message);
            }
        }
    };

    xhr.open('POST', 'end_transaction.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    const data = "queueNumber=" + queueNumber + "&comments=" + encodeURIComponent(comments);
    xhr.send(data);

    location.reload();
});



function removeQueueNumberFromSidebar(queueNumber) {
    const queueItem = document.querySelector('.queue-item[data-queue-number="' + queueNumber + '"]');
    if (queueItem) {
        queueItem.remove();
    }
}
</script>
<script>

function openEndorseModal() {
    var endorseModal = document.getElementById("endorseModal");
    endorseModal.style.display = "block";

    // Fetch the student ID
    const studentIdInput = document.getElementById("studentId");
    const queueNumber = document.getElementById("queueNo").value;

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                // Set the student ID as non-editable
                studentIdInput.readOnly = true;

                // Set the fetched student ID
                studentIdInput.value = response.student_id;
            } else {
                console.error("Failed to fetch student ID:", response.message);
            }
        }
    };

    xhr.open("GET", "fetch_student_id.php?queueNumber=" + queueNumber, true);
    xhr.send();
}

// Add this function to toggle the Academics information when the page loads
document.addEventListener("DOMContentLoaded", function () {
    toggleAcademicsInfo();
});

  function closeEndorseModal() {
    var endorseModal = document.getElementById("endorseModal");
    endorseModal.style.display = "none";
  }

  document.getElementById("endorseButton").addEventListener("click", openEndorseModal);

 
document.getElementById('cancelButton').addEventListener('click', function() {
    location.reload();
});

 
<?php
 
    $sql = "SELECT queue_number FROM registrar";
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

  
function formatTimestamp(timestamp) {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    };

    const formattedDate = new Date(timestamp).toLocaleString('en-US', options);
    return formattedDate;
}

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
            receivedTime.textContent = 'Queued in: ' + formatTimestamp(queueData.timestamp);
            studentId.textContent = 'Student I.D: ' + queueData.student_id;
            endorsedFrom.textContent = 'Endorsed From: ' + queueData.endorsed_from;
            transaction.textContent = 'Transaction: ' + queueData.transaction;
            remarks.value = queueData.remarks;

            const windowNumber = queueData.window ? `Window ${queueData.window}` : 'Not assigned';
            document.querySelector('.output-div .window-div p').textContent = windowNumber;
        }
    };

    xhr.open('GET', 'fetch_queue_data.php?queueNumber=' + queueNumber, true);
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
            // Make an AJAX request to a logout script (logout.php)
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Redirect to the login page after successful logout
                    window.location.href = "../admin_login.php";
                }
            };
            xhr.open('GET', 'logout.php', true);
            xhr.send();
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Attach the logout function to the logout button click event
        var logoutButton = document.querySelector('.logout-button');
        if (logoutButton) {
            logoutButton.addEventListener('click', logout);
        }
    });

  const queueItems = document.querySelectorAll(".queue-item");

  queueItems.forEach((item) => {
    item.addEventListener("click", function () {
      const queueNumber = item.querySelector("h4").textContent;
      updateOutputDiv(queueNumber);
    });
  });
  
 
</script>

<script>
 
 function toggleAcademicsInfo() {
    const endorsedToSelect = document.getElementById("endorsedTo");
    const academicsInfo = document.getElementById("academicsInfo");

    if (endorsedToSelect.value === "Academics") {
      academicsInfo.style.display = "block";
    } else {
      academicsInfo.style.display = "none";
    }
  }

  const programDropdown = document.getElementById("program");
  const concernDropdown = document.getElementById("concern");

  document.addEventListener("DOMContentLoaded", function () {
    const programDropdown = document.getElementById("program");

    function updateProgramOptions(programs) {
      // Clear existing options
      programDropdown.innerHTML = "<option value=''>Select a program</option>";

      // Add options based on fetched programs
      for (const program of programs) {
        programDropdown.innerHTML += `<option value="${program}">${program}</option>`;
      }
    }

    // Fetch programs from fetch_programs.php
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        updateProgramOptions(response.data);
      }
    };

    xhr.open("GET", "fetch_programs.php", true);
    xhr.send();
  });

  function updateConcernOptions() {
    const selectedProgram = programDropdown.value;

    // Fetch the concerns based on the selected program
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const concerns = JSON.parse(xhr.responseText);

        // Update the options in the concern dropdown
        concernDropdown.innerHTML = "<option value=''>Select a concern</option>";
        for (const concern of concerns) {
          concernDropdown.innerHTML += `<option value="${concern.full_name}">${concern.full_name}</option>`;
        }
      }
    };

    xhr.open("GET", `fetch_concerns.php?program=${selectedProgram}`, true);
    xhr.send();
  }

  programDropdown.addEventListener("change", updateConcernOptions);
  endorsedToSelect.addEventListener("change", toggleAcademicsInfo);

  // Initial population of program options
  updateProgramOptions();
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
                // Unset the session variable after displaying the notification
                unset($_SESSION['notification_message']);
                ?>
            }, 5000); // 5 seconds timeout
        }
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
<script>

function playTingSoundEffect() {
    const tingSound = new Audio('ting.mp3');  // Replace 'path/to/ting.mp3' with the actual path to your sound file
    tingSound.play();
}

// Modify the fetchNewQueueNumbers function to check for new queue numbers
function fetchNewQueueNumbers() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var sortedQueueNumbers = JSON.parse(xhr.responseText);

            // Check for new queue numbers
            for (const queueNumber of sortedQueueNumbers) {
                if (!queueNumbers.includes(queueNumber)) {
                    // New queue number found
                    playTingSoundEffect();  // Play the "ting...." sound effect
                    queueNumbers.push(queueNumber); // Add to the existing queue numbers
                }
            }

            // Update the sidebar with the sorted queue numbers
            queueNumbers = sortedQueueNumbers;
            showQueueNumbers();
        }
    };
    xhr.open('GET', 'fetch_new_queue_numbers.php', true);
    xhr.send();
}


// Fetch new queue numbers every 3 seconds
setInterval(fetchNewQueueNumbers, 1000);

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Display the notification box
    const notificationBox = document.querySelector('.notification-box');
    if (notificationBox.textContent.trim() !== "") {
        notificationBox.style.display = 'block';
    }
});

// Close the notification box after 3 seconds
setTimeout(function () {
    const notificationBox = document.querySelector('.notification-box');
    if (notificationBox) {
        notificationBox.style.display = 'none';
    }
}, 3000);
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    updateCurrentTimestamp(); // Set initial timestamp

    // Update timestamp every second
    setInterval(updateCurrentTimestamp, 1000);
  });

  function updateCurrentTimestamp() {
    const receivedTimeSpan = document.getElementById("receivedTime");
    receivedTimeSpan.textContent = getCurrentTimestamp();
  }

  function getCurrentTimestamp() {
    const options = {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      hour12: true,
    };

    return new Date().toLocaleString('en-US', options);
  }
</script>
<script>
       function openNewQueueTab() {
            window.open('http://localhost/Main', '_blank');
        }   
</script>
    </body>
    </html>