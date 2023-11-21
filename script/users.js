document.getElementById('searchUserInput').addEventListener('input', function () {
    const searchValue = this.value.trim();
    if (searchValue === '') {
        window.location.href = 'users.php';
    }
});

//for warning when the form fields are incomplete
function validateForm() {
    var fullName = document.getElementById("full_name").value;
    var office = document.getElementById("office").value;
    var window = document.getElementById("selectWindow").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var fullNameError = document.getElementById("error_full_name");
    var officeError = document.getElementById("error-office");
    var windowError = document.getElementById("error-window");
    var usernameError = document.getElementById("error-username");
    var passwordError = document.getElementById("error-password");

    fullNameError.style.display = fullName === "" ? "block" : "none";
    officeError.style.display = office === "" ? "block" : "none";
    windowError.style.display = role === "" ? "block" : "none";
    usernameError.style.display = username === "" ? "block" : "none";
    passwordError.style.display = password === "" ? "block" : "none";

    if (fullName === "" || office === "" || window === "" || username === "" || password === "") {
        return false; // Prevent form submission
    }

}

//for confirmation to add a user
function confirmAddUser() {
    if (confirm("Are you sure you want to add this user?")) {
        return true; // User confirmed, continue with form submission
    }
    return false; // User canceled, prevent form submission
}

//for confirmation to delete user
function deleteUser(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        // Send an AJAX request to delete the user
        $.ajax({
            type: "POST",
            url: "deleteUser.php",
            data: { userId: userId },
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
        var userId = this.getAttribute('data-userid');

        // Call the editUser function with the user ID
        editUser(userId);
    });
});

// The editUser function that you want to call
function editUser(userId) {
    // Your editUser function logic goes here
    console.log('Editing user with ID: ' + userId);
    // You can use AJAX or any other logic to edit the user
}

function openEditUserModal(ID, full_name, office, selectWindow, username, password) {

    $('#editUserModal #ID').val(ID);
    $('#editUserModal #full_name').val(full_name);
    $('#editUserModal #editoffice').val(office);
    $('#editUserModal #selectWindow').val(selectWindow);
    $('#editUserModal #username').val(username);
    $('#editUserModal #password').val(password);

    // Open the modal
    $('#editUserModal').modal('show');
}


