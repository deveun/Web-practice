<?php
session_start();
include_once "db_config.php"; 

$_SESSION['user_name'] = '';
$_SESSION['user_id'] = '';
$res['res']	= true;

echo json_encode($res);
?>