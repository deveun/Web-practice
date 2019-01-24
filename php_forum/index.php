<?php
session_start(); 
$_SESSION['category']="all";
$_SESSION['user_name']='';
$_SESSION['user_id']='';
?>
<script type="text/javascript">
	location.href='main_forum.php';
</script>