<?php
// Start or resume the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the admin login page
echo"<script> window.location.href='admin login.php'</script>";
exit();
?>
