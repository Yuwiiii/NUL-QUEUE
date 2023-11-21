    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NU Laguna Queuing System</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <style>
        .notification-box {
            position: fixed;
            top: 20px; /* Adjust the top position */
            right: 20px; /* Adjust the right position */
            background: #8B0000;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            display: none;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            animation: slideNotification 1s forwards; /* Animation for sliding effect */
        }

        @keyframes slideNotification {
            from {
                transform: translateX(100%); /* Slide in from the right */
            }
            to {
                transform: translateX(0); /* Slide to the left */
            }
        }
    </style>

    </head>
    <body>

    <div class="sidebar">
        <div class="logo">
            <img src="img/nu_shield.svg" alt="School Logo">
            <h1>NU Laguna Queuing System</h1>
        </div>
    </div>

    <div class="form-container">
        <div class="heading">
            <h2>Admin Login</h2>
            <h3>Registrar</h3>
        </div>

        <form action="login.php" method="post">
            <div class="form-group">
            <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Enter your Username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-input">
                    <input type="password" id="password" name="password" placeholder="Enter your Password" required>
                    <button type="button" id="show-password-btn" onclick="togglePassword()">Show Password</button>
                </div>
            </div>

            <div class="form-group login-button">
                <button class="btn-login" type="submit">Login</button>
            </div>
        </form>

        <div id="notification" class="notification-box">
            <?php
            session_start();
            if (isset($_SESSION["login_error"])) {
                echo '<div style="color: white;">' . $_SESSION["login_error"] . '</div>';
                unset($_SESSION["login_error"]); 
                echo '<script>
                        document.getElementById("notification").style.display = "block";
                    </script>';
            }
            ?>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
            // Function to toggle password visibility
            function togglePassword() {
                var passwordInput = document.getElementById("password");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            }

            // Show notification on page load
            var notification = document.getElementById("notification");
            if (notification) {
                notification.style.display = "block";
                setTimeout(function () {
                    notification.style.display = "none";
                }, 5000); // Hide after 5 seconds
            }

            // Attach the togglePassword function to the button click event
            var showPasswordBtn = document.getElementById("show-password-btn");
            if (showPasswordBtn) {
                showPasswordBtn.addEventListener("click", togglePassword);
            }
        });
    </script>

    </body>
    </html>