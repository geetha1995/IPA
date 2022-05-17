<?php
// for the database connection include this file
include('database.php');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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

// sql to create tasks table
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

// for the security purpose password is encrypted
$password = md5('password'); 
//insert admin data into users table
$query = "INSERT INTO users (firstname,lastname,empId, email, password,role_id,status) 
         VALUES('Cognizant','Admin','123123', 'keethani@hotmail.com', '$password','1','1')";
$query_run = mysqli_query($conn, $query);
mysqli_close($conn);
