<?php 
session_start();
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



</head>

<body>

<div id="wrapper">
        <?php include_once('navbar.php'); ?>
    
        <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="container mt-5 pt-5 w-75">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <h2 class="mt-3">View all Tasks</h2>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 text-right">
                        <button class="mt-2 btn btn-outline-success" onclick="createtask()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
  <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
</svg> Create new Task
                        </button>
                    </div>
                </div>
                <?php

                    // Include db file
                    require_once "database.php";
                    require_once "delete.php";

                    // Attempt select query execution
                    
$uname=  $_SESSION['uname'];
$sql = "SELECT * FROM tasks where user_id=$uname";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){

                            ?>
                <hr class="border-primary">
                        <div class="table-responsive">
                        <table class="table table-striped">
                        <thead>
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Taskname</th>
                        <th scope="col">Origin of Task</th>
                        <th scope="col">Description</th>
                        <th scope="col">Hours</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Status</th>
                        <th scope="col">Entry date</th>
                        <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php



while($row = mysqli_fetch_assoc($result)){
      
?>
                        <tr>
                        <th scope="row"><?php echo $row["id"] ?></th>
                       
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
                        <td>
                        <a href="singleviewtask.php?id=<?php echo $row["id"]; ?>"><span class="fa fa-eye"></span></a>
                        <a href="edit.php?id=<?php echo $row["id"]; ?>"><span class="fa fa-edit"></span></a>
                                <a href="#" data-id="<?php echo $row['id'];?>" class="delete"><span class="fa fa-trash"></span></a>

                        </td>
                        </tr>
                        <?php 
  }

?>
                        </tbody>
  
                        </table>
                    </div>
                    <?php
                        }
                    }
                        ?>
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
        url: "delete.php",
        ContentType: "application/json",
                data: {
            'id': id
        },
        success: function(data) {
            $('.modal').modal('hide');
            window.location.reload();

        }
    });

});
function createtask(){
location.href = "create.php";
}
</script>

</body>

</html>
<div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure!
            You want to delete the task?
            <input type="hidden" id="id">
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="yes"  class="btn btn-primary yes">Yes</button>
      </div>
    </div>
  </div>
</div>