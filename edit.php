<?php
session_start();
include('database.php');
?>
<!doctype html>
<html lang="de">

<head>
    <title>Edit task</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://resources.ctsapprentice.ch/css/main/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">



</head>

<body>
    <?php
    $id = $_GET['id'];
    $user_check = "SELECT * FROM tasks WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $user_check);
    $task = mysqli_fetch_array($result);
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

    $name_error = $originOfTask_error = $description_error = $deadline_error   = '';
    $uname=  $_SESSION['uname'];

    // REGISTER USER
    if (isset($_POST['update'])) {
                //     // receive all input values from the form
        $name =  $_POST['name'];
         $originOfTask =  $_POST['originOfTask'];
        $description =  $_POST['description'];
        $hours =  $_POST['hours'];
        $minutes =  $_POST['minutes'];
        $deadline =  $_POST['deadline'];
        $status =  $_POST['status'];
        $Id =  $_POST['Id'];
        // $entryDate =  $_POST['entry_date'];




            $update="update tasks set taskName='$name',
            description='$description', user_Id='$uname',hours='$hours',minutes='$minutes',deadline='$deadline',status='$status'  
            where id=$Id";
            $query_run = mysqli_query($conn, $update);
            if ($query_run) {
                header("location:viewtasks.php");
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

    ?>
    <div id="wrapper">
        <?php include_once('navbar.php'); ?>

        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="container mt-5 pt-5 w-75">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h2 class="mt-3">Edit Task</h2>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 text-right">
                        <button class="mt-2 btn btn-outline-primary" onclick="viewtasks()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                            </svg> view your all tasks
                        </button>
                    </div>
                </div>
                <hr class="border-primary">
                <div class="container">
                    <form action="edit.php" method="POST">
                        <div class="container">
                            <div class="form row mt-2">
                               
                                <div class="col-lg-12 col-md-12 col-sm-12 py-3  py-3">
                                    <label>Taskname*</label>
                                    <input class="form-control" name="name" type="text" value="<?php echo $task['taskName']?>" id="Taskname" placeholder="Taskname">
                               <?php if(isset($originOfTask)) echo $originOfTask?>
                                </div>
                            </div>
                            <div class="form row mt-2">
                                <div class="col-lg-12 col-md-12 col-sm-3 py-3 py-3">
                                    <label>Origin of Task*</label>
                                    <select id="originOfTask" class="custom-select" name="originOfTask">
                                        <option value="1" <?php echo $task['origin_task_id'] == '1' ? 'selected' : '' ?>>Company</option>
                                        <option value="2"<?php echo $task['origin_task_id'] == '1' ? 'selected' : '' ?>>School</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="Id" value="<?php echo $id ?>">
                            <div class="form row">
                                <div class="col-lg-12 col-md-12 col-sm-12 py-3">
                                    <label>description*</label>
                                    <textarea id="productdescription" name="description" class="form-control" rows="1" placeholder="description of your task"><?php echo $task['description'] ?></textarea>
                                </div>
                            </div>

                            <div class="form row">
                                <div class="col-lg-6 col-md-12 col-sm-12 py-3 py-3">
                                    <label>Task hours*</label>
                                    <input class="form-control" name="hours" type="text" value="<?php echo $task['hours'] ?>" id="hours" placeholder=00>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 py-3 py-3">
                                    <label>Task Minutes*</label>
                                    <input class="form-control" name="minutes" type="text" value="<?php echo $task['minutes'] ?>" id="Minutes" placeholder=00>
                                </div>
                            </div>
                            <div class="form row mt-2">
                                <div class="col-lg-12 col-md-12 col-sm-12 py-3 py-3">
                                    <label>Deadline*</label>
                                    <input class="form-control" name="deadline" type="date" value="<?php echo $task['deadline'] ?>" id="deadline" placeholder=01.01.2022>
                                </div>
                            </div>

                            <div class="form row">
                                <div class="col-lg-6 col-md-12 col-sm-3 py-3">
                                    <label>Status*</label>
                                    <select id="status" class="custom-select" name="status">
                                        <option value=""></option>
                                        <option selected value="4" <?php echo $task['status'] == '4' ? 'selected' : '' ?>>not Started</option>
                                        <option value="2" <?php echo $task['status'] == '2' ? 'selected' : '' ?>>in Procress</option>
                                        <option value="3" <?php echo $task['status'] == '3' ? 'selected' : '' ?>>on Hold</option>
                                        <option value="1" <?php echo $task['status'] == '1' ? 'selected' : '' ?>>done</option>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-3 py-3">
                                    <label>Task entry date*</label>
                                    <input class="form-control"  disabled name="entry_date" type="text" value="<?php echo $task['entryDate'] ?>" id="entrydate" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-danger col-12 pt-3  ">
                                    *mandatory fields
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 py-4 text-left" id="createtasksuccessmessage">

                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 py-3 text-right">
                                    <button type="submit" name="update" class="btn btn-outline-success"> Save
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        function viewtasks() {
            location.href = "viewtasks.php";
        }
    </script>

</body>

</html>