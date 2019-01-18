<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="fquestions"; // Table name 

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password") or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");
$id=$_GET['id'];

//Delete topic
$sql="DELETE FROM $tbl_name WHERE id='$id'";
$result=mysqli_query($conn, $sql);

//Numbering Again
// $sql2="SELECT * FROM $tbl_name ORDER BY id DESC";
// $result2=mysqli_query($conn, $sql2);
// $new_id= 1;

// while($rows = mysqli_fetch_array($result2)){
// 	$sql3="UPDATE $tbl_name SET id='$new_id'";
// 	$result3=mysqli_query($conn, $sql3);
// 	$new_id = $new_id+1;
// }
?>
<script type="text/javascript">
	location.href="main_forum.php";
</script>