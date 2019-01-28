<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>

<div class="container px-0 d-flex mb-2">
	<div class="d-table-cell mr-auto align-items-center pt-3">
		<b class="text-default align-middle">회원등급</b>
		<span class="badge badge-default"><?php echo $_SESSION['user_grade'];?></span>
	</div>
	<div class="d-table-cell">
		<b class="text-default align-middle"><?php echo $_SESSION['user_name'];?>님(<?php echo $_SESSION['user_id'];?>)</b>
		<button class="btn btn-outline-default btn-sm px-2" id="myinfo_btn">
			<b>내정보</b>
		</button>
		<button class="btn btn-outline-default btn-sm px-2" id="my_btn">
			<b>내 글</b>
		</button>
		<button class="btn btn-outline-default btn-sm px-2" id="logout_btn">
			<i class="fas fa-sign-in-alt"></i> <b>logout</b>
		</button>
	</div>
</div>

<script>
	//my info
	$("#myinfo_btn").click( function () {
		location.href = 'view_myinfo.php';
	});

	//my post
	$("#my_btn").click( function () {
		location.href = 'view_main.php?category=my';
	});

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
				location.href="index.php";
			}

		});
	});
</script>