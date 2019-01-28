<?php

session_start();
include_once "db_config.php"; 

// get id, num that sent from address bar 

$topic_id=$_GET['topic_id'];
//$sql="SELECT * FROM $tbl_name WHERE id='$id'";
$sql= "SELECT * FROM $tbl_name WHERE topic_id='$topic_id'" ;
$result=mysqli_query($conn, $sql);
$rows=mysqli_fetch_array($result);

// show all files attached to selected topic
$sql1= "SELECT * FROM $upload_tbl_name WHERE topic_id='$topic_id'" ;
$result1=mysqli_query($conn, $sql1);
$file_count=mysqli_num_rows($result1);

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
		<!-- Update Table -->
		<table class="update_table table table-sm table-borderless mb-0">
			<!-- action= ....$_SERVER[PHP-SELF]... => Can be hacked. -->
			<!-- !!! Must use htemlspecialchars !!! -->
			<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="s_edit.php">
				<thead>
					<tr>
						<td><b>카테고리</b></td>
						<td>:</td>
						<td>
							<input hidden name="topic_id" type="text" id="topic_id" value= "<?php echo $rows['topic_id']; ?>"/>
							<select class="custom-select" name="category" id="category">
								<option id="news" value="news">news</option>
								<option id="music" value="music">music</option>
								<option id="movie" value="movie">movie</option>
								<option id="book" value="book">book</option>
							</select>
						</td>
						<td class="text-right"><?php echo $rows['datetime']; ?></td>
					</tr>
					<tr>
						<td >제목 </td>
						<td>:</td>
						<td><input class="form-control" name="topic" type="text" id="topic" value= "<?php echo $rows['topic']; ?>" autocomplete="off"/>
						</td>
						
					</tr>
					<tr>
						<td >작성자 </td>
						<td>:</td>
						<td><input class="form-control" name="user_id" type="text" id="user_id" value= "<?php echo $rows['user_id']; ?>" disabled/><input name="user_id" value="<?php echo $_SESSION['user_id'];?>" type="hidden"/></td>
						<td></td>
					</tr>
					<tr>
						<td class="d">첨부파일</td>
						<td class="d">:</td>
					</td>
					<td class="d"><input class="add_file" name="file[]" type="file" multiple/><br>
						<?php 
						while($rows_file=mysqli_fetch_array($result1)){ ?>
							<a class="file_info" onClick="deleteFile(this)" id="<?php echo $rows_file['file_id'];?>">
								<i class="far fa-save"></i> &nbsp;<?php echo $rows_file['file_name']; ?> ..... <small>삭제</small>
								<br></a>
							<?php } ?>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="4">
							<textarea class="form-control" name="detail" rows="3" id="ckeditor" autocomplete="off"><?php echo $rows['detail']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" class="text-right">
							<button class="btn btn-sm btn-default" type="submit" name="Submit">확인</button>
							<button class="btn btn-sm btn-default" type="button" id="cancel_btn">취소</button>
							<button class="btn btn-sm btn-default" type="button" onclick="location.href = 'view_main.php'">글목록</button>
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
	
	<!-- Popper.js 1.14.3 ========================================= -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umdpopper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<!-- Bootstrap 4.1.3 ========================================== -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!-- /JavaScript CDN LIST ================================== -->

	<script>
		//maximum file upload number
		$upload_limit = 10;
		//delete file list and add input (to send s_edit)
		function deleteFile(e) {
			$(e).hide();
			$("#form1").append("<input type='hidden' name='file_id[]' value="+e.id+"/>");
			$upload_limit --;
			//alert(e.id);
		}

		//limit upload_file number
		$(".add_file").on("change", function() {
			if($(".add_file")[0].files.length > $upload_limit-parseInt(<?php echo $file_count?>)) {
				alert("최대 10개까지 첨부 가능합니다.");
				$(this).val('');
			}
		});

		//edit category default selected
		$("#category option[value=<?php echo $rows['category']; ?>]").attr("selected","selected");

		// Replace the <textarea id="editor1"> with a CKEditor
  	// instance, using default configuration.
  	CKEDITOR.replace('ckeditor');

		//cancel button click
		$("#cancel_btn").click( function () {
			window.history.back();
		});

		//delete attached file
		$("#del_file").click( function () {
			$('.file_info').addClass("d-none");
			$('#file').removeAttr("hidden");
			$('#delOk').val(1);
		});

	</script>
	<!-- ======================================================= -->
</body>
</html>