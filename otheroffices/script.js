document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector("form");
    const notification = document.getElementById("notification");
    const loginStatus = document.getElementById("login-status"); // New line

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(loginForm);

        fetch("login.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    notification.textContent = data.message;
                    notification.style.color = "green";
                    window.location.href = "registrar_admin.html"; // Redirect on success
                } else {
                    notification.textContent = data.message;
                    notification.style.color = "red";
                    loginStatus.innerHTML = '<div style="color: red;">' + data.message + '</div>'; // Display error message
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
});
