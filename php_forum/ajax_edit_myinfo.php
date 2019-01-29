<?php
// *** REFERENCES ***
// ajax <-> php-->
// http://blog.naver.com/PostView.nhn?blogId=thav&logNo=220874940014
// mysql => using password() function, save DB 

include_once "db_config.php"; 

$user_id = $_POST['user_id'];
$pre_pw = $_POST['pre_pw'];
$new_pw = $_POST['new_pw'];
$new_post = $_POST['new_post'];
$new_addr = $_POST['new_addr'];
$new_extraaddr = $_POST['new_extraaddr'];
$new_detailaddr = $_POST['new_detailaddr'];

$sql = "SELECT * FROM $user_tbl_name WHERE user_pw = password('$pre_pw')" ;
$result = mysqli_query($conn, $sql);
$check = mysqli_num_rows($result);
$res['update']= 'no';

//need pre_pw
if($pre_pw == '')
	$res['pre_pw']= 'nopw';

//need address
else if($new_post == '' || $new_detailaddr == '')
	$res['addr']= 'noaddr';


else if($check == 1) {
	//change password & address
	if($new_pw != '') {
		$sql="UPDATE $user_tbl_name SET user_pw=password('$new_pw'), post='$new_post', address='$new_addr', extra_address='$new_extraaddr', detail_address='$new_detailaddr' WHERE user_id='$user_id' AND user_pw = password('$pre_pw')";
		$result=mysqli_query($conn, $sql);
		$res['update']= 'ok';

	}
//change address only
	else if($new_pw == '') {
		$sql2="UPDATE $user_tbl_name SET post='$new_post', address='$new_addr', extra_address='$new_extraaddr', detail_address='$new_detailaddr' WHERE user_id='$user_id' AND user_pw = password('$pre_pw')";
		$result2=mysqli_query($conn, $sql2);
		$res['update']= 'ok';
	}
}

echo json_encode($res);
?>