<?php
header("X-XSS-Protection: 0");
// for the database connection include this file 
include('database.php');
// Start the session
session_start();

// initializing variables
$empid = "";
$password    = "";

// define variables and set to empty values
$pw_error = $empid_error =  $empidex_error = $empid_paterror = $login_error = '';

// login user
if (isset($_POST['login'])) {
    // $empid = mysqli_real_escape_string($conn, $_POST['emp_id']);
    // $password = mysqli_real_escape_string($conn, $_POST['password']);
    // receive all input values from the form
    $empid = $_POST['emp_id'];
    $password = $_POST['password'];

    //echo 'hello, ' . $empid . $password;
    //<img src onerror="alert(hacked)">

    // check the validation
  
    // fetch user by empid
    $user_check_query = "SELECT * FROM users WHERE empId='$empid'";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);
    if ($count != 1  && (!empty($empid))) {
        // check whether the employee id alreday exists or not
        $empidex_error = "EmployeeId is not exist.";
    }
    $pw = md5($password);
    // fetch user by empid and password
    $user_check = "SELECT * FROM users WHERE empId='$empid' AND password='$pw' LIMIT 1";
    $result2 = mysqli_query($conn, $user_check);
    $row = mysqli_fetch_array($result2);
    $count2 = mysqli_num_rows($result2);
    $user = mysqli_fetch_assoc($result);
     // the user is evailable and status is 1 successfuly logged in .so redirect to dashboard
    if ($count2 == 1 && !empty($empid) && !empty($password) && $row['status'] == 1) {
         // get the logged in user id
        $user = $row['id'];
        //save the user id into session
        $_SESSION['uname'] = $user;
          //  redirect to dashboard file
        header("Location:dashboard.php");
        exit();
        //check the status is null or 1
    } elseif ($count2 == 1 && !empty($empid) && !empty($password) && $row['status'] == null) {
        // error message, if the user is not verify the email
        $_SESSION['name'] = "Your account hasnot been activated yet. please check your mail";
    } else { // error message, if the user write a incorrect password or employeeId
        $_SESSION['name'] = "EmployeeId or Password is wrong";
    }
}
?>
<!doctype html>
<html lang="de">

<head>
    <title>Login Aufgaben Erfassungstool</title>
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
                <!-- set a heading in login page -->
                <h2 class="cognizant">Login</h2>
            </div>
        </div>
        <?php       //Set session Variable
                    if (isset($_SESSION['success'])) {
                    ?>
                      <!-- Set a success message -->
                        <span class="text-success"><?php echo $_SESSION['success']; ?>
                        </span>
                    <?php
                    }
                    //Set session Variable
                    if (isset($_SESSION['error'])){
                       ?>
                         <!-- Set a error message -->
                        <span class="text-danger"><?php echo $_SESSION['error']; ?>
                        </span> 
                        <?php 
                    }
                    // remove all session variables
                    unset($_SESSION['error']);
                    unset($_SESSION['success']);

                    ?>
        <div class=" row border border-primary pd-4">
            <form action="login.php" method="POST">

                <div class="col-12 py-3">
                    <label>Cognizant ID*</label>
                    <input class="form-control" type="number" name="emp_id" value="<?php if (isset($empid)) echo $empid ?>" id="cognizantid" placeholder="756437">
                    <!-- set a error message -->
                    <span class="text-danger"><?php if (isset($empid_error)) echo $empid_error; ?></span>
                    <!-- set a error message -->
                    <span class="text-danger"><?php if (isset($empid_paterror)) echo $empid_paterror; ?></span>

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
                    <!-- set a error message -->
                    <span class="text-danger"><?php if (isset($empidex_error)) echo $empidex_error; ?></span>
                    <!-- set a error message -->
                    <span class="text-danger"><?php if (isset($login_error)) echo $login_error;; ?></span>
                    <?php
                    // Set session Variable
                    if (isset($_SESSION['login'])) {
                    ?> <!-- Set a error message -->
                        <span class="text-danger"><?php echo $_SESSION['login']; ?>
                        </span>
                    <?php
                    }
                    // remove session variable
                    unset($_SESSION['login']);
                    ?>
                    <?php
                    // Set session Variable
                    if (isset($_SESSION['name'])) {
                    ?>
                     <!-- Set a error message -->
                        <span class="text-danger"><?php echo $_SESSION['name']; ?>
                        </span>
                    <?php
                    }
                    // destroy the session
                    session_destroy();
                    ?>

                <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                    <!-- Button for login the user login form-->
                    <button class="btn btn-success" type="submit" name="login">Login
                    </button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                <!-- Button for register-->
                <a class="mx-3 cognizant" href="index.php">no account yet?</a>
                <a class="border-right border-primary"></a>
                <!-- Button for forgot password-->
                <a class="mx-3 cognizant" href="forgotpassword.php">Forgotpassword</a>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>