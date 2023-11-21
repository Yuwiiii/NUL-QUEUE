//local storage / validate
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

    window.location.href = "nulqueue.html";
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
            if (response.success) {
                var queueNumber = response.queue_number;
                document.getElementById("queueNumber").innerText = queueNumber;
                $('#thirdModal').modal('show');
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function () {
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

// Event listener for button clicks

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


// DONE EVENT LISTENER
// document.querySelector("#btn-back").addEventListener("click", function () {
//     // Clear storage
//     localStorage.removeItem("studentId");
//     localStorage.removeItem("program");

//     window.location.href = "index.html";
// });


// Function to populate the select dropdown
// function populateProgramChairs(programName) {

//     // Fetch data
//     $.ajax({
//         url: "academics.php",
//         type: "GET",
//         data: { program: programName },
//         success: function (data) {
//             $("#program-chair-select").append(data);
//         }
//     });

//     $("#done-button").click(function () {
//         var selectedOption = $("#program-chair-select option:selected");
//         var name = selectedOption.text().split(" - ")[0];
//         $("#selectedOptionValue").text(name);
//     });
// }


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

// $(document).ready(function () {
//     populateProgramChairs();
// });



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














function updateCustomerCount() {
    $.ajax({
        url: 'db-process.php?action=customers',
        type: 'GET',
        success: function (data) {
            // Update count
            $('#customer-count').text(data);
        },
    });
}


function updateCompletedCount() {
    $.ajax({
        url: 'db-process.php?action=completed',
        type: 'GET',
        success: function (data) {
            // Update count
            $('#completed-count').text(data);
        },
    });
}

function updatePendingCount() {
    $.ajax({
        url: 'db-process.php?action=pending',
        type: 'GET',
        success: function (data) {
            // Update count
            $('#pending-count').text(data);
        },
    });
}

function updateAccountsCount() {
    $.ajax({
        url: 'db-process.php?action=accounts',
        type: 'GET',
        success: function (data) {
            // Update count
            $('#accounts-count').text(data);
        },
    });
}

$(document).ready(function () {

    $('#check').click(function () {
        alert($(this).is(':checked'));
        $(this).is(':checked') ? $('#test-input').attr('type', 'text') : $('#test-input').attr('type', 'password');
    });
    updateCustomerCount();
    updateCompletedCount();
    updatePendingCount();
    updateAccountsCount();
    setInterval(updateCustomerCount, 1000);
    setInterval(updateCompletedCount, 1000);
    setInterval(updatePendingCount, 1000);
    setInterval(updateAccountsCount, 1000);
});


function togglePasswordVisibility() {
    var passwordInput = document.getElementById("passwordInput");
    var passwordCheckbox = document.getElementById("showPasswordCheckbox");

    if (passwordCheckbox.checked) {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}


// FOR SUPER ADMIN ADMISSION
function getAdmissionCustomerCount() {
    $.ajax({
        url: 'registrar-db-process.php',
        type: 'GET',
        success: (data) => {
            // Update count
            $('#admission-count').text(data);
        },
        error: () => {
            console.log('Error fetching customer count.');
        }
    });
}

$(document).ready(function () {
    getAdmissionCustomerCount(); 
    setInterval(getAdmissionCustomerCount, 1000); 
});

// FOR SUPER ADMIN ACCOUNTING
function getAdmissionCustomerCount() {
    $.ajax({
        url: 'accounting-db-process.php',
        type: 'GET',
        success: (data) => {
            // Update count
            $('#accounting-count').text(data);
        },
        error: () => {
            console.log('Error fetching customer count.');
        }
    });
}

$(document).ready(function () {
    getAdmissionCustomerCount(); 
    setInterval(getAdmissionCustomerCount, 1000); 
});

// FOR SUPER ADMIN REGISTRAR
function getRegistrarCustomerCount() {
    $.ajax({
        url: 'registrar-db-process.php',
        type: 'GET',
        success: (data) => {
            // Update count
            $('#registrar-count').text(data);
        },
        error: () => {
            console.log('Error fetching customer count.');
        }
    });
}

$(document).ready(function () {
    getRegistrarCustomerCount(); 
    setInterval(getRegistrarCustomerCount, 1000); 
});



