<?php
session_start();

?>


<!doctype html>
<html lang="de">

<head>
    <title>Register Aufgaben Erfassungstool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
</head>

<body>



    <?php include('database.php');
    ?>
    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    function send_email_verify($fname, $email, $verifyToken)
    {
        $mail = new PHPMailer(true);

        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 25;                                 //Enable SMTP authentication
        $mail->Username   = 'suvarnanathan@gmail.com';                     //SMTP username
        $mail->Password   = 'wmsjxxqnhlpaenef';                               //app password

        //Recipients
        $mail->setFrom('keethani96@gmail.com');
        $mail->addAddress($email, $fname);     //Add a recipient

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email verification';
        $body = "click the below link for verify the account <a href='http://localhost/ipa/verify-email.php?email=$email'>Verify Email</a>";
        $mail->Body    = $body;

        $mail->send();
        // echo 'Message has been sent';
    }
    // initializing variables
    $fname = "";
    $lname    = "";
    $employeeId = "";
    $email = "";

    $pw_paterror = $pw_validation_error = $fname_error = $samemail_error = $sameempid_error = $lname_error = $empid_error = $email_error = $pw_error = $samepw_error = $email_paterror = $empid_paterror = '';

    // REGISTER USER
    if (isset($_POST['register'])) {
        // receive all input values from the form
        $fname = mysqli_real_escape_string($conn, $_POST['first-name']);
        $lname = mysqli_real_escape_string($conn, $_POST['last-name']);
        $employeeId = mysqli_real_escape_string($conn, $_POST['emp-id']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $samePassword = mysqli_real_escape_string($conn, $_POST['same-pw']);
        $verifyToken = md5(rand());

        //         send_email_verify("$fname","$email",$verifyToken);
        // echo "sent";
        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($_POST['first-name'])) {
            $fname_error = "FirstName is required";
        }
        if (empty($lname)) {
            $lname_error = "LastName is required";
        }
        if (empty($employeeId)) {
            $empid_error = "EmployeeId is required";
        }
        if (!preg_match("/^([0-9]{6})$/ix", $employeeId) && (!empty($employeeId))) {
            $empid_paterror = "Employee Id format is wrong";
        }
        if (empty($email)) {
            $email_error = "Email is required";
        }
        $a = explode('@', $email);
        $foo = $a[1];
        if ($foo == 'cognizant.com') {
            $email_paterror = "Please Use different Email";
        }
        // if (!preg_match("/^([A-Za-z])+([.])+([A-Za-z])+@cognizant.com$/ix", $email) && (!empty($email))) {
        //     $email_paterror = "Use the cognizant Email";
        // }
        if (empty($password)) {
            $pw_error = "Password is required";
        }

        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if ((strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) && (!empty($password))) {
            $pw_validation_error = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
        }
        if ($password != $samePassword) {
            $samepw_error = "The passwords do not match";
        }
        $user_check_query = "SELECT * FROM users WHERE empId='$employeeId' OR email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['empId'] === $employeeId) {
                $sameempid_error = "EmployeeId already exists";
            }

            if ($user['email'] === $email) {
                $samemail_error = "email already exists";
            }
        }
        if (empty($samemail_error || $pw_validation_error || $sameempid_error || $fname_error || $lname_error || $empid_error || $email_error || $email_paterror || $pw_error || $samepw_error)) {
            $password = md5($password); //encrypt the password before saving in the database

            $query = "INSERT INTO users (firstname,lastname,empId, email, password,role_id) 
  			  VALUES('$fname','$lname','$employeeId', '$email', '$password','2')";
            $query_run = mysqli_query($conn, $query);
            if ($query_run) {
                send_email_verify("$fname", "$email", $verifyToken);
                $_SESSION['success'] = "You have succesfully registered. we have sent the email verification to your mail please verify the email";
                $fname = "";
                $lname    = "";
                $employeeId = "";
                $email = "";
            }
        }
    }

    ?>


    <div class="container">
        <div class="row my-5">
            <div class="col text-center">
                <h2>Registrieren</h2>
            </div>
        </div>
     
        <form action="index.php" method="POST">
            


            <div class=" row border border-primary pd-4">
                <div class="col-12 py-3">
                    <label>Firstname*</label>
                    <input class="form-control" name="first-name" type="text" id="firstname" value="<?php if (isset($fname)) echo $fname ?>" placeholder="Müller">
                    <span class="text-danger"><?php if (isset($fname_error)) echo $fname_error; ?></span>
                </div>
                <div class="col-12 py-3">
                    <label>Lastname*</label>
                    <input class="form-control" type="text" name="last-name" value="<?php if (isset($lname)) echo $lname ?>" id="lastname" placeholder="Muster">
                    <span class="text-danger"><?php if (isset($lname_error)) echo $lname_error; ?></span>
                </div>
                <div class="col-12 py-3">
                    <label>Cognizant ID*</label>
                    <input class="form-control" type="number" name="emp-id" min="0" value="<?php if (isset($employeeId)) echo $employeeId ?>" id="cognizantid" placeholder="756437">
                    <span class="text-danger"><?php if (isset($empid_error)) echo $empid_error; ?></span>
                    <span class="text-danger"><?php if (!empty($empid_paterror)) echo $empid_paterror ?></span><br>


                </div>
                <div class="col-12 py-3">
                    <label>Email*</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php if (isset($email)) echo $email ?>" placeholder="müller.muster@cognizant.com">
                    <span class="text-danger"><?php if (!empty($email_paterror)) echo $email_paterror ?></span><br>
                    <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>

                </div>
                <!-- <div class="col-12 py-3">
                    <label>Select Role*</label>
                    <select class="form-select" aria-label="Default select example">
  <option selected>Select Role</option>
  <option value="1">Ad</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>
                    <span class="text-danger"><?php if (!empty($email_paterror)) echo $email_paterror ?></span><br>
                    <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                </div> -->
                <div class="col-12 py-3">
                    <label>Password*</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="password">
                    <span class="text-danger"><?php if (isset($pw_error)) echo $pw_error; ?></span>
                    <span class="text-danger"><?php if (isset($pw_validation_error)) echo $pw_validation_error ?></span><br>

                </div>
                <div class="col-12 py-3">
                    <label>Repeat password*</label>
                    <input class="form-control" type="password" name="same-pw" id="repeatedpassword" placeholder="repeat passsword">
                    <span class="text-danger"><?php if (isset($samepw_error)) echo $samepw_error; ?></span>
                </div>
                <div class="text-danger col-12 py-3">
                    *mandatory fields
                </div>
                <?php
        if (isset($_SESSION['success'])) {
        ?>
            <span class="text-success"><?php echo $_SESSION['success']; ?>
            </span>
        <?php
        }
        session_destroy();
        ?>
        <span class="text-danger"><?php if (isset($sameempid_error)) echo $sameempid_error; ?></span>
            <span class="text-danger"><?php if (isset($samemail_error)) echo $samemail_error; ?></span>

                <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                    <button class="btn btn-success" type="submit" name="register">register
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                    <a href="login.php">already registered?</a>
                </div>
            </div>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>