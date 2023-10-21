<?php


// Destroy the session
session_destroy();

// Redirect to the login page (index.php)
header("Location:../login.php");
exit;
?>
