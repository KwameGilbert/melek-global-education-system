<?php
// logout.php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Remove the remember me cookie if it exists
if (isset($_COOKIE['token'])) {
    setcookie('token', '', 0 , '/', '', true, true);
}

// Redirect to login page
header('Location: ../logout/');
exit;
?>
