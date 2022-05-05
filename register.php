


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
        $mail->Port = 587;                                 //Enable SMTP authentication
        $mail->Username   = 'keethani96@gmail.com';                     //SMTP username
        $mail->Password   = 'rkteljhdtnpjlgcn';                               //app password

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

    $fname_error = $samemail_error = $sameempid_error = $lname_error = $empid_error = $email_error = $pw_error = $samepw_error = $email_paterror = $empid_paterror = '';

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
        // if (!preg_match("/^([A-Za-z])+([.])+([A-Za-z])+@cognizant.com$/ix", $email) && (!empty($email))) {
        //     $email_paterror = "Use the cognizant Email";
        // }
        if (empty($password)) {
            $pw_error = "Password is required";
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
        if (empty($samemail_error || $sameempid_error || $fname_error || $lname_error || $empid_error || $email_error || $email_paterror || $pw_error || $samepw_error)) {
            $password = md5($password); //encrypt the password before saving in the database

            $query = "INSERT INTO users (firstname,lastname,empId, email, password) 
  			  VALUES('$fname','$lname','$employeeId', '$email', '$password')";
            $query_run = mysqli_query($conn, $query);
            if ($query_run) {
                send_email_verify("$fname", "$email", $verifyToken);
                $success =1;
                header('location: index.php');
                exit();
            }
         
        }
    }

    ?>

