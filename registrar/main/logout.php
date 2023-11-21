<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Return a JSON response indicating successful logout
echo json_encode(["success" => true]);
?>
