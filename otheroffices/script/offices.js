const officeLinks = document.querySelectorAll('nav a');
const officeContents = document.querySelectorAll('.office-content');

officeLinks.forEach((link, index) => {
    link.addEventListener('click', (e) => {
        e.preventDefault();

        // Hide all office contents
        officeContents.forEach(content => content.classList.remove('active'));

        // Show the selected office content
        officeContents[index].classList.add('active');
    });
});

// FOR TABLE
myTable = () => {
    var input, filter, table, tr, th, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        th = tr[0].getElementsByTagName("th");
        for (j = 0; j < th.length; j++) {
            td = tr[i].getElementsByTagName("td")[j];
            if (td || th[j]) {
                txtValue = (td ? td.textContent || td.innerText : "") + (th[j] ? th[j].textContent || th[j].innerText : "");
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}


//FOR Office-aside.php
document.getElementById('searchOfficesInput').addEventListener('input', function () {
    const searchValue = this.value.trim();
    if (searchValue === '') {
        window.location.href = 'office-aside.php';
    }
});

//FOR DELETE OFFICE STARTS
function deleteOffice(officeId, officeName) {
    // Update modal content with dynamic information
    $("#deleteModalBody").html("Are you sure you want to delete the office '" + officeName + "'?");

    // Show the modal
    $("#deleteModal").modal('show');

    // Set up event listener for the delete button in the modal
    $("#confirmDeleteButton").off("click").on("click", function () {
        // Send an AJAX request to delete the office
        $.ajax({
            type: "POST",
            url: "deleteOffice.php",
            data: { officeId: officeId },
            success: function (data) {
                // Reload the page after successful deletion
                location.reload();
            }
        });

        // Hide the modal after clicking the delete button
        $("#deleteModal").modal('hide');
    });
}
//FOR DELETE OFFICE ENDS




//FOR EDIT OFFICE STARTS
var editButtons = document.querySelectorAll('.edit-button');

editButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        var officeId = this.getAttribute('data-officeid');
        editOffice(officeId);
    });
});

function editOffice(officeId) {
    console.log('Editing office with ID: ' + officeId);
}

function openEditOfficeModal(ID, acronym, officeName) {
    $('#editOfficeModal #ID').val(ID);
    $('#editOfficeModal #acronym').val(acronym);
    $('#editOfficeModal #OfficeName').val(officeName);

    // Open the modal
    $('#editOfficeModal').modal('show');
}

$(document).ready(function () {

    $('#editOfficeForm').submit(function (e) {
        e.preventDefault(); 

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'editOffice.php',
            data: formData,
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                console.error('Error submitting form:', error);
            }
        });
    });
});
//FOR EDIT OFFICE ENDS

