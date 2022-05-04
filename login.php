<?php
include('database.php');
session_start();
$empid = "";
$password    = "";

$pw_error = $empid_error =  $empidex_error = $empid_paterror = $login_error = '';

if (isset($_POST['login'])) {
    $empid = mysqli_real_escape_string($conn, $_POST['emp_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($_POST['emp_id'])) {
        $empid_error = "Employee Id is required";
    }
    if (!preg_match("/^([0-9]{6})$/ix", $empid) && (!empty($empid))) {
        $empid_paterror = "Employee Id format is wrong";
    }
    if (empty($_POST['password'])) {
        $pw_error = "Password is required";
    }
    $user_check_query = "SELECT * FROM users WHERE empId='$empid'";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);
    if ($count != 1  && (!empty($empid))) {
        $empidex_error = "EmployeeId is not exist";
    }
    $pw = md5($password);
    $user_check = "SELECT * FROM users WHERE empId='$empid' AND password='$pw' LIMIT 1";
    $result2 = mysqli_query($conn, $user_check);
    $row = mysqli_fetch_array($result2);
    $count2 = mysqli_num_rows($result2);
    // echo $count2;
    $user = mysqli_fetch_assoc($result);
    if ($count2 == 1 && !empty($empid) && !empty($password) && $row['status'] == 1) {
        $user= $row['id'];
        $_SESSION['uname']=$user;
        header("Location:dashboard.php");
        exit();
      
    } elseif ($count2 == 1 && !empty($empid) && !empty($password) && $row['status'] == null) {
        $_SESSION['name'] = "Your account hasnot been activated yet. please check your mail";
    } else {
        $_SESSION['name'] = "EmployeeId or Password is wrong";
    }
}
?>
<!doctype html>
<html lang="de">

<head>
    <title>Login Aufgaben Erfassungstool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
</head>

<body>
    <div class="container">
        <div class="row my-5">
            <div class="col text-center">
                <h2>Login</h2>
            </div>
        </div>

                

        <span class="text-danger"><?php if (isset($empidex_error)) echo $empidex_error; ?></span>
        <span class="text-danger"><?php if (isset($login_error)) echo $login_error;; ?></span>
        <?php
        if (isset($_SESSION['name'])) {
        ?>
            <span class="text-danger"><?php echo $_SESSION['name']; ?>
            </span>
        <?php
        }
        session_destroy();
        ?>


        <div class=" row border border-primary pd-4">
            <form action="login.php" method="POST">

                <div class="col-12 py-3">
                    <label>Cognizant ID*</label>
                    <input class="form-control" type="number" name="emp_id" value="<?php if (isset($empid)) echo $empid ?>" id="cognizantid" placeholder="756437">
                    <span class="text-danger"><?php if (isset($empid_error)) echo $empid_error; ?></span>
                    <span class="text-danger"><?php if (isset($empid_paterror)) echo $empid_paterror; ?></span>

                </div>
                <div class="col-12 py-3">
                    <label>Password*</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="password">
                    <span class="text-danger"><?php if (isset($pw_error)) echo $pw_error; ?></span>

                </div>
                <div class="text-danger col-12 py-3">
                    *mandatory fields
                </div>

                <div class="text-center col-lg-6 col-md-12 col-sm-12 py-3" id="loginmessage">

                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                    <button class="btn btn-success" type="submit" name="login">Login
                    </button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                <a class="mx-3" href="index.php">no account yet?</a>
                <a class="border-right border-primary"></a>
                <a class="mx-3" href="resetpassword.php">reset password</a>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>