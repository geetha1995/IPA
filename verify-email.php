<?php
session_start();
// for the database connection include this file
include('database.php'); 
// if the email is set
if(isset($_GET['email'])){ 
    //get the email value from the url
    $email=$_GET['email']; 
    // find user by email
    $user="SELECT status,email FROM users where email='$email' LIMIT 1"; 
    $query_run = mysqli_query($conn, $user);
    // if the user exists in the users table go further
    if(mysqli_num_rows($query_run)>0){ 
        // $row variable conatins the particular user's details that is fetched from users table
        $row=mysqli_fetch_array($query_run); 
        //check whether the user's status is nul or not 
        if($row['status']==null){ 
            $email=$row['email'];
            // if the status is null then update the status as 1 which account is verfied
            $update_query="UPDATE users SET status='1' WHERE email='$email' LIMIT 1"; 
            $update_query_run = mysqli_query($conn, $update_query);
            if($update_query_run){
                $_SESSION['success'] = "Your account has been verified successfully";
                // if success redirect to login.php file
                header("Location:login.php"); 
            }
            else{
                $_SESSION['success'] = "verification fail";
                //if fail redirect to login page with error message
                header("Location:login.php"); 
            }

        }
        else{
            $_SESSION['error'] = "Email is already verified. you can login now";
            //if the account is already verified it will display this error message 
            header("Location:login.php"); 
        }
    }
}
