<!doctype html>
<html lang="de">
    <head>
      <title>Resetpassword Aufgaben Erfassungstool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
    </head>
<body>
<!-- for the database connection include this file -->
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

        try{
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
    $password = "";
    $samepw    = "";
    
    // define variables and set to empty values
    $pw_validation_error=  $pw_error = $samepw_error  = '';

    // Password reset 
    if (isset($_POST['changepw'])) {
        // receive all input values from the form
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $samePassword = mysqli_real_escape_string($conn, $_POST['same-pw']);
        
       $email=$_POST['email'];
        // check the password validation
        if (empty($password)) {
            $pw_error = "Password is required";
        } 
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        /* check the password have a maximum 8 charachers lenth and maximum 1 number, 
        1 upper case and lower case letters and one special charachter */
        if((strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars)&& (!empty($password))) {
         $pw_validation_error= "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
        }// check the both passwords are match or not 
        if ($password != $samePassword) {
            $samepw_error = "The passwords do not match";
        }// find user by email
        $user = "SELECT * FROM users WHERE email='$email'  LIMIT 1";
        $result = mysqli_query($conn, $user);
        $user = mysqli_fetch_assoc($result);
        if($user){
        if (empty( $pw_validation_error|| $pw_error || $samepw_error)) {
            //encrypt the password before saving in the database
            $password = md5($password); 
            // update the user password
            $query = "UPDATE users SET password='$password' WHERE email='$email' LIMIT 1";
            $query_run = mysqli_query($conn, $query);
            if ($query_run) {
                // save the user name into session
                $_SESSION['name'] = "hi";
                // redirect to login file
                header("Location:login.php");

               // reset the email field empty after successfull reset password
                $email = "";
                exit();
            }
        }
    }
    }

    ?>
<div class="container">
<div class="row my-5">
            <div class="col text-center">
                 <!-- set a heading in resetpassword -->
                <h2 class="cognizant">Reset password</h2>
            </div>
        </div>
        <form action="resetpassword.php" method="POST">
        <div class=" row border border-primary pd-4">
        <div class="col-12 py-3">
                <label>Password*</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="password">
                <!-- set a error message -->
                <span class="text-danger"><?php if (isset($pw_error)) echo $pw_error; ?></span>
                <!-- set a password pattern validation error -->
                    <span class="text-danger"><?php if (isset($pw_validation_error)) echo $pw_validation_error ?></span><br>

            </div>
            <div class="col-12 py-3">
                <label>Repeat password*</label>
                <input class="form-control" type="password" name="same-pw" id="repeatedpassword" placeholder="repeat passsword">
                <!-- set a error message -->
                <span class="text-danger"><?php if (isset($samepw_error)) echo $samepw_error; ?></span>

            </div>
            <div class="text-danger col-12 py-3">
                *mandatory fields
            </div>
            <!-- <input type="hidden" name="email"value="<?php if (isset($_GET['email'])) echo $_GET['email'] ?>">
            <div class="text-center col-lg-6 col-md-12 col-sm-12 py-3" id="passwordmessage"> -->
        
            <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                <!-- Button for submit the change password form-->
                <button class="btn btn-success" type="submit" name="changepw">Change password
                </button>
            </div>
            </form>
            </div>

        </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>