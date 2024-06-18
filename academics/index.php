<?php
session_start(); // Start the session if it hasn't already been started

if (isset($_SESSION["full_name"]) && isset($_SESSION["username"]) && isset($_SESSION["office"])) {
    $full_name = $_SESSION["full_name"];
    $username  = $_SESSION["username"];
    $office  = $_SESSION["office"];

    // Check if the alert has not been shown yet
    if (!isset($_SESSION["login_alert_shown"])) {
        // Set the default concern in the session during login
        echo "<script> alert('Successfully logged in. Welcome, $full_name!\\n\\nOffice: $office' )</script>";
        // Mark the alert as shown
        $_SESSION["login_alert_shown"] = true;
    }
} else {
    header("Location: login.html");
    exit();
}
?>


<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="css/header.css?version=60" />
  <link rel="stylesheet" type="text/css" href="css/notification.css" />
  <link rel="stylesheet" type="text/css" href="css/tn-list.css" />
  <link rel="stylesheet" type="text/css" href="css/index.css?version=61">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
  />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  />
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
    rel="stylesheet"
  />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script
    src="https://kit.fontawesome.com/bd6fee4447.js"
    crossorigin="anonymous"
  ></script>

  <script>
        // Disable back button on the browser
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
  </script>

  <title>Academics Queue</title>
</head>
<html>
  <body>
    <header>
      <div class="logo-div">
        <img src="img/nu_logo.png" class="logo" />
        <!-- <div class="availability-icon" id="availability-icon"></div> -->
        <div>
          <h1>NU LAGUNA</h1>
          <p>QUEUING SYSTEM</p>
        </div>
      </div>

      <!-- Profile Icon -->
      <div class="profile-div">
        <i
          class="fa fa-user-circle"
          id="profile-icon"
          onclick="toggleProfileDropdown()"
        ></i>
        <!-- Availability Status Indicator -->
        <div class="status-indicator" id="status-indicator"></div>
        <!-- Dropdown Content -->

        <div class="dropdown-content" id="profile-dropdown-content">
          <div class="profile-info">
            <div class="left-align">
              <div class="profile-info">
                <div class="profile-icon">
                  <i class="fa fa-user-circle fa-fade"></i>
                </div>
                <div class="profile-details">
                  <span id="profile-name">
                    <?php
                      if (isset($_SESSION['full_name'])) {
                        echo $_SESSION['full_name'];
                      } else {
                        echo 'Guest'; // Display a default value if the session is not set
                      }
                      ?>
                  </span><br />
                  <span class="availability-dropdown">
                  <select
                    id="availability"
                    onchange="updateAvailabilityIcon()"
                    onclick="stopPropagation()"
                  >
                    <option value="available"> 
                      <span class="status-dot status-online"></span>🟢 Available
                    </option>
                    <option value="unavailable">
                      <span class="status-dot status-offline"></span>⚪ Unavailable
                    </option>
                  </select>
                  </span>
                </div>
              </div>
              <hr class="dropdown-line" />
              
              <i class="fa-solid fa-arrow-right-from-bracket" style="margin-left: 20px; margin-bottom:20px;"></i>
              <a href="#" onclick="logout()" class="left-align">Log out</a>
            </div>
          </div>
        </div>
      </div>
    </header>
<!-- start of main-div -->
  <div class="main-div">
    <div class="tn-div">
      <div class="tn-header">
        <h2>ACADEMICS QUEUING</h2>
      </div>
      <!-- Program filter dropdown -->
      <div style="display: flex; margin-bottom: 10px;">
        <select id="program-filter" onchange="populateConcernFilter(this.value); filterByProgram()" style="width: 100%; padding: 5px; ">

            <!-- <select id="program-filter" onchange="populateConcernFilter(this.value)"> -->
            <option value="" id="program-option"selected disabled>➕ Program</option>
        </select>
        <!-- Concern filter dropdown -->
        <select id="concern-filter" onchange="filterByConcern()" style="width: 100%;">
                <!-- Options for concern filter -->
            <!-- Options will be dynamically populated using JavaScript -->
            <option value="" selected></option>
        </select>
        <button onclick="refreshQueue()" style="width: 40%;">Default</button>
        <!-- Add your new button here -->
        <!-- <button onclick="sortFilter()" id="sortButton" style="width: 40%;">↑↓ Sort</button> -->
      </div>
      <div id="tnn" style="overflow-y: auto; height: 100%;">
      <!-- Container to display queue-numbers -->
      <div id="tn-list"  class="tn-list"></div>
      </div>

    </div> <!--End of main-div-->

    <div class="form-div">
        <div class="newque-div">
          <button id="return-queue-button" onclick="returnQueue()">Return to Queue</button>
       
          <button id="new-queue-button">New Queue <i class="fa-solid fa-square-plus"></i></button>
        </div>
        <div class="info-div">
          <!--Start of info-->
        <h1 id="info-queue-number">Welcome!</h1>
        <div class="time-div">
            <p><i id="info-queue-time">please select queue number</i></p> 
            <div id="timer-container" style="display: none;">
            <p id="timer">Timer: 5 seconds</p>
            </div>
            <p hidden><i id="info-queue-timestamp">please select queue number</i></p>
        </div>
        <br /><br />
        <div class="stdID-div">
                      
            <p><b>Student ID:</b> 
            <b><span id="info-student"></span></b>
            </p>
        </div>
        <div class="stdID-div">
                      
            <p><b>Transaction:</b> 
            <span id="info-transaction"></span>
            </p>
        </div>
        <div class="stdID-div">
          
            <p><b>Endorsed from:</b> 
            <span id="info-endorse"></span>
            </p>
        </div>
        <div class="rmk-div">
            <p><b>Remarks:</b></p>
            <div class="msg-div">
              <p> 
              <span id="info-remarks"></span><!--remarks-->
              </p>
            </div>
          <div class="btn-div">
            <button onclick="notifyFront()"><i class="fa-solid fa-bell"></i>NOTIFY</button>
            <button id="endorseButton"><i class="fa-solid fa-paper-plane"></i>ENDORSE</button>
            <button id="end-button" disabled><i class="fa-solid fa-times-circle"></i>END</button>
          </div>
        </div>
        <!--End of info-div-->
    </div><!--End of form-div-->
  </div><!--End of main-div>-->

    <div class="modal-bg">
      <div class="form-modal" id="formModal">
          <div class="modform-div">
              <h1>ENDORSING FORM</h1>
              
              <form id="endorseForm">
                  <input type="hidden" id="form-queue-timestamp" name="form-queue-timestamp"/>
                  <input type="hidden" id="form-queue-number" name="form-queue-number" />
                  <input type="hidden" id="form-queue-endoresedfrom" name="form-queue-endoresedfrom" />
                  <div class="mema">
                      <label><b>Student ID: </b></label>
                      <input type="text" id="student-id" name="student_id"  required />
                  </div>

                  <div class="mema">
                      <label><b>Endorsed To: </b></label>
                      <select id="office" name="office" required>
                          <option value="select" disabled selected>Please Select</option>
                          <option value="accounting">ACCOUNTING</option>
                          <option value="registrar">REGISTRAR</option>
                      </select>
                  </div>

                  <div class="mema">
                      <label><b>Transaction: </b></label>
                      <select id="transaction" name="transaction" required>
                          <option value="select" disabled selected>Please Select</option>
                          <option value="Payment">PAYMENT</option>
                          <option value="Others">OTHERS</option>
                      </select>
                  </div>

                  <div class="rms">
                      <label><b>Remarks: </b></label>
                      <textarea id="remarks-form" name="remarks" rows="4" cols="50" placehorder="Enter remarks" required></textarea>
                  </div><br>
                  <div class="note-notify">
                      <p><i class="fa-regular fa-bell fa-shake"></i> Notify the queue before processing an endorsement.</p>
                  </div>
                  <div class="modbtn-div">
                      <button id="cancelButton">CANCEL</button>
                      <button type="button" id="doneButton"><b>DONE</b></button>
                  </div>
                  
              </form>
          </div>
      </div>
    </div>

    </div>

    <!-- For new notification slide -->
    <div class="notification-container" id="notification">
      <img src="img/horn.png" />
      <div class="notification-content">
        <p class="new-tm">NEW TRACKING NUMBER!</p>
        <p style="margin-top: 1px"><b>Loading...</b></p>
      </div>
        <span class="close-button" onclick="closeNotification()">
        <i class="fas fa-xmark"></i>
        </span>
    </div>
    <!-- For new notification slide -->

<!-- Add this modal to your HTML structure -->
<div class="custom-modal" id="statusModal">
  <div class="modal-content">
    <!-- <span class="close" onclick="closeStatusModal()">&times;</span> -->
    <h1>Notify Queue</h1>
    <p id="statusMessage"></p><br>
    <button onclick="cancelStatus()">CANCEL</button>
    <button onclick="confirmStatus()"><b>OK</b></button>
  </div>
</div>

<!-- Add a modal for the disabled state -->
<div id="wait-modal" class="modal">
  <div class="modal-content">
    <div class="loading-circle"></div>
    <p>Please wait for 2 minutes before you can end a transaction again.</p>
    
    <div class="modal-buttons">
      <button id="cancel-mins-wait-btn">Cancel</button>
    </div>
    
  </div>
</div>

<div id="confirm-modal" class="confirm-modal">
  <div class="confirm-div">
    <!-- <h1 id="Confirm-modal"></h1> -->
      <p>Please proceed to the</p> <h2 id="Confirm-modal"></h2> <p>Office. Your tracking number is:</p> 
          <span id='queue-number'></span>
        <div class="confirm-btn">
      <button id="confirm-done-btn">DONE</button>
    </div>
  </div>
</div>

<!-- Start for endorse and end button confirmation modal -->
<div id="select-queue-modal">
    <div class="confirm-end-div">
    <h1>No Queue Selected</h1>
        <p>Please select a queue number first!</p><br>
        <button id="select-queue-yes-btn"><b>OK</b></button>
    </div>
</div>

<!-- Please select both 'Endorsed To' and 'Transaction' options modal -->
<!-- <div id="select-options-modal" class="modal-bg">
    <div class="confirm-end-div">
        <h1>Fill out all fields</h1>
        <p>Do not leave any options or text areas blank, fill them out.</p><br>
        <button id="select-options-ok-btn"><b>OK</b></button>
    </div>
</div> -->

<div id="reason-modal" class="reason-modal">
    <div class="reason-modal-div">
        <h1>Input Required</h1>
        <p>Please enter a reason for ending the transaction.</p><br>
        <button id="reason-modal-ok-btn"><b>OK</b></button>
    </div>
</div>

<div id="confirm-end-modal" class="confirm-end-modal">
    <div class="confirm-end-div">
        <h1>End Transaction</h1>
        <p>Enter a reason to proceed with ending.</p>
        <textarea id="remarks-reason" placeholder="Input here." required></textarea><br>
        <div class="note-notify">
          <p style="color: gray; font-size: 16px;"><i class="fa-regular fa-bell fa-shake"></i> Notify the queue before processing end.</p>
        </div>
        <div class="confirm-end-btn">
            <button id="confirm-end-no-btn">CANCEL</button>
            <button id="confirm-end-yes-btn"><b>DONE</b></button>
        </div>
    </div>
</div>
<!-- End for endorse and end button confirmation modal -->


    <script src="./js/scripts.js?version=62"></script>
    <script>

    function populateConcernFilter(program) {
        $.ajax({
            type: "GET",
            url: "fetch_concerns.php",
            data: { program: program },
            success: function (response) {
                $("#concern-filter").html(response);
                filterByProgram(); // Automatically trigger data fetching when the concern filter is populated
            },
            error: function (error) {
                console.error("Error fetching concerns:", error);
            }
        });
    }
    
    function filterByProgram() {
    var selectedProgram = $("#program-filter").val();
    var selectedConcern = $("#concern-filter").val();

    $.ajax({
        type: "GET",
        url: "fetch_data.php",
        data: { program: selectedProgram, concern: selectedConcern },
        success: function (response) {
            $("#tn-list").html(response);
            
        },
        error: function (error) {
            console.error("Error fetching data:", error);
        }
    });
    } 

    function filterByConcern() {
        filterByProgram(); // Call the same function when the concern filter is changed
    }

        function fetchDefaultConcernQueueNumbers() {
            // Assuming you have a PHP script (e.g., fetch_default_concern.php) to fetch queue numbers
            $.ajax({
                type: "GET",
                url: "fetch_default_concern.php",
                success: function (response) {
                    $("#tn-list").html(response);
                },
                error: function () {
                    // Handle any errors
                    alert("Failed to fetch default concern data.");
                }
            });
        }

        function refreshQueue() {
    // Reset program and concern filters to default values
    $("#program-filter").val("");
    $("#concern-filter").val("");

    // Fetch and display default concern queue numbers
    fetchDefaultConcernQueueNumbers();
}
</script>

  </body>
</html>