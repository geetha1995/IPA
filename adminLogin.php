<?php
include('database.php');
session_start();
$password = md5('password'); //encrypt the password before saving in the database

$email = "";
$password    = "";

$pw_error = $email_error =  $login_error = '';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($_POST['email'])) {
        $email_error = "Email is required";
    }

    if (empty($_POST['password'])) {
        $pw_error = "Password is required";
    }

    $pw = md5($password);
    $user_check = "SELECT * FROM users WHERE email='$email' AND password='$pw' LIMIT 1";
    $result2 = mysqli_query($conn, $user_check);
    $row = mysqli_fetch_array($result2);
    $count2 = mysqli_num_rows($result2);
    // echo $count2;
    $user = mysqli_fetch_assoc($result2);
    if ($count2 == 1 && !empty($email) && !empty($password) && $row['status'] == 1) {
        $user = $row['id'];
        echo $user;
        $_SESSION['uname'] = $user;
        header("Location:adminDashboard.php");
        exit();
    } else {
        $_SESSION['name'] = "Email or Password is wrong";
    }
}
?>

<!doctype html>
<html lang="de">

<head>
    <title>Admin Login Aufgaben Erfassungstool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
</head>

<body>
    <div class="container">
        <div class="row my-5">
            <div class="col text-center">
                <h2>Admin Login</h2>
            </div>
        </div>
        <?php
        if (isset($_SESSION['login'])) {
        ?>
            <span class="text-danger"><?php echo $_SESSION['login']; ?>
            </span>
        <?php
        }
        unset($_SESSION['login']);
        ?>
        <div class=" row border border-primary pd-4">
            <form action="adminLogin.php" method="POST">
            <div class="col-12 py-3">
                <label>E-Mail*</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="admin.muster@gmail.com">
                <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>

            </div>
            <div class="col-12 py-3">
                <label>Password*</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="password">
           
                <span class="text-danger"><?php if (isset($pw_error)) echo $pw_error; ?></span>
 </div>
            <div class="text-danger col-12 py-3">
                *mandatory fields
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                <button type="submit" class="btn btn-success" name="login">Login
                </button>
            </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                <a class="mx-3" href="adminForgotPassword.php">Forgotpassword</a>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>