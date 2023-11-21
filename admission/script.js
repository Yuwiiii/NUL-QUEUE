$(document).ready(function () {
  const CONTROLLER_URL = `${window.location.protocol}//${window.location.host}/QUEUE/admission/process.php`;
  const ADMISSION_OFFICE = "ADMISSION";

  // prevent button from getting cached
  $("#endorse-btn").prop("disabled", true);
  $("#transaction-complete-btn").prop("disabled", true);
  $("#remarks").val("");

  $("#endorse").click(function (e) {
    e.preventDefault();

    const queueId = $("#queue-number").data("id");
    const studentId = $("#queue-number").data("student-id");
    const queueNumber = $("#queue-number").data("queue-number");
    const queueRemarks = $("#remarks").val();
    const recipientOffice = $("#office").val();
    const timeStamp = $("#queue-number").data("timestamp");

    console.log(
      studentId,
      queueId,
      queueNumber,
      queueRemarks,
      recipientOffice,
      timeStamp
    );

    $.ajax({
      type: "POST",
      url: CONTROLLER_URL, // Construct the URL
      data: {
        id: queueId,
        queue_number: queueNumber,
        student_id: studentId,
        remarks: queueRemarks,
        office: recipientOffice,
        time_stamp: timeStamp,
        action: "endorse",
      },
      success: function (response) {
        console.log(response);
        if (response == "success") {
          Swal.fire({
            title: `Successfully Endorsed #${queueNumber} to ${recipientOffice}`,
            icon: "success",
            confirmButtonText: "Okay",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else {
          Swal.fire({
            title: `Something went wrong!`,
            icon: "error",
            confirmButtonText: "Okay",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        }
      },
    });
  });

  $("#transaction-complete-btn").click(function (e) {
    e.preventDefault();

    const queueId = $("#queue-number").data("id");
    const studentId = $("#queue-number").data("student-id");
    const queueNumber = $("#queue-number").data("queue-number");
    const queueRemarks = $("#remarks").val();
    const timeStamp = $("#queue-number").data("timestamp");

    console.log(studentId, queueId, queueNumber, queueRemarks);

    $.ajax({
      type: "POST",
      url: CONTROLLER_URL,
      data: {
        id: queueId,
        queue_number: queueNumber,
        student_id: studentId,
        remarks: queueRemarks,
        office: ADMISSION_OFFICE,
        time_stamp: timeStamp,
        action: "transaction_complete",
      },
      dataType: "text",
      success: function (response) {
        console.log(response);
        if (response == "success") {
          Swal.fire({
            title: `Transaction Completed for #${queueNumber}`,
            icon: "success",
            confirmButtonText: "Okay",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else {
          Swal.fire({
            title: `Something went wrong!`,
            icon: "error",
            confirmButtonText: "Okay",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        }
      },
    });
  });

  // Function to update the modal titles
  function updateModalTitle(modalId, title) {
    $(modalId).find(".modal-title").text(title);
  }

  // Event listener for button clicks

  $(".btn").click(function () {
    var modalTitle = $("#queue-number").text();

    // Update the titles of all modals, including admissionModal
    updateModalTitle("#firstModal", modalTitle);
    updateModalTitle("#secondModal", modalTitle);
    updateModalTitle("#thirdModal", modalTitle);
    updateModalTitle("#admissionModal", modalTitle);
  });

  $("#firstModal").on("hide.bs.modal", function () {
    $("#remarks").val("");
  });

  $(".pending-queue-number").click(function (e) {
    e.preventDefault();

    const date = new Date($(this).data("timestamp"));
    const formattedDate = date.toLocaleDateString("en-US", {
      weekday: "short",
      month: "short",
      day: "numeric",
      year: "numeric",
      hour: "numeric",
      minute: "numeric",
      second: "numeric",
      hour12: true,
    });

    // Enable buttons if queue number is selected
    $("#endorse-btn").prop("disabled", false);
    $("#transaction-complete-btn").prop("disabled", false);

    $("#queue-number").text($(this).text());
    $("#queue-number").data("id", $(this).data("id"));
    $("#queue-number").data("queue-number", $(this).data("queue-number"));
    $("#queue-number").data("student-id", $(this).data("student-id"));
    $("#queue-number").data("timestamp", $(this).data("timestamp"));
    $("#student-id").text($(this).data("student-id"));
    $("#student-remarks").text($(this).data("remarks"));
    $("#timestamp").text(`Queued in ${formattedDate}`);

    console.log("clicked");
    console.log($(this).data("timestamp"));
  });
});
