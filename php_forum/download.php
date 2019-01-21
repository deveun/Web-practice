<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="fquestions"; // Table name 
$upload_tbl_name="upload_file";

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");

// get value of id that sent from address bar 
$file_id=$_GET['file_id'];
$sql= "SELECT file_dir FROM $upload_tbl_name WHERE file_id='$file_id'" ;
$result=mysqli_query($conn, $sql);
$rows=mysqli_fetch_array($result);
$imgurl=$rows['file_dir'];
mysqli_close($conn);
?>

<html>
<head>
	
</head>
<body>
	<!-- <img src="<?php echo $imgurl ?>"> -->
</body>

<script type="text/javascript">
	document.location.href="<?php echo $imgurl ?>";
</script>