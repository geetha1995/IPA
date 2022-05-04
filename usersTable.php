<?php
include('database.php');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// $sql="CREATE TABLE parent (
//     id INT NOT NULL,
//     PRIMARY KEY (id)
// ) ";

// $sql2="CREATE TABLE child (
//     id INT,
//     parent_id INT,
//     INDEX par_ind (parent_id),
//     FOREIGN KEY (parent_id)
//         REFERENCES parent(id)
//         ON DELETE CASCADE
// ) ";
// sql to create users table
$sql = "CREATE TABLE users (
id INT NOT NULL AUTO_INCREMENT,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
status BOOLEAN,
role_id INT(2),
empId VARCHAR(10) UNIQUE,
password varchar(100) NOT NULL,
PRIMARY KEY (id)

)";
 
// // // sql to create users table
 $sql2 = "CREATE TABLE tasks (
id INT AUTO_INCREMENT ,
user_Id int,

    taskName VARCHAR(30) NOT NULL,
    description VARCHAR(255) NOT NULL,
    hours int NOT NULL,
    minutes int NOT NULL,
    deadline DATE,
    status INT,
    entryDate DATE,
    origin_task_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_Id)
        REFERENCES users(id)
        ON DELETE CASCADE  

        
         )";
          
if (mysqli_query($conn, $sql)) {
    echo "users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
if (mysqli_query($conn, $sql2)) {
    echo "tasks created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);

    // if (mysqli_query($conn, $sql2)) {
    //     echo "tasks created successfully";
    // } else {
    //     echo "Error creating table: " . mysqli_error($conn);
    // }
    
    // mysqli_close($conn);