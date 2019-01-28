<?php

include_once "db_config.php"; 

$topic_id=$_GET['topic_id'];

//find file_dir
$sql3 = "SELECT * FROM $upload_tbl_name WHERE topic_id='$topic_id'";
$result3 = mysqli_query($conn, $sql3);
//delete file_data
while($rows = mysqli_fetch_array($result3)) {
	unlink($rows['file_dir']);
}

//delete file db
$sql1 = "DELETE FROM $upload_tbl_name WHERE topic_id='$topic_id'";
$result1 = mysqli_query($conn, $sql1);
//delete topic
$sql="DELETE FROM $tbl_name WHERE topic_id='$topic_id'";
$result=mysqli_query($conn, $sql);

//remove folder
//rmdir("uploads/53");

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
	location.href="view_main.php";
</script>