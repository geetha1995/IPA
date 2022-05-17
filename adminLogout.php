<?php
// Start the session
session_start();
// remove loggedin user id from session
unset($_SESSION['uname']); 
// redirect to admin Login
header("Location:adminLogin.php"); 
?>