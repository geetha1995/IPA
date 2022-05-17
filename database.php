<?php
// Servername
$servername = "localhost";
// Username 
$username = "root";
// Database name
$db="taskerfassungstool";
// Password
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$conn) {
  ("Connection failed: " . mysqli_connect_error());
}
//  echo "Connected successfully";
?>