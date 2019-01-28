<?php
session_start();
include_once "db_config.php"; 

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy();

$res['res']	= true;

echo json_encode($res);
?>