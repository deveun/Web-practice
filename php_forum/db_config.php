<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="forum"; // Table name 
$upload_tbl_name="upload_file";
$user_tbl_name="users";

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");

?>