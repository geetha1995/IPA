<?php 
// for the database connection include this file 
require_once "database.php";

if(isset($_GET['id']))
{
    $id=$_GET['id'];
    // first delete all tasks of user
$sql = "DELETE FROM tasks WHERE user_Id='".$id."'"; 
//then delete particular user
$sql2 = "DELETE FROM users WHERE id='".$id."'"; 
$conn->query($sql);
$conn->query($sql2);
// if successfull, redirect to dashboard
    $data="adminDashboard.php";
    echo json_encode($data); 
}
?>