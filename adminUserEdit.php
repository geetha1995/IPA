<?php
// Start the session
session_start();
// for the database connection include this file
include('database.php');
 /* if the user logout already but try to go back using back button
    user redirects to adminLogin  with message  */
if (!isset($_SESSION['uname'])) {
    $_SESSION['login'] = "You have logout already. please login again";
    header("location:adminLogin.php");
}
?>
<!doctype html>
<html lang="de">

<head>
    <title>Admin User Edit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<?php
// fetch id from url by onclick editUser button
    $id = $_GET['id']; 
    ?>
<div id="wrapper">
        <?php include_once('adminNavbar.php'); ?>

        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="container mt-5 pt-5 w-75">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h2 class="mt-3 cognizant">Edit User</h2>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 text-right">
                    <a href="adminViewTask.php?id=<?php echo $id; ?>"><button class="mt-2 cognizant-btn" onclick="adminViewTask()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
</svg> view name all tasks
                        </button>
                    </a>
                    </div>
                </div>
                <hr class="border-primary">
                <div class="container">
                    <?php
                    // fetch user by id
                $user_check = "SELECT * FROM users WHERE id='$id' LIMIT 1"; 
    $result = mysqli_query($conn, $user_check);
    $user = mysqli_fetch_array($result);
    // if the update button is clicked
    if (isset($_POST['update'])) { 
        // ftech values from form
$firstname =  $_POST['firstname'];
$lastname =  $_POST['lastname'];
$id=$_POST['id'];


//update user details query
   $update="update users set firstname='$firstname',lastname='$lastname' where id=$id";
    $query_run = mysqli_query($conn, $update);
    if ($query_run) {
        // if updated successfully redirect to same page and pass id
        header("location:adminuseredit.php?id=".$id.""); 
       

    }

}
    ?>                    
    <form action="adminUserEdit.php" method="POST">

                    <div class="container">
                        <div class="form row mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 py-3  py-3">
                                <label>Firstname*</label>
                                <input class="form-control" name="firstname" type="text" id="Firstname" value="<?php echo $user['firstname']?>"placeholder="Firstname">
                            </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <div class="form row mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 py-3  py-3">
                                <label>Lastname*</label>
                                <input class="form-control" name="lastname" type="text" id="Lastname" value="<?php echo $user['lastname']?>" placeholder="Lastname">
                            </div>
                            </div>

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 py-3 text-right">
                                  <!-- Button for update the form -->
                                <button type="submit" name="update" class="btn btn-success"> Save
                                </button>
                            </div>

                        </div>
                        <form>
                    </div>
                    </div>
                
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>

function adminViewTask(){
// link of admin view task button.
location.href = "adminViewTask.php";
}
</script>

</body>
</html>