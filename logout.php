<?php
// Start the session
session_start();
// remove loggedin user id from session
unset($_SESSION["uname"]);
// redirect to Login
header("Location:login.php");
?>