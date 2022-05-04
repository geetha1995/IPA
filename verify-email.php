<?php
session_start();
include('database.php');
if(isset($_GET['email'])){
    $email=$_GET['email'];
    $user="SELECT status,email FROM users where email='$email' LIMIT 1";
    $query_run = mysqli_query($conn, $user);
    if(mysqli_num_rows($query_run)>0){
        $row=mysqli_fetch_array($query_run);
        if($row['status']==null){
            $email=$row['email'];
            $update_query="UPDATE users SET status='1' WHERE email='$email' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);
            if($update_query_run){
                $_SESSION['success'] = "Your account has been verified successfully";
                header("Location:login.php");
            }
            else{
                $_SESSION['success'] = "verification fail";
                header("Location:login.php");
            }

        }
        else{
            $_SESSION['success'] = "Email is already verified. you can login now";
header("Location:login.php");
        }
    }
}
