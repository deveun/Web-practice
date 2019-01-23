<?php

include_once "db_config.php"; 

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