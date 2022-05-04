<!doctype html>
<html lang="de">
    <head>
      <title>Resetpassword Aufgaben Erfassungstool</title>
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
        $mail->Password   = 'uvoyihzpjtjorywn';                               //app password

        //Recipients
        $mail->setFrom('suvarnanathan@gmail.com');
        $mail->addAddress($email, $fname);     //Add a recipient

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email verification';
        $body = "click the below link for verify the account <a href='http://localhost/ipa/verify-email.php?email=$email'>Verify Email</a>";
        $mail->Body    = $body;

        $mail->send();
        // echo 'Message has been sent';
    }
    // initializing variables
    $password = "";
    $samepw    = "";
    

    $pw_validation_error=  $pw_error = $samepw_error  = '';

    // REGISTER USER
    if (isset($_POST['changepw'])) {
        // receive all input values from the form
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $samePassword = mysqli_real_escape_string($conn, $_POST['same-pw']);
        
       $email=$_POST['email'];
    
        if (empty($password)) {
            $pw_error = "Password is required";
        }
 
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
         
        if((strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars)&& (!empty($password))) {
         $pw_validation_error= "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
        }
        if ($password != $samePassword) {
            $samepw_error = "The passwords do not match";
        }
        $user = "SELECT * FROM users WHERE email='$email'  LIMIT 1";
        $result = mysqli_query($conn, $user);
        $user = mysqli_fetch_assoc($result);
if($user){
        if (empty( $pw_validation_error|| $pw_error || $samepw_error)) {
            $password = md5($password); //encrypt the password before saving in the database

            $query = "UPDATE users SET password='$password' WHERE email='$email' LIMIT 1";
            $query_run = mysqli_query($conn, $query);
            if ($query_run) {
                $_SESSION['name'] = "hi";
                header("Location:login.php");

               
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
                <h2>Reset password</h2>
            </div>
        </div>
        <form action="forgotpassword.php" method="POST">
        <div class=" row border border-primary pd-4">
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
<input type="hidden" name="email"value="<?php if (isset($_GET['email'])) echo $_GET['email'] ?>">
            <div class="text-center col-lg-6 col-md-12 col-sm-12 py-3" id="passwordmessage">

        </div>
        
        <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                <button class="btn btn-success" type="submit" name="changepw">Change password
                </button>
            </div>
</form>
</div>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                    <a class="mx-3" href="index.php">no account yet?</a> 
                    <a class="border-right border-primary"></a>
                    <a class="mx-3" href="login.php">already registered</a>

                </div>
        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>