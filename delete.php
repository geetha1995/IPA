<?php 
// for the database connection include this file 
     require_once "database.php";

if(isset($_GET['id']))
{   // get task id from url
    $id=$_GET['id'];
    // delete the particular task by id
    $sql = "DELETE FROM tasks WHERE id='".$id."'";
    // if successfully deleted redirect to viewtasks.php
    if ($conn->query($sql)) {
        $data="viewtasks.php";
        echo json_encode($data);
  // if failed, display error message
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>
