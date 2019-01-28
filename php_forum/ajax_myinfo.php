<?php
session_start();
include_once "db_config.php"; 

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM $user_tbl_name WHERE user_id='$user_id'";
// $sql = "SELECT EXISTS (SELECT * FROM $user_tbl_name WHERE user_id='$login_id' AND user_pw = password('$login_pw')) as success";
$result=mysqli_query($conn, $sql);
$rows= mysqli_fetch_array($result);
$res['user_name'] = $rows['user_name'];
$res['post'] = $rows['post'];
$res['address'] = $rows['address'];
$res['extra_address'] = $rows['extra_address'];
$res['detail_address'] = $rows['detail_address'];

echo json_encode($res, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>