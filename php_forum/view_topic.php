<?php

session_start();
include_once "db_config.php"; 

// get id, num that sent from address bar
if(!isset($_GET['topic_id'])) {
	echo "
	<script> 
	alert('잘못된 접근입니다.');
	document.location.href='view_main.php';
	</script>"; 
}
$topic_id=$_GET['topic_id'];
$num=$_GET['num'];
// show selected topic //$sql="SELECT * FROM $tbl_name WHERE id='$id'";
$sql= "SELECT * FROM $tbl_name WHERE topic_id='$topic_id'" ;
$result=mysqli_query($conn, $sql);
$rows=mysqli_fetch_array($result);
$view=$rows['view'];
$user_id = $rows['user_id'];
$category = $rows['category'];

// show all files attached to selected topic
$sql1= "SELECT * FROM $upload_tbl_name WHERE topic_id='$topic_id'" ;
$result1=mysqli_query($conn, $sql1);
$file_count=mysqli_num_rows($result1);

// Count total data
if($_SESSION['category'] == "my") {
	$sql3 = "SELECT count(*) AS total FROM $tbl_name WHERE user_id = '$user_id'";
	// Check data for prev / next button
	$sql4="SELECT * FROM $tbl_name WHERE user_id='$user_id' AND topic_id > '$topic_id'";
	$sql5="SELECT * FROM $tbl_name WHERE user_id='$user_id' AND topic_id < '$topic_id' ORDER BY topic_id DESC";
	
}
else if($_SESSION['category'] == "all") {
	$sql3 = "SELECT count(*) AS total FROM $tbl_name";
	// Check data for prev / next button
	$sql4="SELECT * FROM $tbl_name WHERE topic_id > '$topic_id'";
	$sql5="SELECT * FROM $tbl_name WHERE topic_id < '$topic_id' ORDER BY topic_id DESC";
	
}
else {
	$sql3 = "SELECT count(*) AS total FROM $tbl_name WHERE category = '$category'";
	// Check data for prev / next button
	$sql4="SELECT * FROM $tbl_name WHERE category='$category' AND topic_id > '$topic_id'";
	$sql5="SELECT * FROM $tbl_name WHERE category='$category' AND topic_id < '$topic_id' ORDER BY topic_id DESC";
}
$result3 = mysqli_query($conn, $sql3);
$rows1= mysqli_fetch_array($result3);
$row_num = $rows1['total'];

$result4=mysqli_query($conn, $sql4);
$result5=mysqli_query($conn, $sql5);
$rows_gt=mysqli_fetch_array($result4);
$rows_lt=mysqli_fetch_array($result5);

// (조회수)count more value
$addview=$view+1;
$sql2="UPDATE $tbl_name SET view='$addview' WHERE topic_id='$topic_id'";
$result2=mysqli_query($conn, $sql2);

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

	<!-- index -->
	<?php 
	if($_SESSION['user_name'] =='') {	include_once "login_bf.php";	}
	else { include_once "login_af.php"; } 
	?> 
	<div class="container white p-1">
		<!-- View Table -->
		<table class="view_table table table-borderless table-sm mb-0">
			<thead>
				<tr>
					<td colspan="3"><b><?php echo $rows['topic']; ?></b></td>
					<td class="text-right" width="20%"><?php echo $rows['datetime']; ?></td>
				</tr>
				<tr>
					<td colspan="4">작성자: <?php echo $rows['user_id']; ?></td>
				</tr>
				<tr>
					<td width="10%" class="border-bottom border-dark d">첨부파일:</td>
					<td colspan="3">
						<?php 
						while($rows_file=mysqli_fetch_array($result1)){ ?>
							<a class="file_info" href="<?php echo $rows_file['file_dir']; ?>" download="<?php echo $rows_file['file_name'].'.'.$rows_file['file_type']; ?>">
								<i class="far fa-save"></i> &nbsp;<?php echo $rows_file['file_name']; ?>
							</a><br>
						<?php } ?>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="4"><?php echo $rows['detail']; ?></td>
				</tr>
				<tr>
					<td colspan="2" width="15%">
						<button class="btn btn-sm btn-default p-2" id="next_btn">&lt</button>
						<button class="btn btn-sm btn-default p-2" id="prev_btn">&gt</button>
					</td>
					<td colspan="2" class="text-right">
						<button class="btn btn-sm btn-default" id="edit_btn" hidden>수정</button>
						<button class="btn btn-sm btn-default" id="delete_btn" hidden>삭제</button>
						<button class="btn btn-sm btn-default" onclick="location.href = 'view_main.php'">글목록</button>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /View Table -->
	</div>
	<div class="container p-0 white-text text-right">
		<?php echo $num?>/<?php echo $row_num?>
	</div>

	<!-- ========================================================== -->
	<!-- JavaScript CDN LIST ====================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	
	<!-- Popper.js 1.14.3 ========================================= -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umdpopper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<!-- Bootstrap 4.1.3 ========================================== -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!-- /JavaScript CDN LIST ================================== -->

	<script>

		//check login state (button hidden)
		if("<?php echo $_SESSION['user_id'];?>" != "" && "<?php echo $_SESSION['user_id'];?>" == "<?php echo $rows['user_id'];?>" ) {
			$("#delete_btn").removeAttr("hidden");
			$("#edit_btn").removeAttr("hidden");
		}

		//edit category default selected
		$('#<?php echo $category;?>').attr("selected","selected");

  	$("#delete_btn").click( function () {
  		if(confirm("정말로 삭제하시겠습니까?"))
  			location.href='s_delete.php?topic_id=<?php echo $rows['topic_id']; ?>';
  	});

  	//update button click -> change view
  	$("#edit_btn").click( function () {
  		location.href="view_edit.php?topic_id=<?php echo $topic_id; ?>";
  	});

		//cancel button click
		$("#cancel_btn").click( function () {
			location.href="view_topic.php?topic_id=<?php echo $topic_id; ?>&num=<?php echo $num;?>";
		});

		//button disability
		if(<?php echo $num?> == 1)
			$("#next_btn").prop('disabled',true);
		if(<?php echo $num?> == <?php echo $row_num?>)
			$("#prev_btn").prop('disabled',true);

		//<<<
		$("#next_btn").click( function () {
			location.href='view_topic.php?topic_id=<?php echo $rows_gt['topic_id'];?>&num=<?php echo $num-1;?>';
			return;
		});

		//>>>
		$("#prev_btn").click( function () {
			location.href='view_topic.php?topic_id=<?php echo $rows_lt['topic_id'];?>&num=<?php echo $num+1;?>';
			return;
		});
	</script>
	<!-- ======================================================= -->
</body>
</html>