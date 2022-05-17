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
    <title>view All tasks of User</title>
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
        <!-- include navbar file of admin  -->
        <?php include_once('adminNavbar.php'); ?>
        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="container mt-5 pt-5 w-75">
            <?php
            // get the id of user from url
            $id = $_GET['id']; 
            // fetch user by id
            $user = "SELECT * FROM users where id=$id LIMIT 1"; 
            $result2 = mysqli_query($conn, $user);
            $row = mysqli_fetch_array($result2);
            ?>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <!-- display  user firstname and lastname -->
                        <h2 class="mt-3 cognizant"><?php echo $row['firstname'].' '.$row['lastname']?></h2> 
                    </div>
                    <!-- edit user button  -->
                    <div class="col-lg-6 col-md-12 col-sm-12 text-right">
                        <a href="adminuseredit.php?id=<?php echo $id; ?>" style="color:white"><button class="mt-2 btn btn-outline-success" onclick="adminuseredit()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg> Edit User
                        </button>
                        </a>
                        <!-- delete user button -->
                        <a  data-id="<?php echo $id;?>" class="delete"><button class="mt-2 btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg> Delete User
                        </button>
                        </a>
                    </div>
                </div>
                <hr class="border-primary">
                        <div class="table-responsive">
                        <table class="table table-striped">
                        <thead>
                        <tr>
                        <th scope="col">Taskname</th>
                        <th scope="col">Origin of Task</th>
                        <th scope="col">Description</th>
                        <th scope="col">Hours</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Status</th>
                        <th scope="col">Entry date</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // fetch all the tasks of particular user bu user_id
                            $user_check = "SELECT * FROM tasks WHERE user_Id='$id'"; 
                       
                            $result = mysqli_query($conn, $user_check);
                            while($row = mysqli_fetch_assoc($result)){                            
                                ?>
                                <tr>                              
                                <td><?php echo $row["taskName"] ?></td>
                                <td><?php echo $row["origin_task_id"]=='1'?'Company':'School' ?></td>
                                <td><?php echo $row["description"] ?></td>
                                <td><?php echo $row["hours"].':'.$row["minutes"] ?></td>
                                <td><?php echo $row["deadline"] ?></td>
                                <?php 
                                if($row["status"]==1){
                                    $status="Done";
        
                                }
                                elseif($row["status"]==2){
                                    $status="In Progress";
        
                                }elseif($row["status"]==3){
                                    $status="On Hold";
        
                                }else{
                                    $status="Not Started";
        
                                }
                                ?>
                                <td><?php echo $status ?></td>
                                <td><?php echo $row["entryDate"] ?></td>                                
                                </tr>
                                <?php 
          }        
        ?>
                        <tr>                       
                        </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
                    
</div>
</div>
</div>

   

	<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script>
    //delete function of admin user delete file
$(document).on('click', '.delete', function() {

        var id = $(this).attr("data-id")
        $('.modal').modal('show');
        $('#id').val(id);

    });
    $(document).on('click', '.yes', function(e) {
    e.preventDefault();
    var id = $('#id').val();
    $.ajax({
        type: "GET",
        url: "adminUserDelete.php",
        ContentType: "application/json",
                data: {
            'id': id
        },
        success: function(data) {
            $('.modal').modal('hide');
            window.location.href='adminDashboard.php';

        }
    });

});
</script>
<div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title cognizant">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure!<br>
            Do you want to delete the user?
            <input type="hidden" id="id">
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="yes"  class="btn cognizant-btn yes">Yes</button>
      </div>
    </div>
  </div>
</div>