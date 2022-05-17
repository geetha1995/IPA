<?php
// Start the session
session_start();
// for the database connection include this file
include('database.php');
 /* if the user logout already but try to go back using back button
    user redirects to adminLogin  with message  */
if (!isset($_SESSION['uname'])) {
    $_SESSION['login'] = "You have logout already. please login again";
    header("location:login.php");
}
?>
<!doctype html>
<html lang="de">

<head>
    <title>View Single Task</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<div id="wrapper">
       <!-- include navbar file of user  -->
        <?php include_once('navbar.php'); ?>
        <?php
        // get the id of user from url
        $id = $_GET['id'];
        // fetch tasks by id
        $user_check = "SELECT * FROM tasks WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $user_check);
        $task = mysqli_fetch_array($result);
        ?>
        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="container mt-5 pt-5 w-75">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h2 class="mt-3 cognizant">View single Task</h2>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 text-right">
                        <!-- button for view all created tasks -->
                        <button class="mt-2 btn btn-success" onclick="viewtasks()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg> view all Tasks
                        </button>
                    </div>
                </div>
                <hr class="border-primary">
                <!-- all details of one selected task -->
                <div class="form-group">
                        <label>Taskname :</label>
                        <p><b><?php echo $task["taskName"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Origin of Task :</label>
                        <p><b><?php echo $task["origin_task_id"]=='1'?'Company':'School' ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Description :</label>
                        <p><b><?php echo $task["description"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Time allocted :</label>
                        <p><b><?php echo $task["hours"].':'.$task["minutes"] ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Deadline :</label>
                        <p><b><?php echo $task["deadline"] ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Status :</label>
                        <?php 
                        if($task["status"]==1){
                            $status='<span class="btn btn-success">Done</span>';

                        }
                        elseif($task["status"]==2){
                            $status='<span class="btn btn-info">In Progress</span>';

                        }elseif($task["status"]==3){
                            $status='<span class="btn btn-warning">On Hold</span>';

                        }else{
                            $status='<span class="btn btn-primary">Not Started</span>';

                        }
                        ?>
                        <p><b><?php echo $status; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Entry Date :</label>
                        <p><b><?php echo $task["entryDate"]; ?></b></p>
                    </div>
                    <!-- Back Button for go to back in to the view all Tasks file-->
                    <a href="viewtasks.php" class="cognizant-btn">Back</a>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>
function viewtasks(){
// link of view task button.
location.href = "viewtasks.php";
}
</script>
</body>
</html>