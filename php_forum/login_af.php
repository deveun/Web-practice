<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>

<div class="container px-0 t20 d-flex mb-2">
	<div class="d-table-cell ml-auto">
		<small class="text-default ml-auto align-middle"><?php echo $_SESSION['user_name'];?>님(<?php echo $_SESSION['user_id'];?>)</small>
		<button class="btn btn-outline-default btn-sm px-2" id="my_btn">
			<i class="fas fa-sign-in-alt"></i> <b>내 글</b>
		</button>
		<button class="btn btn-outline-default btn-sm px-2" id="logout_btn">
			<i class="fas fa-sign-in-alt"></i> <b>logout</b>
		</button>
	</div>
</div>

<script>
	//var login_info = "<?php echo $_SESSION['user_id']; ?>"; 
	$("#logout_btn").click( function () {

		$.ajax({
			type : "POST",
			url : "ajax_logout.php",
			error : function() {
				alert("통신실패");
			},
			success : function(data) {
				alert("로그아웃되었습니다.");
				location.href="main_forum.php";
			}

		});
	});
</script>