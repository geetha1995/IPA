<?php
// for the database connection include this file
include('database.php');
//Start the session
session_start();
//encrypt the password before saving in the database
$password = md5('password');

// initializing variables
$email = "";
$password    = "";
// define variables and set to empty values
$pw_error = $email_error =  $login_error = '';

// Login admin
if (isset($_POST['login'])) {
    // get the values from form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // check the validation
    if (empty($_POST['email'])) {
        $email_error = "Email is required";
    }
    // check the validation
    if (empty($_POST['password'])) {
        $pw_error = "Password is required";
    }
    //fetch the user by email 
    $user_check = "SELECT * FROM users WHERE email='$email'";
    $result2 = mysqli_query($conn, $user_check);
    $user = mysqli_fetch_assoc($result2);
    $count2 = mysqli_num_rows($result2);
    if ($count2 != 1  && (!empty($email))) { 
        // check whether the user  alreday exists or not
        $email_error = "EmployeeId is not exist.";
    }

    $pw = md5($password);
    // fetch user by email and password
    $user_check = "SELECT * FROM users WHERE email='$email' AND password='$pw' LIMIT 1"; 
    $result2 = mysqli_query($conn, $user_check);
    $row = mysqli_fetch_array($result2);
    $count2 = mysqli_num_rows($result2);
    $user = mysqli_fetch_assoc($result2);
    // the user is avilable and status is 1 successfuly logged in .so redirect to dashboard
    if ($count2 == 1 && !empty($email) && !empty($password) && $row['status'] == 1) { 
        // get the logged in user id
        $user = $row['id']; 
        //save the user id into session
        $_SESSION['uname'] = $user;
        //  redirect to admindashboard file
        header("Location:adminDashboard.php");
        exit();
    } else {
        //if password or mail incorrect show a error message
        $_SESSION['name'] = "Email or Password is wrong";
    }
}
?>

<!doctype html>
<html lang="de">

<head>
    <title>Admin Login Aufgaben Erfassungstool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
    <div class="container">
        <div class="row my-5">
            <div class="col text-center">
                <!-- set a heading in admin login page -->
                <h2 class="cognizant">Admin Login</h2>
            </div>
        </div>
        <div class=" row border border-primary pd-4">
            <form action="adminLogin.php" method="POST">
            <div class="col-12 py-3">
                <label>E-Mail*</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="admin.muster@gmail.com">
                <!-- set a error message -->
                <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>

            </div>
            <div class="col-12 py-3">
                <label>Password*</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="password">
                <!-- set a error message -->
                <span class="text-danger"><?php if (isset($pw_error)) echo $pw_error; ?></span>
 </div>
            <div class="text-danger col-12 py-3">
                *mandatory fields
            </div>

            <?php
            // Set session Variable
         if (isset($_SESSION['login'])) {
            ?>
            <!-- Set a error message -->
                <span class="text-danger"><?php echo $_SESSION['login']; ?>
                </span>
            <?php
            }
            ?>
            <?php
            // Set session Variable
            if (isset($_SESSION['name'])) {
            ?>
            <!-- Set a error message -->
                <span class="text-danger"><?php echo $_SESSION['name']; ?>
                </span>
            <?php
            } // destroy the session
            session_destroy();
            ?>

            <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                 <!-- Button for login the admin login form-->
                <button type="submit" class="btn btn-success" name="login">Login
                </button>
            </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                 <!-- Button for forgot password-->
                <a class="mx-3 cognizant" href="adminForgotPassword.php">forgot password</a>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>