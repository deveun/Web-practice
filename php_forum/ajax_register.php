<?php
// *** REFERENCES ***
// ajax <-> php-->
// http://blog.naver.com/PostView.nhn?blogId=thav&logNo=220874940014
// mysql => using password() function, save DB 

include_once "db_config.php"; 

$reg_name = $_POST['reg_name'];
$reg_id = $_POST['reg_id'];
$reg_pw = $_POST['reg_pw'];

//need name
if($reg_name == '')
	$res['name']= 'noname';

//need id
if($reg_id == '')
	$res['id']= 'noid';

//need password
if($reg_pw == '')
	$res['pw']= 'nopw';


$sql = "SELECT count(*) AS total FROM $user_tbl_name WHERE user_id='$reg_id'";
$result=mysqli_query($conn, $sql);
$rows= mysqli_fetch_array($result);
$check = $rows['total'];

//check user_id is existed or not
if($check == 0 && $reg_name != '' && $reg_id != '' && $reg_pw != '') {
	$sql = "INSERT INTO $user_tbl_name (user_id, user_pw, user_name)VALUES('$reg_id', password('$reg_pw'), '$reg_name')";
	$result=mysqli_query($conn, $sql);
	$res['result']= 'ok';
}

if($check != 0) {
	$res['exist']= 'exist';
}


echo json_encode($res);
?>