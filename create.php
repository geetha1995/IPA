<?php
// Start the session
session_start();
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
    <title>Create task</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
</head>
    <?php
    // Start the session
    session_start();
    ?>

    <body>
    <div id="wrapper">
         <!-- include navbar file of user  -->
        <?php include_once('navbar.php'); ?>
         <!-- for the database connection include this file -->
        <?php include('database.php');
        ?>
        <?php
        // initializing variables
        $name = "";
        $originOfTask = "";
        $description    = "";
        $hours = "";
        $minutes = "";
        $deadline = "";
        $status = "";
        $userId = "";
        $entryDate = "";

         // define variables and set to empty values
        $name_error =$hrs_error=$minutes_error= $originOfTask_error = $description_error = $deadline_error   = '';

        // Create Task
        if (isset($_POST['save'])) {
             // receive all input values from the form
            $name = mysqli_real_escape_string($conn, $_POST['taskname']);
            $originOfTask = mysqli_real_escape_string($conn, $_POST['originOfTask']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $hours = mysqli_real_escape_string($conn, $_POST['hours']);
            $minutes = mysqli_real_escape_string($conn, $_POST['minutes']);
            $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);
            $userId = mysqli_real_escape_string($conn, $_POST['userId']);
            $entryDate = mysqli_real_escape_string($conn, $_POST['entrydate']);

            // check the validation
            if (empty($name)) {
                $name_error = "Task Name is required";
            }// check the validation
            if (empty($hours)) {
                $hrs_error = "Task Hour is required";
            }// check the validation
            if (empty($minutes)) {
                $minutes_error = "Task Minutes is required";
            }// check the validation
            if (empty($originOfTask)) {
                $originOfTask_error = "Select Task Origin";
            }// check the validation
            if (empty($deadline)) {
                $deadline_error = "Deadline is required";
            }// if the form successfully submitted wthout any errors, then store into the tasks table
            if (empty($name_error || $hrs_error||$minutes_error || $originOfTask_error || $deadline_error)) {
                // store the tasks in to the tasks table
                $query = "INSERT INTO tasks (user_Id,taskName,description, hours, minutes,origin_task_id,deadline,status,entryDate) 
  			  VALUES('$userId','$name','$description', '$hours', '$minutes','$originOfTask','$deadline','$status','$entryDate')";
                $query_run = mysqli_query($conn, $query);
                if ($query_run) {
                    // if the insert successfull set a success message
                    $_SESSION['created'] = "Task has been created successfully";
                    // if the insert succesfull redirect to create.php file
                    header("location:create.php");
                     // initializing variables
                    $name = "";
                    $originOfTask = "";
                    $description    = "";
                    $hours = "";
                    $minutes = "";
                    $deadline = "";
                    $status = "";
                    $userId = "";
                    $entryDate = "";
                }
            }
        }

        ?>
        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="container mt-5 pt-5 w-75">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h2 class="mt-3 cognizant">Create Task</h2>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 text-right">
                        <!-- button for view all created tasks -->
                        <button class="mt-2 cognizant-btn" onclick="viewtasks()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                            </svg> view your all tasks
                        </button>
                    </div>
                </div>
                <hr class="border-primary">
                
                <div class="container">
                    <div class="form row mt-2">
                        <form action="create.php" method="POST">
                            <div class="col-lg-12 col-md-12 col-sm-12 py-3  py-3">
                                <label>Taskname*</label>
                                <input class="form-control" type="text" name="taskname" value="<?php if (isset($name)) echo $name ?>"id="Taskname" placeholder="Taskname">
                                 <!-- set a error message -->
                                <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>

                            </div>
                    </div>
                    <div class="form row mt-2">
                        <div class="col-lg-12 col-md-12 col-sm-3 py-3 py-3">
                            <label>Origin of Task*</label>
                            <!-- selet button with two options -->
                            <select id="originOfTask" name="originOfTask" class="custom-select">
                                <!-- if the particular task origin task is equal to 1 selected value is company else school -->
                                <option disabled selected>Select origin of Task</option>
                                <option value="1">Company</option>
                                <option value="2">School</option>
                            </select>
                             <!-- set a error message -->
                            <span class="text-danger"><?php if (isset($originOfTask_error)) echo $originOfTask_error; ?></span>

                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-lg-12 col-md-12 col-sm-12 py-3">
                            <!-- desctription is a optional -->
                            <label>description</label>
                            <textarea id="productdescription" name="description" class="form-control" rows="1" value="<?php if (isset($description)) echo $description ?>" placeholder="description of your task"></textarea>

                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-lg-6 col-md-12 col-sm-12 py-3 py-3">
                            <label>Task hours*</label>
                              <!-- task hours should be greater than or equal to 0 -->
                            <input class="form-control" type="number" min="0" name="hours" value="<?php if (isset($hours)) echo $hours ?>"id="hours" placeholder=00>
                             <!-- set a error message -->
                            <span class="text-danger"><?php if (isset($hrs_error)) echo $hrs_error; ?></span>

                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 py-3 py-3">
                            <label>Task Minutes*</label>
                              <!-- task minutes should be greater than or equal to 0 -->
                            <input class="form-control" type="number" min="0" name="minutes"  value="<?php if (isset($minutes)) echo $minutes ?>" id="Minutes" placeholder=00>
                             <!-- set a error message -->
                            <span class="text-danger"><?php if (isset($minutes_error)) echo $minutes_error; ?></span>

                        </div>
                    </div>
                    <div class="form row mt-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 py-3 py-3">
                            <label>Deadline*</label>
                            <input class="form-control" type="date" name="deadline" value="<?php if (isset($deadline)) echo $deadline ?>" value="dd-mm-yyyy" id="deadline" placeholder=01.01.2022>
                             <!-- set a error message -->
                            <span class="text-danger"><?php if (isset($deadline_error)) echo $deadline_error; ?></span>

                        </div>
                    </div>

                    <div class="form row">
                        <div class="col-lg-6 col-md-12 col-sm-3 py-3">
                            <label>Status*</label>
                            <!-- select button with four options -->
                            <select id="status" name="status" class="custom-select">
                                <option selected value="4">not Started</option>
                                <option value="2">in Procress</option>
                                <option value="3">on Hold</option>
                                <option value="1">done</option>

                            </select>
                        </div>
                        <?php
                        //
                        $uname =  $_SESSION['uname'];
                        ?>
                        <input class="form-control" type="hidden" value="<?php echo $uname ?>" name="userId" id="entrydate" placeholder=01.01.2022>

                        <div class="col-lg-6 col-md-12 col-sm-3 py-3">
                            <label>Task entry date*</label>
                             <!-- entry date is disbaled no one can change it -->
                            <input class="form-control" disabled type="text"  value="<?php echo date('Y/m/d') ?>" id="entrydate" placeholder=01.01.2022>
                        </div>
                        <input type="hidden" name="entrydate" value="<?php echo date('Y/m/d') ?>">

                    </div>
                    <div class="row">
                        <div class="text-danger col-12 pt-3  ">
                            *mandatory fields
                        </div>
                    </div>
                    <?php
                      // Set session Variable
                    if (isset($_SESSION['created'])) {
                    ?>
                        <!-- Set a success message -->
                        <span class="text-success"><?php echo $_SESSION['created']; ?>
                        </span>
                    <?php
                    }
                    ?>

                        <div class="col-lg-12 col-md-12 col-sm-12 py-3 text-right">
                            <!-- Button for submit the create task form-->
                            <button type="submit" name="save" class="btn btn-success"> Save
                            </button>
                        </div>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- page-content-wrapper -->
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        function viewtasks() {
            // link of view task button.
            location.href = "viewtasks.php";
        }
    </script>

</body>

</html>