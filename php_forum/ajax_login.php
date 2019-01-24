<?php
session_start();
include_once "db_config.php"; 

$res['res']	= false;
$login_id = $_POST['login_id'];
$login_pw = $_POST['login_pw'];

$sql = "SELECT * FROM $user_tbl_name WHERE user_id='$login_id' AND user_pw=password('$login_pw')";
// $sql = "SELECT EXISTS (SELECT * FROM $user_tbl_name WHERE user_id='$login_id' AND user_pw = password('$login_pw')) as success";
$result=mysqli_query($conn, $sql);
$rows= mysqli_fetch_array($result);
$rows_num = mysqli_num_rows($result);

if($rows_num == 1) {
	$_SESSION['user_name'] = $rows['user_name'];
	$_SESSION['user_id'] = $rows['user_id'];
	$res['res']	= true;
}

echo json_encode($res);
?>