<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Page Title</title>
	<!-- META TAG ============================================= -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap4.1.3 css ================================== -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<!-- MDB ==================================================== -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.6.1/css/mdb.min.css" rel="stylesheet">
	<!-- Additional Stylesheet =============================== -->
	<link rel="stylesheet" href="css/styles.css?ver=8">
	<!-- Font Download (https://fonts.google.com/) ============= -->

	<!-- Icon Pack Download (https://fontawesome.com/)========== -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<!-- CKeditor ============================================== -->
	<script src="ckeditor/ckeditor.js"></script>
	<!-- Jquery 3.2.1 ============================================= -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>


</head>
<!-- /HEAD ==================================================== -->
<!-- ========================================================== -->
<!-- ========================================================== -->
<!-- BODY  ==================================================== -->
<body>
	<?php 
	if($_SESSION['user_name'] !='') {	include_once "login_af.php";	}
	else { echo "	<script> alert('잘못된 접근입니다.');
	location.href='index.php';	</script>";  }
	?> 
	<div class="container white py-3">
		<table class="table table-sm col-6 mx-auto">
			<tr><td >이름: </td><td id="info_name"></td>	</tr>
			<tr><td>우편번호: </td><td id="info_post"></td></tr>
			<tr><td>주소: </td><td id="info_addr"></td></tr>
			<tr><td>상세주소: </td><td id="info_detailaddr"></td></tr>
		</table>
		<div class="d-flex justify-content-center">
			<button class="btn btn-default btn-sm m-2" onclick="location.href='view_edit_myinfo.php'">수정</button>
			<button class="btn btn-default btn-sm m-2" onclick="location.href='view_main.php'">확인</button>
		</div>
	</div>

	<!-- ========================================================== -->
	<!-- JavaScript CDN LIST ====================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- Popper.js 1.14.3 ========================================= -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umdpopper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<!-- Bootstrap 4.1.3 ========================================== -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!-- /JavaScript CDN LIST ================================== -->
	<!-- ======================================================= -->

</body>
</html>
<script>

		$.ajax({
			type : "POST",
			url : "ajax_myinfo.php",
			dataType: "json",
			error : function() {
				alert("통신실패");
			},
			success : function(data) {	

				$("#info_name").text(data.user_name);
				$("#info_post").text(data.post);
				$("#info_addr").text(data.address);
				$("#info_detailaddr").text(data.detail_address);
			}

		});
</script>