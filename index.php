<?php
//Start the session
session_start();
?>
<!doctype html>
<html lang="de">

<head>
    <title>Register Aufgaben Erfassungstool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- for the database connection include this file -->
    <?php include('database.php');
    ?>
    <?php
    //header("X-XSS-Protection: 0");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    function send_email_verify($fname, $email, $verifyToken)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;                                 //Enable SMTP authentication
            $mail->Username   = 'keethani96@gmail.com';                     //SMTP username
            $mail->Password   = 'rkteljhdtnpjlgcn';                               //app password

            //Recipients
            $mail->setFrom('keethani96@gmail.com', 'Aufgabenerfassungstool');
            $mail->addAddress($email, $fname);     //Add a recipient

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email verification';
            $body = "<p style= color:#000048; font-size: 20px;><b>Welcome to Aufgabenerfassungstool E-Mail verifikation</b></p>
                 <p style= color: black; font-size: 20px;>Hallo $fname</p>
                 <p style= color: black; font-size: 20px;>We are happy because You are here</p>
                click the below link for verify the account <a href= 'http://localhost/ipa/verify-email.php?email=$email';>Verify Email</a>
                <p style= color: black; font-size: 20px;>Thank you so much $fname</p>
                <p style= color: black; font-size: 20px;>Kindly Regards</p>
                <p style= color: black; font-size: 20px;>Aufgabenerfassungstool Team</p>";
            $mail->Body    = $body;

            $mail->send();
            //echo 'Message has been sent';
        } catch (phpmailerException $e) {
            //error messages from PHPMailer
            echo $e->errorMessage(); 
        } catch (Exception $e) {
            //error messages from anything else!
            echo $e->getMessage(); 
        }
    }
    // initializing variables
    $fname = "";
    $lname    = "";
    $employeeId = "";
    $email = "";
    // define variables and set to empty values
    $pw_paterror = $fname_paterror = $lname_paterror = $pw_validation_error = $fname_error = $samemail_error = $sameempid_error = $lname_error = $empid_error = $email_error = $pw_error = $samepw_error = $email_paterror = $empid_paterror = '';

    // REGISTER USER
    if (isset($_POST['register'])) {
        // receive all input values from the form
        $fname = mysqli_real_escape_string($conn, $_POST['first-name']);
        $lname = mysqli_real_escape_string($conn, $_POST['last-name']);
        $employeeId = mysqli_real_escape_string($conn, $_POST['emp-id']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $samePassword = mysqli_real_escape_string($conn, $_POST['same-pw']);
        // generate token
        $verifyToken = md5(rand());
        
        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
         // check the validation
        if (empty($_POST['first-name'])) {
            $fname_error = "FirstName is required";
        } // check if name only contains letters and whitespace 
        if (!preg_match("/^([A-Za-z]{5,25})$/ix",  $fname) && (!empty($fname))) {
            $fname_paterror = "FirstName should contain only letters";
        } // check the validation
        if (empty($lname)) {
            $lname_error = "LastName is required";
        } // check if name only contains letters and whitespace 
        if (!preg_match("/^([A-Za-z]{5,25})$/ix", $lname) && (!empty($lname))) {
            $lname_paterror = "LastName should contain only letters";
        } // check the validation
        if (empty($employeeId)) {
            $empid_error = "EmployeeId is required";
        } //check if employee id format correct or not
        if (!preg_match("/^([0-9]{6})$/ix", $employeeId) && (!empty($employeeId))) {
            $empid_paterror = "Employee Id format is wrong";
        } // check the validation
        if (empty($email)) {
            $email_error = "Email is required";
        }
        if (!empty($email)) {
            $a = explode('@', $email);
            $foo = $a[1]; 
            // hier specially mention to do not use the cognizant email address
            if ($foo == 'cognizant.com') {
                $email_paterror = " Please use different Email";
            }
        }
         // check the validation
        if (empty($password)) {
            $pw_error = "Password is required";
        }
        //password validation
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        /* check the password have a maximum 8 charachers lenth and maximum 1 number, 
        1 upper case and lower case letters and one special charachter */
        if ((strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) && (!empty($password))) {
            $pw_validation_error = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
        }// check the both passwords are match or not 
        if ($password != $samePassword) {
            $samepw_error = "The passwords do not match";
        }// get the user by employeeid and email. because employee id is unique
        $user_check_query = "SELECT * FROM users WHERE empId='$employeeId' OR email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        // if user exists
        if ($user) { 
            if ($user['empId'] === $employeeId) {
                $sameempid_error = "EmployeeId already exists";
            }

            if ($user['email'] === $email) {
                $samemail_error = "email already exists";
            }
        }// if the form successfully submitted wthout any errors, then store into the users table
        if (empty($samemail_error || $fname_paterror || $lname_paterror || $pw_validation_error || $sameempid_error || $fname_error || $lname_error || $empid_error || $email_error || $email_paterror || $pw_error || $samepw_error)) {
            // encrypt the password before saving in the database
            $password = md5($password); 

            // store the user into the users table
            $query = "INSERT INTO users (firstname,lastname,empId, email, password,role_id) 
  			  VALUES('$fname','$lname','$employeeId', '$email', '$password','2')";
            $query_run = mysqli_query($conn, $query);
            if ($query_run) {
                send_email_verify("$fname", "$email", $verifyToken);
                // success messges for succesfully registered and verification mail sended.
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
                 <!-- set a heading in register page -->
                <h2 class="cognizant">Registrieren</h2>
            </div>
        </div>
        <form action="index.php" method="POST">
             <!-- Set a error message -->
            <span class="text-danger"><?php if (isset($sameempid_error)) echo $sameempid_error; ?></span>
             <!-- Set a error message -->
            <span class="text-danger"><?php if (isset($samemail_error)) echo $samemail_error; ?></span>


            <div class=" row border border-primary pd-4">
                <div class="col-12 py-3">
                    <label>Firstname*</label>
                    <input class="form-control" name="first-name" type="text" id="firstname" placeholder="Müller" value="<?php if (isset($fname)) echo $fname ?>">
                     <!-- Set a error message -->
                    <span class="text-danger"><?php if (isset($fname_error)) echo $fname_error; ?></span>
                     <!-- Set a pattern error message -->
                    <span class="text-danger"><?php if (isset($fname_paterror)) echo $fname_paterror ?></span><br>
                </div>
                <div class="col-12 py-3">
                    <label>Lastname*</label>
                    <input class="form-control" type="text" name="last-name" id="lastname" placeholder="Muster" value="<?php if (isset($lname)) echo $lname ?>">
                     <!-- Set a error message -->
                    <span class="text-danger"><?php if (isset($lname_error)) echo $lname_error; ?></span>
                     <!-- Set a pattern error message -->
                    <span class="text-danger"><?php if (isset($lname_paterror)) echo $lname_paterror ?></span><br>

                </div>
                <div class="col-12 py-3">
                    <label>Cognizant ID*</label>
                    <input class="form-control" type="number" name="emp-id" min="0" value="<?php if (isset($employeeId)) echo $employeeId ?>" id="cognizantid" placeholder="756437">
                     <!-- Set a error message -->
                    <span class="text-danger"><?php if (isset($empid_error)) echo $empid_error; ?></span>
                     <!-- Set a format error message -->
                    <span class="text-danger"><?php if (!empty($empid_paterror)) echo $empid_paterror ?></span><br>


                </div>
                <div class="col-12 py-3">
                    <label>Email*</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php if (isset($email)) echo $email ?>" placeholder="müller.muster@cognizant.com">
                     <!-- Set a pattern error message -->
                    <span class="text-danger"><?php if (!empty($email_paterror)) echo $email_paterror ?></span><br>
                     <!-- Set a error message -->
                    <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>

                </div>
                <div class="col-12 py-3">
                    <label>Password*</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="password">
                     <!-- Set a error message -->
                    <span class="text-danger"><?php if (isset($pw_error)) echo $pw_error; ?></span>
                     <!-- Set a validation error message -->
                    <span class="text-danger"><?php if (isset($pw_validation_error)) echo $pw_validation_error ?></span><br>

                </div>
                <div class="col-12 py-3">
                    <label>Repeat password*</label>
                    <input class="form-control" type="password" name="same-pw" id="repeatedpassword" placeholder="repeat passsword">
                     <!-- Set a password does not match error message -->
                    <span class="text-danger"><?php if (isset($samepw_error)) echo $samepw_error; ?></span>
                </div>
                <div class="text-danger col-12 py-3">
                    *mandatory fields
                </div>

                <?php
                //Set session Variable
                if (isset($_SESSION['success'])) {
                ?>
                 <!-- Set a success message -->
                    <span class="text-success"><?php echo $_SESSION['success']; ?>
                    </span>
                <?php
                }
                // destroy the session
                session_destroy();
                ?>

                <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                     <!-- Button for submit the register form-->
                    <button class="btn btn-success" type="submit" name="register">register
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                     <!-- Button for login page-->
                    <a class="cognizant" href="login.php">already registered?</a>
                </div>
            </div>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>