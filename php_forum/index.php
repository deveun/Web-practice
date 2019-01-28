<?php
session_start(); 
$_SESSION['category']="all";
$_SESSION['user_name']='';
$_SESSION['user_id']='';
$_SESSION['user_grade']='';
?>
<script type="text/javascript">
	location.href='view_main.php';
</script>