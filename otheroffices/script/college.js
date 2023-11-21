document.getElementById('searchUserInput').addEventListener('input', function () {
    const searchValue = this.value.trim();
    if (searchValue === '') {
        window.location.href = 'college.php';
    }
});

//for warning when the form fields are incomplete
function validateForm() {
    var acronym = document.getElementById("acronym").value;
    var collegeName = document.getElementById("collegeName").value;

    var acronymError = document.getElementById("error_acronym");
    var collegeNameError = document.getElementById("error-collegeName");

    acronymError.style.display = acronym === "" ? "block" : "none";
    collegeNameError.style.display = collegeName === "" ? "block" : "none";

    if (acronym === "" || collegeName === "") {
        return false; // Prevent form submission
    }

}

//for confirmation to add a user
function confirmAddCollege() {
    if (confirm("Are you sure you want to add this college?")) {
        return true; // User confirmed, continue with form submission
    }
    return false; // User canceled, prevent form submission
}

//for confirmation to delete user
function deleteCollege(collegeId) {
    if (confirm("Are you sure you want to delete this user?")) {
        // Send an AJAX request to delete the user
        $.ajax({
            type: "POST",
            url: "deleteCollege.php",
            data: { collegeId: collegeId },
            success: function (data) {
                // Reload the page after successful deletion
                location.reload();
            }
        });
    }
}


// Find all buttons with the 'edit-button' class
var editButtons = document.querySelectorAll('.edit-button');

// Attach a click event handler to each button
editButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        // Retrieve the user ID from the 'data-userid' attribute
        var collegeId = this.getAttribute('data-collegeid');

        // Call the editUser function with the user ID
        editCollege(collegeId);
    });
});

// The editUser function that you want to call
function editCollege(collegeId) {
    // Your editUser function logic goes here
    console.log('Editing college with ID: ' + collegeId);
    // You can use AJAX or any other logic to edit the user
}

function openEditCollegeModal(ID, acronym, collegeName) {

    $('#editCollegeModal #ID').val(ID);
    $('#editCollegeModal #acronym').val(acronym);
    $('#editCollegeModal #collegeName').val(collegeName);

    // Open the modal
    $('#editCollegeModal').modal('show');
}


