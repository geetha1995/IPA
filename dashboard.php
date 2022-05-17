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
    <title>Dashboard von Aufgaben Erfassungstool</title>
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


        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="container mt-5 pt-5 w-75">
                <div class="row mt-5 mb-5">
                    <div class="text-info col-lg-12 col-md-12 col-sm-12">
                         <!-- set a heading in dashboard -->
                        <h3 class="border-bottom border-primary text-center cognizant"> Welcome to Task Tools</h3>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="text-center card text-white bg-primary " style=" max-width: 30.5rem; height: 120%;">
                            <div class="card-header">
                                Create new Task
                                <?php
                                // get the logged in userid via the session variable and assign to $id variable
                                $id = $_SESSION['uname'];

                                ?>
                            </div>
                            <div class="card-body">
                                <!-- button to create the Task-->
                                <a style="color:white" href="create.php"><button class="btn btn-success card-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                                        </svg>
                                    </button>
                                </a>
                                <p class="card-text">
                                    Create here your new task
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-lg-6 col-md-12 col-sm-12">
                        <div class="text-center card text-white bg-primary" style=" max-width: 30.5rem; height: 120%;">
                            <div class="card-header">
                                View your Tasklist
                            </div>
                            <div class="card-body">
                                <!-- button to view the all Task -->
                                <button class=" btn btn-success card-title" onclick="viewtasks()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                    </svg>

                                </button>
                                <p class="card-text">
                                    View your all available Tasks
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- include the file of footer in the dashboard footer -->
        <?php include_once('footer.php'); ?>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script>
            function createtask() {
                 // link of create a task button.
                location.href = "create.php";
            }

            function viewtasks() {
                 // link of view all tasks button.
                location.href = "viewtasks.php";
            }
        </script>
</body>


</html>