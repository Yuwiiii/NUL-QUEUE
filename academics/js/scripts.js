function updateAvailabilityIcon() {
    var select = document.getElementById("availability");
    var statusIndicator = document.getElementById("status-indicator");
    var selectedValue = select.value;

    statusIndicator.classList.remove("available", "unavailable");

    if (selectedValue === "available") {
      statusIndicator.classList.add("available");
    } else if (selectedValue === "unavailable") {
      statusIndicator.classList.add("unavailable");
    }
    // Update the status in the database via AJAX
    $.ajax({
            type: "POST",
            url: "update_status.php", // URL to the script that updates the status
            data: { status: selectedValue }, // Send the selected status value
            success: function(response) {
                if (response === "success") {
                    // Status updated successfully
                    console.log("Status updated successfully.");
                } else {
                    console.log("Status updated successfully.");
                }
            }
        });
  }

  function toggleProfileDropdown() {
    var dropdown = document.getElementById("profile-dropdown-content");
    dropdown.classList.toggle("show");
  }
  function stopPropagation() {
    event.stopPropagation();
  }
  function filterByProgram(program) {
    // Use AJAX to fetch data based on the selected program
    $.ajax({
        type: "GET",
        url: "fetch_data.php",
        data: { program: program },
        success: function (response) {
            
            $("#").html(response);
        },
    });
}

function fetchInfo(queueNumber) {
  // Send an AJAX request to fetch data for the clicked queue_number
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          var data = JSON.parse(xhr.responseText);
          // Update the HTML elements with fetched data
          document.getElementById('info-queue-number').textContent = data.queue_number;
          document.getElementById('info-queue-time').textContent = "Queued in " + data.queue_time;
          document.getElementById('info-remarks').textContent = data.remarks;
          document.getElementById('info-student').textContent = data.studentid;
          document.getElementById('info-endorse').textContent = data.endorse;
          document.getElementById('info-transaction').textContent = data.transaction;
          document.getElementById('student-id').value = data.studentid;
          document.getElementById('queue-number').textContent = data.queue_number;
          document.getElementById('form-queue-number').value = data.queue_number;
          document.getElementById('info-queue-timestamp').textContent = data.timestamp;
          document.getElementById('form-queue-timestamp').value = data.timestamp;
          document.getElementById('form-queue-endoresedfrom').value = data.endorse;
          // Add more code to update other elements if needed
      }
  };
  xhr.open('POST', 'fetch_info.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('queue_number=' + queueNumber);
  // Prevent the default button behavior
  event.preventDefault();
}

  function logout() {
      $.ajax({
          type: "POST",
          url: "logout.php", // URL to the logout script
          success: function (response) {
              if (response === "success") {
                  // Redirect to a success page or perform desired action
                  window.location.href = "login.html"; // Redirect to the login page
              } else {
                  // Display an error message
                  alert("Logout failed. Please try again.");
              }
          }
      });
  }

  window.onclick = function (event) {
    if (!event.target.matches(".fa-user-circle")) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };

  // Select the button and modal elements
  const modalBg = document.querySelector('.modal-bg');
  const formModal = document.querySelector('.form-modal');
  const doneModal = document.querySelector('.done-modal');
  const confirmModal = document.querySelector('.confirm-modal');
  const endorseButton = document.getElementById('endorseButton');
  const cancelButton = document.getElementById('cancelButton');
  const doneButton = document.getElementById('doneButton');
  const exitButton = document.getElementById('ext-div');
  const nextButton = document.getElementById('nxt-div');
  const confirmButton = document.getElementById('confirm-done-btn');
  const endorseForm = document.querySelector('.modform-div');
  const doneDiv = document.getElementById('done-div');
  const confirmDiv = document.getElementById('confirm-div');
  const queuebutton = document.getElementById('new-queue-button');

  // start for endorse and end confirmation modal
  $(document).ready(function () {
    const confirmEndModal = document.querySelector('.confirm-end-modal');
    const confirmEndYesButton = document.getElementById('confirm-end-yes-btn');
    const confirmEndNoButton = document.getElementById('confirm-end-no-btn');

// Add a click event listener to the 'END' button
$("#end-button").on("click", function () {
  // Check if there is data in the info-div
  var isInfoDivEmpty =
      $("#info-queue-number").text().trim() === "Welcome!" &&
      $("#info-queue-time").text().trim() === "please select queue number" &&
      $("#info-student").text().trim() === "" &&
      $("#info-transaction").text().trim() === "" &&
      $("#info-endorse").text().trim() === "" &&
      $("#info-remarks").text().trim() === "";

  if (isInfoDivEmpty) {
      $("#select-queue-modal").css("display", "flex");
  } else {
      $("#end-button").prop("disabled", true);      
      $("#wait-modal").css("display", "flex");
      setTimeout(function() {
        $("#end-button").prop("disabled", false);
        $("#wait-modal").css("display", "none");
      }, 120000);
      setTimeout(function() {
        confirmEndModal.style.display = 'flex';
      }, 120000);
  }
});

// Add a click event listener to the Yes button in the select-queue-modal
$("#select-queue-yes-btn").on("click", function () {
  // Close the 'Please select a queue number first!' modal
  $("#select-queue-modal").css("display", "none");
});
    // Add a click event listener to the Yes button in the confirmation modal
    confirmEndYesButton.addEventListener('click', function () {
        // Get data from the elements
        var queueNumber = $("#info-queue-number").text();
        var queueTime = $("#info-queue-timestamp").text();
        var studentInfo = $("#info-student").text();
        var transactionInfo = $("#info-transaction").text();
        var endorsementInfo = $("#info-endorse").text();
        var remarks = $("#remarks-reason").val();
        if (remarks.trim() === "") {
          showReasonModal();
        return;
        }
        // AJAX request to send data to end.php
        $.ajax({
            url: "end.php",
            type: "POST",
            data: {
                queueNumber: queueNumber,
                queueTime: queueTime,
                studentInfo: studentInfo,
                transactionInfo: transactionInfo,
                endorsementInfo: endorsementInfo,
                remarks: remarks
            },
            success: function (response) {
                // Handle the response from the server if needed
                console.log(response);
                document.getElementById('info-queue-number').textContent = "Welcome!";
                document.getElementById('info-queue-time').textContent = "please select queue number";
                document.getElementById('info-student').textContent = "";
                document.getElementById('info-transaction').textContent = "";
                document.getElementById('info-endorse').textContent = "";
                document.getElementById('remarks-reason').value = "";
                // Close the confirmation modal
                confirmEndModal.style.display = 'none';
            },
            error: function (error) {
                // Handle errors if any
                console.log(error);
            }
        });
    });
    // Add a click event listener to the No button in the confirmation modal
    confirmEndNoButton.addEventListener('click', function () {
        // Close the confirmation modal without performing the 'END' action
        confirmEndModal.style.display = 'none';
    });
});

// REASON MODAL START
function showReasonModal() {
  $("#confirm-end-modal").css("display", "none");
  const reasonModal = document.getElementById('reason-modal');
  reasonModal.style.display = 'block';
  const okButton = document.getElementById('reason-modal-ok-btn');
  okButton.addEventListener('click', function () {
      reasonModal.style.display = 'none';
      $("#confirm-end-modal").css("display", "flex");
  });
}
  
endorseButton.addEventListener('click', () => {
  // Check if there is data in the info-div
  var isInfoDivEmpty =
      $("#info-queue-number").text().trim() === "Welcome!" &&
      $("#info-queue-time").text().trim() === "please select queue number" &&
      $("#info-student").text().trim() === "" &&
      $("#info-transaction").text().trim() === "" &&
      $("#info-endorse").text().trim() === "" &&
      $("#info-remarks").text().trim() === "";

  if (isInfoDivEmpty) {
      // Show the 'Please select a queue number first!' modal
      $("#select-queue-modal").css("display", "flex");
  } else {
      // Toggle the display property of modal elements
      modalBg.style.display = 'flex';
      formModal.style.display = 'flex';
      endorseForm.style.display = 'block';
  }
});


  // Add a click event listener to the cancel button
  cancelButton.addEventListener('click', (event) => {
    event.preventDefault(); 
    document.getElementById('office').value = 'select';
    document.getElementById('transaction').value = 'select';
    document.getElementById('remarks-form').value = '' ;
    // Toggle the display property of modal elements to hide the modal
    modalBg.style.display = 'none';
    formModal.style.display = 'none';
    endorseForm.style.display = 'none';
});
// end for endorse and confirmation modal

queuebutton.addEventListener('click', () => {
  window.open('../index.php', '_blank');
});

// start of endorse function START START START
  document.getElementById("doneButton").addEventListener("click", function () {
    // Get the form data
    const form = document.getElementById("endorseForm");
    const formData = new FormData(form);

    fetch("process_form.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.text())
        .then(() => {
            const office = document.getElementById("office").value;
            const transaction = document.getElementById("transaction").value;
            const remarks = document.getElementById("remarks-form").value;
            
            if (office === 'select' || transaction === 'select' || remarks.trim() === '') {
                // Instead of alert, show the new modal
                alert("Fill out all fields");
            } else {
                // Continue with your code
                document.getElementById('Confirm-modal').textContent = office.toUpperCase();
                formModal.style.display = 'none';
                confirmModal.style.display = 'flex';
                console.log("Success");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
});

// function hideFormModal() {
//   const formModal = document.getElementById('formModal');
//   formModal.style.display = 'none';
// }

// function showFormModal() {
//   const formModal = document.getElementById('formModal');
//   formModal.style.display = 'flex';
// }

// function showOptionsModal() {
//     // Hide the form-modal
//     hideFormModal();
//     // Display the modal for informing the user to select options
//     const optionsModal = document.getElementById('select-options-modal');
//     optionsModal.style.display = 'block';
//     // Add an event listener to the OK button in the modal
//     const okButton = document.getElementById('select-options-ok-btn');
//     okButton.addEventListener('click', function () {
//         // Close the modal when the OK button is clicked
//         optionsModal.style.display = 'none';
//         // Show the form-modal again
//         showFormModal();
//     });
// }

document.getElementById("confirm-done-btn").addEventListener("click", function () {
  const queueNumber = document.getElementById("form-queue-number").value;
  if (queueNumber) {
      fetch("delete_queue.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "queue_number=" + queueNumber,
      })
          .then((response) => response.text())
          .then(() => {
              // Reset or clear any additional elements if needed
              document.getElementById('info-queue-number').textContent = "Welcome!";
              document.getElementById('info-queue-time').textContent = "please select queue number";
              document.getElementById('info-student').textContent = "";
              document.getElementById('info-transaction').textContent = "";
              document.getElementById('info-endorse').textContent = "";
              document.getElementById('info-remarks').textContent = "";
              // Close the confirm-modal
              confirmModal.style.display = 'none';
              // Go back to the previous page
              window.location.href = 'index.php';
          })
          .catch((error) => {
              console.error("Error:", error);
          });
  }
});

  // For new notification slide
  function closeNotification() {
    var notification = document.getElementById("notification");
    notification.style.right = "-400px"; // Slide out to the right
  }
  
  function showNotification(newQueueNumber) {
    var notificationContainer = document.getElementById("notification");
    notificationContainer.querySelector("b").textContent = newQueueNumber;
    notificationContainer.style.right = "20px";
    notificationContainer.style.display = "block";
}

function checkForNewQueueNumber() {
    $.ajax({
        type: "POST",
        url: "notification_queue.php",
        data: {},
        success: function (data) {
            if (data && data.newQueueNumber) {
                showNotification(data.newQueueNumber);
            }
        },
        error: function (error) {
            console.error("Error fetching new queue number: " + error);
        }
    });
}
// sort START
// sort END

setInterval(checkForNewQueueNumber, 8000);

  //fetching data from the database
  function fetchDataAndPopulate() {
    // Get the selected program and concern
    var selectedProgram = document.getElementById("program-filter").value;
    var selectedConcern = document.getElementById("concern-filter").value;

    $.ajax({
        type: "GET",
        url: "fetch_data.php",
        data: { program: selectedProgram, concern: selectedConcern }, // Include concern parameter
        success: function (response) {
            $("#tn-list").html(response);
        },
        error: function () {
            // Handle any errors
            alert("Failed to fetch data.");
        }
    });
}

// Call the function when needed, for example, when the page loads
$(document).ready(function () {
    fetchDataAndPopulate();
    setInterval(fetchDataAndPopulate, 1000);
});

// For NOTIFY button
let currentQueueNumber;

function notifyFront() {
  // Get the queuenumber from somewhere, e.g., an input field or a variable
  currentQueueNumber = document.getElementById("info-queue-number").textContent;
  // Check if there is data in the info-div
  var isInfoDivEmpty =
      $("#info-queue-number").text().trim() === "Welcome!" &&
      $("#info-queue-time").text().trim() === "please select queue number" &&
      $("#info-student").text().trim() === "" &&
      $("#info-transaction").text().trim() === "" &&
      $("#info-endorse").text().trim() === "" &&
      $("#info-remarks").text().trim() === "";

  if (isInfoDivEmpty) {
      // Show the 'Please select a queue number first!' modal
      $("#select-queue-modal").css("display", "flex");
  } else {
      // Show the custom status modal
      $("#statusModal").css("display", "flex");
      $("#statusMessage").text("This queue number will be displayed on the queuing screen.");
  }
}

function confirmStatus() {
  // Send an AJAX request to update the status
  $.ajax({
      type: "POST",
      url: "notifyFront.php", // URL to the server-side script
      data: { queuenumber: currentQueueNumber },
      success: function(response) {
          if (response === "success") {
              // Update the modal content
              $("#statusMessage").text("This queue number will be displayed on the queuing screen.");
          } else {
              // Update the modal content
              $("#statusMessage").text("Displaying queue number failed. Please contact admin.");
          }
          // Hide the modal after processing
          $("#statusModal").css("display", "none");
      },
      error: function() {
          // Update the modal content
          $("#statusMessage").text("An error occurred. Please try again.");
          // Hide the modal after processing
          $("#statusModal").css("display", "none");
      }
  });
}

function cancelStatus() {
  // Hide the modal if the user cancels
  $("#statusModal").css("display", "none");
}

function updateProgramOptions() {
  var selectElement = document.getElementById('program-filter');
  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();
  // Set up the request
  xhr.open('GET', 'get_program_options.php', true);
  // Set up the callback
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status == 200) {
        // Parse the JSON response
        var options = JSON.parse(xhr.responseText);
        // Clear existing options
        selectElement.innerHTML = '<option value="" selected disabled>➕ Program</option>';
        // Add new options
        options.forEach(function (option) {
          var optionElement = document.createElement('option');
          optionElement.value = option;
          optionElement.textContent = option;
          selectElement.appendChild(optionElement);
        });
      } else {
        console.error('Error fetching options:', xhr.status, xhr.statusText);
      }
    }
  };
  // Set up the error callback
  xhr.onerror = function () {
    console.error('Network error while fetching options');
  };
  // Send the request
  xhr.send();
}
// Call the function to update options on page load
updateProgramOptions();

document.addEventListener('DOMContentLoaded', function () {
  // Assuming you have a cancel button with id "cancelbtn"
  var cancelwaitbtn = document.getElementById('cancel-mins-wait-btn');

  cancelwaitbtn.addEventListener('click', function (event) {
      event.preventDefault();

      // Add your cancel process logic here
      // For demonstration purposes, let's simply hide the wait-modal
      var waitModal = document.getElementById('wait-modal');
      waitModal.style.display = 'none';
  });
});