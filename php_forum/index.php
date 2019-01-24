<?php
session_start(); 
$_SESSION['category']="all";
$_SESSION['user_name']='';
$_SESSION['user_id']='';
?>
<script type="text/javascript">
	location.href='view_main.php';
</script>