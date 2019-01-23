<?php

include_once "db_config.php"; 

$id=$_GET['id'];

//find file_id
$sql2 = "SELECT * FROM $tbl_name WHERE id='$id'";
$result2 = mysqli_query($conn, $sql2);
$rows=mysqli_fetch_array($result2);
$file_id=$rows['file_id'];
//Delete topic
$sql="DELETE FROM $tbl_name WHERE id='$id'";
$result=mysqli_query($conn, $sql);
//find file_dir
$sql3 = "SELECT * FROM $upload_tbl_name WHERE file_id='$file_id'";
$result3 = mysqli_query($conn, $sql3);
$rows2 = mysqli_fetch_array($result3);
$file_dir = $rows2['file_dir'];
//delete file_data (delete only when file is existed)
if($file_id != '0') {
$sql4 = "DELETE FROM $upload_tbl_name WHERE file_id='$file_id'";
$result4 = mysqli_query($conn, $sql4);
unlink($file_dir);
}

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