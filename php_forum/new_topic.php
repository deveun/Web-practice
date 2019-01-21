<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="fquestions"; // Table name 

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");

// get data that sent from form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$topic = test_input($_POST["topic"]);
	$detail = $_POST["detail"];
	$name = test_input($_POST["name"]);
	$email = test_input($_POST["email"]);
	$datetime=date("y/m/d h:i A"); //create date time

	$sql="INSERT INTO $tbl_name(topic, detail, name, email, datetime)VALUES('$topic', '$detail', '$name', '$email', '$datetime')";
	
	$result=mysqli_query($conn, $sql);
	echo "
	<script> 
	alert('작성완료');
	document.location.href='main_forum.php';
	</script>"; 

}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
mysqli_close($conn);
?>

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


</head>
<!-- /HEAD ==================================================== -->
<!-- ========================================================== -->
<!-- ========================================================== -->
<!-- BODY  ==================================================== -->
<body>
	<div class="container white p-1">
		<table class="table w-8 table-sm table-borderless mb-0">
			<!-- action= ....$_SERVER[PHP-SELF]... => Can be hacked. -->
			<!-- !!! Must use htemlspecialchars !!! -->
			<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<thead>
					<tr>
						<td class="text-center" colspan="3"><b>새 글 작성하기</b></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-right"><b>제목</b></td>
						<td>:</td>
						<td><input class="form-control form-control-sm" name="topic" type="text" id="topic" autocomplete="off" required/></td>
					</tr>
					<tr>
						<td class="text-right"><b>작성자</b></td>
						<td>:</td>
						<td><input class="form-control form-control-sm" name="name" type="text" id="name" autocomplete="off" required/></td>
					</tr>
					<tr>
						<td class="text-right"><b>이메일</b></td>
						<td>:</td>
						<td><input class="form-control form-control-sm" name="email" type="text" id="email" autocomplete="off" required/></td>
					</tr>
					<tr>
						<td class="text-right d"><b>내용</b></td>
						<td class="d">:</td>
						<td><textarea class="form-control" name="detail" rows="3" id="ckeditor" required></textarea></td>
					</tr>
					<tr>
						<td colspan="3" class="text-right">
							<button class="btn btn-default btn-sm" type="submit" name="Submit">확인</button> 
							<button class="btn btn-default btn-sm" type="reset" onClick="location.href='main_forum.php'">취소</button>
						</td>
					</tr>
				</tbody>
			</form>
		</table>
	</div>

	<!-- ========================================================== -->
	<!-- JavaScript CDN LIST ====================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Jquery 3.2.1 ============================================= -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Popper.js 1.14.3 ========================================= -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umdpopper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<!-- Bootstrap 4.1.3 ========================================== -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	te
	<!-- /JavaScript CDN LIST ================================== -->
	<script>
		// Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('ckeditor');
  </script>
  <!-- ======================================================= -->

</body>
</html>