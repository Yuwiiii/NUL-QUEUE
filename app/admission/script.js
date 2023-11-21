const CONTROLLER_URL = `${window.location.protocol}//${window.location.host}/queue/app/admission/process.php`;
const LOGOUT_URL = "/queue/app/auth/logout.php";  
const LOGIN_URL = "/queue/app/auth";

const socket = io('http://localhost:8080');

const USER_OFFICE = $("#user-data").data("office").toUpperCase();
const USER_WINDOW = $("#user-data").data("window");
const USER_ID = $("#user-data").data("user-id");
const USERNAME = $("#user-data").data("user-name");
let academicsCollegeSelected = 'SCS';
  
socket.emit('storeUserInfo', {userId: USER_ID, username: USERNAME, office: USER_OFFICE});

socket.on('endorse', (response) => {
  const message = response.message;

  Swal.fire({
    title: message,
    icon: "info",
    showConfirmButton: false,
    timer: 3000,
    toast: true,
    position: "top-end",
    timerProgressBar: true,
  })

  getQueue(USER_OFFICE);
})

//adjustment sa class 
function refreshByInterval() {
  console.log('refresh')
  setInterval(async () => {
    socket.emit('syncUponendorse');
  }, 5000);
}


// REMOVE THIS IF DI NA NEED NG SET INTERVAL!!!
refreshByInterval();

socket.on('newQueue', (response) => {
  console.log(response);
  getQueue(USER_OFFICE);
});

socket.on('syncQueueCollaborationWithSameOffice', async (response) => {
  console.log("SYNCING")
  console.log(response)

  const data = response.data

  await getQueue(USER_OFFICE);

  data.forEach((queue) => {
    console.log(queue.handling_by !== USER_ID);

    if (queue.handling_by !== USER_ID) {

      $(`.queue-item[data-number="${queue.queueNumber}"]`).css("background-color", "lightblue");
      $(`.queue-item[data-number="${queue.queueNumber}"]`).addClass("active");
      $(`.queue-item[data-number="${queue.queueNumber}"]`).css("color", "grey");
      $(`.queue-item[data-number="${queue.queueNumber}"]`).off('click');
    }
  })

})

socket.on('handleQueue', async (response) => {

  const data = response.data

  await getQueue(USER_OFFICE);

  data.forEach((queue) => {

    if (queue.handling_by !== USER_ID) {
      $(`.queue-item[data-number="${queue.queueNumber}"]`).css("background-color", "lightblue");
      $(`.queue-item[data-number="${queue.queueNumber}"]`).addClass("active");
      $(`.queue-item[data-number="${queue.queueNumber}"]`).css("color", "grey");
      $(`.queue-item[data-number="${queue.queueNumber}"]`).off('click');
    }
  })

})


let queueArray = getQueue(USER_OFFICE);

$("#office").on('change', function () {
  const selectedOption = this.value;

  if (selectedOption === "ACADEMICS") {
    $("#academics-colleges-dropdown").css("display", "block");
    $("#program-chairs-dropdown").css("display", "block");
  } else {
    $("#academics-colleges-dropdown").css("display", "none");
    $("#program-chairs-dropdown").css("display", "none");

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

    await insertQueueToDisplayTable(payload);
  });

  $("#logout-btn").click(() => {
    socket.disconnect(); // Terminate the socket connection
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

    console.log(`remarks: ${remarks}`);
    queueData.endorse_to = $('#office').val();

    let isEndorsedSuccessfully;

    if (queueData.endorse_to === "ACADEMICS") {

      queueData.concern = $('#program-chair').val();
      queueData.program = $("#college").val();

      console.log(queueData);

      isEndorsedSuccessfully = await endorse(queueData);

    } else {
      isEndorsedSuccessfully = await endorse(queueData);
    }
    
    
    if (isEndorsedSuccessfully) {
      const recipient = queueData.endorse_to;
      socket.emit('endorse', {recipientOffice: recipient, senderOffice: USER_OFFICE, queueNumber: queueData.queue_number});

      Swal.fire({
        title: `Successfully Endorsed #${queueData.queue_number} to ${recipient}`,
        icon: "success",
        confirmButtonText: "Okay",
      }).then((result) => {
        if (result.isConfirmed) {
          $('#remarks').val('');
          $('#student-id').text('');
          $('#modalTitle1').text('Select Queue Number');
          $('#queue-number').text('select a queue to view details');
          $('#endorsed-from').text('');
          $('#queue-number').data('id', '');
          $('#student-remarks').text('select a queue number to view remarks');
          $('#firstModal').modal('hide');


          $("#endorse-btn").prop("disabled", true);
          $("#transaction-complete-btn").prop("disabled", true);
          $("#notify-btn").prop("disabled", true);
          socket.emit("syncUponendorse");
        }
      });
    }
  })

  $("#transaction-complete-btn").click(async ()=>{
    const id = $('#queue-number').data("id")
    const queueList = await getQueue(USER_OFFICE);

    
    const queueData = getQueueFromQueueArray(queueList, id)
    const endorsed_from = queueData.endorsed_from;

    queueData.endorsed_from = endorsed_from !== null ? endorsed_from : '';

    console.log("queueData:")
    console.log(queueData)
    const isTransactionCompleted = await finishTransaction(queueData);
    
    // console.log(`hasmdasdasn ${isTransactionCompleted}`)

    if (isTransactionCompleted) {

      Swal.fire({
        title: `Successfully Completed #${queueData.queue_number}`,
        icon: "success",
        confirmButtonText: "Okay",
      }).then((result) => {
        if (result.isConfirmed) {
          $('#remarks').val('');
          $('#student-id').text('');
          $('#modalTitle1').text('Select Queue Number');
          $('#queue-number').text('select a queue to view details');
          $('#queue-number').data('id', '');
          $('#endorsed-from').text('');
          $('#student-remarks').text('select a queue number to view remarks');
          $('#firstModal').modal('hide');


          $("#endorse-btn").prop("disabled", true);
          $("#transaction-complete-btn").prop("disabled", true);
          $("#notify-btn").prop("disabled", true);

          socket.emit("syncUponendorse");
        }
      });
    }


    
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

          queueData.forEach((queue) => {
            const $queueItem = $(
              `<div class="queue-item" data-id="${queue.id}" data-number="${queue.queue_number}"> <h5 scope="row" class="pending-queue-number">${queue.queue_number}</h5></div>`
            );

            // Attach click listener using event delegation
            $queueItem.on("click", function () {
              const clickedQueueNumber = queue.queue_number;

              $("#modalTitle1").text(queue.queue_number);
              $("#queue-number").text(queue.queue_number);
              $("#queue-number").data("id", queue.id);
              $("#student-id").text(queue.student_id);
              $("#student-remarks").text(queue.remarks);
              $("#endorsed-from").text(queue.endorsed_from ?? "");

              $("#endorse-btn").prop("disabled", false);
              $("#transaction-complete-btn").prop("disabled", false);
              $("#notify-btn").prop("disabled", false);
          
              socket.emit('handleQueue', {userId: USER_ID, office: USER_OFFICE, queueNumber: clickedQueueNumber});
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
            $("#program-chair").append(`<option value="${programChair.id}">${programChair.full_name}</option>`)
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