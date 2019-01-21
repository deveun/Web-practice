<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="fquestions"; // Table name 

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password") or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");

//Update data
// get data that sent from form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$topic = test_input($_POST["topic"]);
	$name = test_input($_POST["name"]);
	$detail = $_POST["detail"];
	$id = test_input($_POST["id"]);
	//$datetime=date("y/m/d h:i A"); //create date time
	$sql="UPDATE $tbl_name SET topic='$topic', name='$name', detail='$detail' WHERE id='$id'";
	$result=mysqli_query($conn, $sql);
	echo "
	<script> 
	alert('수정완료');
	document.location.href='main_forum.php';
	</script>"; 
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

mysqli_close($conn);
?>
