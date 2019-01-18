<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="fquestions"; // Table name 

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");

// get value of id that sent from address bar 
$id=$_GET['id'];
$sql="SELECT * FROM $tbl_name WHERE id='$id'";
$result=mysqli_query($conn, $sql);
$rows=mysqli_fetch_array($result);
$view=$rows['view'];

// (조회수 0일때)if have no counter value set counter = 1
if(empty($view)){
	$view=1;
	$sql2="INSERT INTO $tbl_name(view) VALUES('$view') WHERE id='$id'";
	$result2=mysqli_query($conn, $sql2);
}

// (조회수)count more value
$addview=$view+1;
$sql3="UPDATE $tbl_name SET view='$addview' WHERE id='$id'";
$result3=mysqli_query($conn, $sql3);

// Check data for prev / next button
$sql4="SELECT * FROM $tbl_name WHERE id > '$id'";
$sql5="SELECT * FROM $tbl_name WHERE id < '$id' ORDER BY id DESC";
$result4=mysqli_query($conn, $sql4);
$result5=mysqli_query($conn, $sql5);
$rows_gt=mysqli_fetch_array($result4);
$rows_lt=mysqli_fetch_array($result5);
// echo $rows_gt['id'];
// echo $rows_lt['id'];
// echo isset($rows_gt['id']);
// echo isset($rows_lt['id']);

//Update data
// get data that sent from form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$topic = test_input($_POST["topic"]);
	$name = test_input($_POST["name"]);
	$detail = test_input($_POST["detail"]);
	$id = test_input($_POST["id"]);
	//$datetime=date("y/m/d h:i A"); //create date time
	$sql5="UPDATE $tbl_name SET topic='$topic', name='$name', detail='$detail' WHERE id='$id'";
	$result5=mysqli_query($conn, $sql5);
	echo "
	<script> 
	alert('수정완료');
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

<html>
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
	<link rel="stylesheet" href="css/styles.css?ver=6">
	<!-- Font Download (https://fonts.google.com/) ============= -->

	<!-- Icon Pack Download (https://fontawesome.com/)========== -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

</head>
<!-- /HEAD ==================================================== -->
<!-- ========================================================== -->
<!-- ========================================================== -->
<!-- BODY  ==================================================== -->
<body>
	<div class="container white p-1">
		<!-- View Table -->
		<table class="view_table table table-sm table-borderless mb-0">
			<thead>
				<tr>
					<td><b><?php echo $rows['topic']; ?></b></td>
					<td class="text-right"><?php echo $rows['datetime']; ?></td>
				</tr>
				<tr>
					<td colspan="2" class="border-bottom border-dark">작성자: <?php echo $rows['name']; ?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2"><?php echo $rows['detail']; ?></td>
				</tr>
				<tr>
					<td>
						<button class="btn btn-sm btn-default p-2" id="next_btn">&lt</button>
						<button class="btn btn-sm btn-default p-2" id="prev_btn">&gt</button>
					</td>
					<td class="text-right">
						<button class="btn btn-sm btn-default" id="update_btn">수정</button>
						<button class="btn btn-sm btn-default" onclick="delFunc()">삭제</button>
						<button class="btn btn-sm btn-default" onclick="goBack()">글목록</button>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /View Table -->
		<!-- Update Table -->
		<table class="update_table table table-sm table-borderless mb-0" style="display: none;">
			<!-- action= ....$_SERVER[PHP-SELF]... => Can be hacked. -->
			<!-- !!! Must use htemlspecialchars !!! -->
			<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<thead>
					<tr>
						<td width="10%">제목: </td>
						<td><input class="form-control" name="topic" type="text" id="topic" value= "<?php echo $rows['topic']; ?>" autocomplete="off"/>
						</td>
						<td class="text-right"><?php echo $rows['datetime']; ?></td>
					</tr>
					<tr>
						<td width="10%">작성자: </td>
						<td><input class="form-control" name="name" type="text" id="name" value= "<?php echo $rows['name']; ?>" autocomplete="off"/></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="3">
							<textarea class="form-control" name="detail" rows="3" id="detail" autocomplete="off"><?php echo $rows['detail']; ?></textarea>
						</td>
						<td class="d-none">
							<input class="form-control" name="id" type="text" id="id" value= "<?php echo $rows['id']; ?>" autocomplete="off"/></td>
						</tr>
						<tr>
							<td colspan="2">
							</td>
							<td class="text-right">
								<button class="btn btn-sm btn-default" type="submit" name="Submit">확인</button>
								<button class="btn btn-sm btn-default" type="button" id="cancel_btn">취소</button>
								<button class="btn btn-sm btn-default" type="button" onclick="location.href = 'main_forum.php'">글목록</button>
							</td>
						</tr>
					</tbody>
				</form>
			</table>
			<!-- Update Table -->
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
		<!-- /JavaScript CDN LIST ================================== -->

		<script>

			function goBack() {	window.history.back()	}

			function delFunc() {
				alert("정말로 삭제하시겠습니까?");
				location.href='delete_topic.php?id=<?php echo $rows['id']; ?>';
			}

			// NOT SOLVED !!!!!!!!!!!!diabled button!!!!!!!!!!!!!!!!
			// if(<?php echo isset($rows_gt['id'])?>)
			//  	$("#next_btn").prop('disabled',false);
			// if(<?php echo isset($rows_lt['id'])?>)
			//  	$("#prev_btn").prop('disabled',false);

			$("#next_btn").click( function () {
				location.href='view_topic.php?id=<?php echo $rows_gt['id']; ?>';
			});

			$("#prev_btn").click( function () {
				location.href='view_topic.php?id=<?php echo $rows_lt['id']; ?>';
			});

		</script>
		<script src="js/view_topic.js?ver=14"></script>
		<!-- ======================================================= -->
	</body>
	</html>