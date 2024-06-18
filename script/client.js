

// function submitStudentId() {
//   var studentId = document.getElementById("studentId").value;
//   var program = document.getElementById("program").value;

//   if (studentId === "") {
//       document.getElementById("error-message").style.display = "block";
//       return;
//   }

//   // Set the student ID in local storage
//   localStorage.setItem("studentId", studentId);
//   localStorage.setItem("program", program);

//   if (studentId === "") {
//       return;
//   }

//   window.location.href = "nulqueue.php";
// }
function closeAlert() {
    $('#ongoingQueueAlert').fadeOut();
}


function submitStudentId() {
    var studentId = document.getElementById("studentId").value;
    var program = document.getElementById("program").value;

    if (studentId === "") {
        document.getElementById("error-message").style.display = "block";
        return;
    }

    // Set the student ID in local storage
    localStorage.setItem("studentId", studentId);
    localStorage.setItem("program", program);

    if (studentId === "") {
        return;
    }

    // Make an AJAX request to check the queue status
    $.ajax({
        type: "POST",
        url: "check_student.php", // Replace with the actual PHP file name
        data: { studentId: studentId },
        dataType: "json",
        success: function (response) {
            if (response.status === 'error') {
                // Display a pop-up or show a message indicating an ongoing queue
                $('#ongoingQueueAlert').fadeIn();
                $('#queueNumber').text(response.queueNumber);
                $('#exStudentError').modal('show');
                $('#exStudent').modal('hide');

                // // Close the alert after 5 seconds (5000 milliseconds)
                // setTimeout(closeAlert, 10000);
            } else {
                // Set the student ID in local storage
                localStorage.setItem("studentId", studentId);
                localStorage.setItem("program", program);

                // Redirect to the queue page

            }
        },
        error: function () {
            window.location.href = "nulqueue.php";
        }
    });
}

function deleteStudentId() {
    var studentId = localStorage.getItem("studentId");

    $.ajax({
        type: "POST",
        url: "deletestudent.php",
        data: { studentId: studentId },
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                $('#exStudentError').modal('hide');
                $('#exStudent').modal('show');

                // // Close the alert after 5 seconds (5000 milliseconds)
                // setTimeout(closeAlert, 10000);
            } else {
                // Set the student ID in local storage
                localStorage.setItem("studentId", studentId);
                localStorage.setItem("program", program);
            }
        },
        error: function () {
            alert("An error occurred.");
        }
    });
}


// queue student
function registerStudent() {
    var studentId = localStorage.getItem("studentId");
    var program = localStorage.getItem("program");
    var office = document.getElementById("modalTitle1").innerText;

    $.ajax({
        type: "POST",
        url: "process.php",
        data: { studentId: studentId, program: program, office: office },
        dataType: "json",
        success: function (response) {

            console.log(response)

            if (response.success) {
                var queueNumber = response.queue_number;
                document.getElementById("queueNumber").innerText = queueNumber;
                $('#thirdModal').modal('show');

                // Notify target offices of new Queue

            } else {
                alert("Error: " + response.message);
            }
        },
        error: function (error) {

            console.log("ERROR IS THROWN HERE 👁️")
            console.log(error)
            alert("An error occurred.");
        }
    });
}


// queue student
function registerGuest() {
    localStorage.setItem("studentId", "GUEST");
    localStorage.setItem("program", "-");
    var studentId = localStorage.getItem("studentId");
    var program = localStorage.getItem("program");
    var office = document.getElementById("modalTitle1").innerText;

    $.ajax({
        type: "POST",
        url: "process.php",
        data: {
            studentId: studentId,
            program: program,
            office: office
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                var queueNumber = response.queue_number;
                // Set the queue number in the modal
                document.getElementById("queueNumber").innerText = queueNumber;
                // Show the third modal
                $('#thirdModal').modal('show');

                // Notify target offices of new Queue

                console.log("transmitting message")
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function () {
            alert("An error occurred.");
        }
    });
}

// Function to update the modal titles
function updateModalTitle(modalId, title) {
    $(modalId).find(".modal-title").text(title);
}


$(".btn").click(function () {
    var modalTitle = $(this).data("title");


    // Update modals
    updateModalTitle("#firstModal", modalTitle);
    updateModalTitle("#secondModal", modalTitle);
    updateModalTitle("#thirdModal", modalTitle);
    updateModalTitle("#acadModal", modalTitle);
    updateModalTitle("#acadModal2", modalTitle);
    updateModalTitle("#acadModal3", modalTitle);
    // populateProgramChairs(modalTitle);
});

// Handle the submit button click event
function insertAcads() {
    var studentId = localStorage.getItem("studentId");
    var selectedChair = $("#program-chair-select option:selected");

    var name = selectedChair.text().split('<---')[0].trim(); //cut the 
    var program = document.getElementById("modalTitle1").innerText;
    var program_queue = localStorage.getItem("program");
    var office = document.getElementById("modalTitle1").innerText;


    // Send data to the server to insert into the 'academics' table
    $.ajax({
        url: "academics.php",
        type: "POST",
        data: {
            concern: name,
            program: program,
            studentId: studentId,
            office: office,
            program_queue: program_queue,
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                var queueNumber = response.queue_number;
                document.getElementById("queueNumber").innerText = queueNumber;
                $('#acadModal3').modal('show');
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function () {
            alert("An error occurred.");
        }
    });
};

function populateDropdown(programselected) {
    // Create a function to update the dropdown options
    function updateDropdown() {
        $.ajax({
            url: "academics.php",
            type: "GET",
            data: { program: programselected },
            dataType: "json",
            success: function (data) {
                // Clear existing options
                $('#program-chair-select').empty();

                // Add the retrieved options to the select element
                $.each(data, function (key, value) {
                    var option = $('<option>', {
                        value: key,
                        text: value.full_name
                    });

                    if (value.status === 'offline') {
                        option.prop('disabled', true);
                        option.text(value.full_name + ' <--- unavailable --->');
                    }
                    else if (value.status === 'unavailable') {
                        option.prop('disabled', true);
                        option.text(value.full_name + ' <--- unavailable --->');
                    }
                    else {
                        option.text(value.full_name + ' <--- available --->');
                    }

                    $('#program-chair-select').append(option);
                });
            },
            error: function () {
                console.error("Error fetching data from the server.");
            }
        });
    }

    // Initial call to populate the dropdown
    updateDropdown();



    $("#done-button").click(function () {
        var selectedOption = $('#program-chair-select option:selected');
        var selectedChair = selectedOption.text(); // Get the text of the selected option

        var nameWithoutStatus = selectedChair.split('<---')[0].trim();

        $('#selected-chair').text(nameWithoutStatus);
    });


}

function returnIndex() {
    window.location.href = 'index.php'
}

$(document).ready(function () {
    $('#btn-print-qn').click(function () {
        $('#queueNumber, #modalTitle3, #desc').printThis({
            importCSS: true,
            importStyle: true,
            loadCSS: "/nul-queue/styles/printqueue.css",
            footer: null
        });
    });
});

