<!doctype html>
<html lang="de">
<head>
    <title>Forgotpassword Aufgaben Erfassungstool</title>
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

    function send_email_verify($email)
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
            $mail->addAddress($email);     //Add a recipient
    
            $mail->isHTML(true);        //Set email format to HTML
            $mail->Subject = 'Reset Password';
            $body = "<p style= color:#000048; font-size: 20px;><b>Welcome to Aufgabenerfassungstool Reset Password</b></p>
                     <p style= color: black; font-size: 20px;>Hello</p>
                     <p style= color: black; font-size: 20px;>Have you forget your Password!! Don't worry now you can Reset your Password</p>
                     click the below link for reset the password <a href='http://localhost/ipa/resetpassword.php?email=$email'>Reset Password</a>
                    <p style= color: black; font-size: 20px;>Thank you so much</p>
                    <p style= color: black; font-size: 20px;>Kindly Regards</p>
                    <p style= color: black; font-size: 20px;>Aufgabenerfassungstool Team</p>";
            $mail->Body    = $body;
    
            $mail->send();
            //echo 'Message has been sent';
            } catch (phpmailerException $e) {
                echo $e->errorMessage(); //error messages from PHPMailer
            } catch (Exception $e) {
                echo $e->getMessage(); //error messages from anything else!
            }
    }
    // initializing variables
    $email = "";
    // define variables and set to empty values
    $samemail_error =  $email_error =$success=$error= '';

    // send reset link to mail 
    if (isset($_POST['submit'])) {
        // receive all input values from the form
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // check the validation
        if (empty($email)) {
            $email_error = "Email is required";
        }
         // fetch user by email
        $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        // if user exists
        if ($user) {
           if (empty($email_error)) {
                // send reset link by mail function
                send_email_verify("$email");
                $success = " we have sent the password reset link to your mail";

                $email = "";
            }      
    }// error message, if the mail address is exists.
    else {
        $error = "Email is not exist in the system";
    }
    }

    ?>
    <div class="container">
        <div class="row my-5">
            <div class="col text-center">
                <!-- set a heading in forgot password page -->
                <h2 class="cognizant">Forgot Password</h2>
            </div>
        </div>
            <?php
            //Start the session
            session_start();
            ?>

        <div class=" row border border-primary pd-4">
            <div class="col-12 py-3">
                <form action="forgotpassword.php" method="POST">
                    <label>Email*</label>
                    <input class="form-control" type="email" name="email" id="repeatedpassword" placeholder="Email">
                      <!-- set a error message -->
                    <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>

            </div>
            <div class="text-danger col-12 py-3">
                *mandatory fields
            </div>
        <!-- set a error message -->
        <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
        <!-- set a success message -->
        <span class="text-success"><?php if (isset($success)) echo $success; ?></span>

            <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                <!-- Button for submit the form-->
                <button class="btn btn-success" type="submit" name="submit">Submit
                </button>
            </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 my-4 ml-4 text-right">
                <!-- Button for register-->
                <a class="mx-3 cognizant" href="index.php">no account yet?</a>
                <a class="border-right border-primary"></a>
                <!-- Button for user login -->
                <a class="mx-3 cognizant" href="login.php">already registered</a>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>