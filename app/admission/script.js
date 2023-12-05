const CONTROLLER_URL = `${window.location.protocol}//${window.location.host}/nul-queue/app/admission/process.php`;
const LOGOUT_URL = `${window.location.protocol}//${window.location.host}/nul-queue/app/auth/logout.php`;  
const LOGIN_URL = `${window.location.protocol}//${window.location.host}/nul-queue/app/auth`;

const USER_OFFICE = $("#user-data").data("office").toUpperCase();
const USER_WINDOW = $("#user-data").data("window");
const USER_ID = $("#user-data").data("user-id");
const USERNAME = $("#user-data").data("user-name");
let academicsCollegeSelected = 'SCS';
let isDoneButtonOnCooldown = false;

const TWO_MINUTES = 160000;
  
//adjustment sa class 
function refreshByInterval() {
  console.log('refresh')
  setInterval(async () => {
    await getQueue(USER_OFFICE)
  }, 5000);
}


// REMOVE THIS IF DI NA NEED NG SET INTERVAL!!!
refreshByInterval();


$("#endorse-btn").click(() => {
  const hasSelectedQueue = $("#queue-number").data("key");

  console.log(hasSelectedQueue);

  if (hasSelectedQueue === "") {
    // Hide the modal and show a warning message
    $('#firstModal').modal('hide');

    Swal.fire({
      title: `Please select a queue number first`,
      icon: "warning",
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
    });
  } else {
    // Proceed with modal popup
    $('#firstModal').modal('show');
  }
});

let queueArray = getQueue(USER_OFFICE);

$("#office").on('change', function () {
  const selectedOption = this.value;

  if (selectedOption === "ACADEMICS") {
    $("#academics-colleges-dropdown").css("display", "block");
    $("#program-chairs-dropdown").css("display", "block");
    $("#program-course-dropdown").css("display", "block");
  } else {
    $("#academics-colleges-dropdown").css("display", "none");
    $("#program-chairs-dropdown").css("display", "none");
    $("#program-course-dropdown").css("display", "none");
  }
})

$("#college").on('change', function () {
  academicsCollegeSelected = $(this).val();
  console.log(academicsCollegeSelected);
  getProgramChairByProgram(academicsCollegeSelected);
});

  $("#notify-btn").click(async () => {    
    const payload = {
      queue_number: $("#queue-number").text(),
      officeName: USER_OFFICE,
      window: USER_WINDOW
    }

    const hasSelectedQueue = $("#queue-number").data("key");

    console.log(hasSelectedQueue);
  
    if (hasSelectedQueue === "") {
  
      Swal.fire({
        title: `Please select a queue number first`,
        icon: "warning",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
      });
    } else {
      // Proceed with modal popup
      await insertQueueToDisplayTable(payload);
    }



  });

  $("#logout-btn").click(() => {
    console.log("logout");
    logout();
  });

  
  function getQueueFromQueueArray(queueArray, id){
    return queueArray.find(queue => queue.id === id);
  }

  $("#endorse").click(async ()=>{
    const id = $('#queue-number').data("id")

    queueArray = await getQueue(USER_OFFICE);
    const queueData = await getQueueFromQueueArray(queueArray, id)
    queueData.remarks = $('#remarks').val();

    console.log(`remarks: ${ queueData.remarks}`);
    queueData.endorse_to = $('#office').val();
    queueData.transaction = $('#modal-transaction').val();

    let isEndorsedSuccessfully;

    if (queueData.endorse_to === "ACADEMICS") {

      queueData.concern = $('#program-chair').val();
      queueData.program = $("#college").val();

      console.log(queueData);

      if (!queueData.remarks || !queueData.transaction) {
        Swal.fire({
          title: `Please fill up all fields`,
          icon: "warning",
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
        })

        return
      } 
  

      isEndorsedSuccessfully = await endorse(queueData);

    } else {
      if (!queueData.remarks || !queueData.transaction) {
        
        Swal.fire({
          title: `Please fill up all fields`,
          icon: "warning",
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
        })

        return
      } 
      isEndorsedSuccessfully = await endorse(queueData);
    }
    
    
    if (isEndorsedSuccessfully) {
      await getQueue(USER_OFFICE);

      $('#office').val('REGISTRAR');
      $('#office').trigger('change');

      const recipient = queueData.endorse_to;
      Swal.fire({
        title: `Successfully Endorsed #${queueData.queue_number} to ${recipient}`,
        icon: "success",
        confirmButtonText: "Okay",
      }).then((result) => {
        if (result.isConfirmed) {
          $('#remarks').val('');
          $('#student-id').text('');
          $('#modalTitle1').text('Select Queue Number');
          $('#modal-student-id').text('');
          $('#modal-transaction').val('');
          $('#queue-number').text('select a queue to view details');
          $('#endorsed-from').text('');
          $('#queue-number').data('id', '');
          $('#student-remarks').text('select a queue number to view remarks');
          $('#firstModal').modal('hide');

          $("#queue-number").data("key", "");

          // $("#endorse-btn").prop("disabled", true);
          // $("#transaction-complete-btn").prop("disabled", true);
          // $("#notify-btn").prop("disabled", true);


        }
      });
    }
  })

  $("#transaction-complete-btn").click(async ()=>{

    const hasSelectedQueue = $("#queue-number").data("key");

    console.log(hasSelectedQueue);

    if(isDoneButtonOnCooldown){
     
      return
    }
  
    if (hasSelectedQueue === "" && !isDoneButtonOnCooldown) {
      // Hide the modal and show a warning message
      $('#secondModal').modal('hide');
  
      Swal.fire({
        title: `Please select a queue number first`,
        icon: "warning",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
      });
    } else {
      // Proceed with modal popup
      $('#secondModal').modal('show');
      $("#modalTitle2").text($("#queue-number").text());
    }

  })
  $("#qbtn").click(async ()=>{
    window.open('../../index.php')
  })

  $("#end-transaction-btn").click(async () => {
    const id = $('#queue-number').data("id")
    const queueList = await getQueue(USER_OFFICE);

    
    const queueData = getQueueFromQueueArray(queueList, id)
    const endorsed_from = queueData.endorsed_from;

    queueData.endorsed_from = endorsed_from !== null ? endorsed_from : '';
    queueData.remarks = $('#done-remarks').val();

    console.log("queueData:")
    console.log(queueData)

    Swal.fire({
      title: `Are you sure you want to end the transaction of #${queueData.queue_number}?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(async (result) => {
      if (result.isConfirmed) {
        const isTransactionCompleted = await finishTransaction(queueData);
        if (isTransactionCompleted) {
          await getQueue(USER_OFFICE);
          Swal.fire({
            title: `Successfully Completed #${queueData.queue_number}`,
            icon: "success",
            confirmButtonText: "Okay",
          }).then((result) => {
            if (result.isConfirmed) {
              $('#remarks').val('');
              $('#done-remarks').val('');
              $('#student-id').text('');
              $('#modalTitle2').text('Select Queue Number');
              $('#modal-student-id').text('');
              $('#modal-transaction').val('');
              $('#queue-number').text('select a queue to view details');
              $('#queue-number').data('id', '');
              $('#endorsed-from').text('');
              $('#student-remarks').text('select a queue number to view remarks');
              $('#secondModal').modal('hide');

              $("#queue-number").data("key", "");

              isDoneButtonOnCooldown = true;

              setTimeout(() => {
                isDoneButtonOnCooldown = false;
              }, TWO_MINUTES);

              let timerInterval;
              $("#transaction-complete-btn").prop("disabled", true);
              Swal.fire({
                title: "Finish transaction cooldown!",
                html: "Can perform finish operation after <b></b> seconds.",
                timer: TWO_MINUTES,
                toast: true,
                position: 'top-end',
                timerProgressBar: true,
                showCancelButton: false,
                showConfirmButton: false,
                didOpen: () => {
                  Swal.showLoading();
                  const timer = Swal.getPopup().querySelector("b");
                  timerInterval = setInterval(() => {
                    const remainingTime = Math.ceil(Swal.getTimerLeft() / 1000); // Convert milliseconds to seconds
                    timer.textContent = `${remainingTime}`;
                  }, 100);
                },
                willClose: () => {
                  clearInterval(timerInterval);
                }
        
              }).then((result) => {
                $("#transaction-complete-btn").prop("disabled", false);
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                  console.log("I was closed by the timer");
                }
              });
            }

      

          })
      }}
    })
  })

async function insertQueueToDisplayTable(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: CONTROLLER_URL,
      type: "POST",
      data: {
        action: "insertQueueToDisplayTable",
        data: data,
      },
      success: function (data) {
        if (data) {
          resolve(true);
        } else {
          reject(false);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
      },
    });
  })
}



async function getQueue(office) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: CONTROLLER_URL,
      type: "GET",
      data: {
        action: "getQueue",
        office: office,
      },
      success: function (data) {
        $(".queue-container").html("");

        if (data) {
          const queueData = JSON.parse(data);

          console.log(queueData)

          queueData.forEach((queue) => {
            const $queueItem = $(
              `<div class="queue-item" data-id="${queue.id}" data-number="${queue.queue_number}"> <h5 scope="row" class="pending-queue-number">${queue.queue_number}</h5></div>`
            );

            $queueItem.on("click", function () {
              const clickedQueueNumber = queue.queue_number;

              $("#modalTitle1").text(queue.queue_number);
              $('#modal-student-id').text(queue.student_id);
              $("#queue-number").text(queue.queue_number);
              $("#queue-number").data("id", queue.id);
              $("#student-id").text(queue.student_id);
              $("#student-remarks").text(queue.remarks);
              $("#endorsed-from").text(queue.endorsed_from ?? "");

              $("#queue-number").data("key", "active");

              console.log(clickedQueueNumber)
            });

            // Append the created element
            $(".queue-container").append($queueItem);
          });
          resolve(queueData); // Resolve the promise with the queueData
        } else {
          reject("No data received from the server");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
        reject("AJAX error");
      },
    });
  });
}

function endorse(data){
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: CONTROLLER_URL,
      type: "POST",
      data: {
        action: "endorse",
        data: data,
      },
      success: function (data) {
        console.log(data);

        if (data) {
          resolve(true);
        } else {
          reject(false);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
      },
    });

  })
}


function insertQueueToDisplayTable(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: CONTROLLER_URL,
      type: "POST",
      data: {
        action: "insertQueueToDisplayTable",
        data: data,
      },
      success: function (data) {
        console.log(data);

        if (data) {
          resolve(true);
        } else {
          reject(false);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
      },
    });
  })
}


function finishTransaction(data){
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: CONTROLLER_URL,
      type: "POST",
      data: {
        action: "finishTransaction",
        data: data,
      },
      success: function (data) {
        console.log(data);

        if (data) {
          resolve(true);
        } else {
          reject(false);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
      },
    });
  })
}

function getOffices(){
  $.ajax({
    url: CONTROLLER_URL,
    type: "GET",
    data: {
      action: "getOffices"
    },
    success: function (data) {
      console.log(`Offices: ${data}`);
      $("#office").html("");
      const offices = JSON.parse(data);
      offices.forEach(office => {
        $("#office").append(`<option value="${office}">${office}</option>`)
      })

    },
    error: function (xhr, status, error) {
      console.error("AJAX error:", status, error);
    },
  });
}

function logout() {
  $.ajax({
    url: LOGOUT_URL,
    type: "POST",
    success: function (response) {
      // Redirect to the login page after successful logout
      window.location.href = LOGIN_URL; // Adjust the path if needed
    },
    error: function (xhr, status, error) {
      // Handle errors, if any
      console.error("Logout failed:", status, error);
    },
  });
}




function getProgramChairByProgram(program = 'SCS') {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: CONTROLLER_URL,
      type: "POST",
      data: {
        action: "getProgramChairsByProgram",
        data: {
          program: program
        },
      },
      success: function (data) {
        console.log(data);

        if (data) {

          const programChairs = JSON.parse(data);
          $("#program-chair").html("");
          programChairs.forEach(programChair => {
            $("#program-chair").append(`<option value="${programChair.full_name}">${programChair.full_name}</option>`)
          })

          resolve(true);
        } else {
          reject(false);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
      },
    });
  })
}