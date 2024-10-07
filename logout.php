<?php
session_start(); // Start the session

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header('Location: index.php');
exit;
