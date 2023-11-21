<?php
session_start(); // Start the session
?>
   <!DOCTYPE html>
    <html>
    <head>
        <title>Edit Profile</title>
        <style>
      body {
            font-family: Arial, sans-serif;
        }

        /* Center the form vertically and horizontally */
        body, html {
            height: 100%;
        }

        .container {
    width: 600px;
    height: 400px;
    margin: auto;
    position: absolute;
    top: 0; bottom: 0; left: 0; right: 0;
    padding: 20px; /* Add padding for the shadow effect */
    box-shadow: 0 0 10px rgba(0, 0, 255, 0.3); /* Add blue shadow with 10px blur */
    border: 2px solid #000000; /* Add blue border */
    border-radius: 10px;
}

  .form-group {
      margin-bottom: 15px;
  }

  .form-group label {
      display: block;
      font-weight: bold;
  }

  .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box; /* Add this line to include padding and border in the width */
    }

  .form-group input[type="password"] {
      font-size: 16px;
  }
  

  .btn-container {
      text-align: center;
  }

  .btn-container button {
      background-color: #007BFF;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
  }

  .btn-container button:hover {
      background-color: #0056b3;
  }

  .message {
      text-align: center;
      color: #ff0000;
  }

            .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #34418E;
      color: #fff ;
      padding: 20px 20px; 
    }

    .profile-icon {
      cursor: pointer;
    }

    .profile-info {
      position: absolute;
      top: 70px; 
      right: 20px;
      background-color: #fff;
      padding: 10px;
      display: none;
      border: 2px solid #34418E;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .profile-info:hover {
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    }

    .profile-info-content {
      text-align: center;
    }

    .profile-name {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #000; /* Add this line to set the text color to black */
    }

    .profile-link {
      text-decoration: none;
      background-color: #34418E;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      display: block;
      margin-bottom: 10px;
    }

    .profile-link:hover {
      background-color: #26508B;
    }

    .logout-button {
      background-color: #34418E;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .logout-button:hover {
      background-color: #26508B;
    }

    .logo-container {
      display: flex;
      align-items: center;
    }

    .logo {
      margin-right: 10px;
    }
  
    .profile-separator {
  border-top: 2px solid #34418E; /* Make the line 2px thick with the specified color */
  margin: 10px 0; /* Adjust the margin for spacing as needed */
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Add a shadow with 5px vertical offset, 15px blur, and 20% opacity */
}

.wide-button {
            width: 600px; /* Adjust the width as needed */
        }

      
        .gray-text {
    height: 40px;
    line-height: 40px;
    text-align: center; /* Center the text */
    background-color: transparent; /* Make it clear gray */
    border: none; /* Remove the border */
}


        .input-field {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        height: 40px; /* Set the desired height for input fields and buttons */
    }


        </style>
    </head>
    <body>
    <div class="top-bar">
    <div class="logo-container">
      <img class="logo" src="img/NU_shield.svg" alt="NU Logo" width="40" height="40">
      <span> NU LAGUNA<br>QUEUING SYSTEM</span>
    </div>
    <div class="profile-icon" onclick="toggleProfileInfo()">
      <img src="img/profile.png" alt="Profile Icon" width="40" height="40">
    </div>
    <div class="profile-info" id="profileInfo">
      <div class="profile-info-content">
        <p class="profile-name"><?php echo $_SESSION["user_name"]; ?></p> <!-- Display the user's name here -->
        <div class="profile-separator"></div> 
        <a href="editprofile.php" class="profile-link">Edit Profile</a>
        <button class="logout-button" onclick="logout()">Log out</button>
      </div>
    </div>
  </div>

  <script>
  function toggleProfileInfo() {
    var profileInfo = document.getElementById("profileInfo");
    profileInfo.style.display = profileInfo.style.display === "block" ? "none" : "block";
  }

  function logoutUser() {
  var confirmLogout = confirm("Are you sure you want to log out?");
  if (confirmLogout) {
    window.location.href = "../admin_login.php"; // Use the relative path to admin_login.php
  }
}
  </script>

<div class="container">
    <h1>Change Password</h1>
    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if the old password matches the current password (you should implement this part)
        $currentPassword = "admin_current_password"; // Replace with the actual current password

        if ($oldPassword === $currentPassword) {
            // Check if the new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Update the password (you should implement this part)
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                // Save $newPasswordHash to the admin's profile

                echo "<p class='message' style='color: green;'>Password changed successfully!</p>";
            } else {
                echo "<p class='message'>New password and confirm password do not match.</p>";
            }
        } else {
            echo "<p class='message'>Old password is incorrect.</p>";
        }
    }
    ?>
   <form method="POST">
        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" name="old_password" required>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" required>
        </div>

        <!-- Place the "Change Password" button in a container div -->
        <div class="btn-container">
    <button type="submit" class="wide-button">Submit</button>
    <a href="registrar_admin.php" class="gray-text" style="text-decoration: none;">Main Page</a>
</div>

    </form>
</div>

    </body>
    </html>


