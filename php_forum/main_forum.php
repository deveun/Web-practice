<!-- ***REFERENCE *** --> 
<!-- http://pixelcode.co.uk/tutorials/php/simple-php-forum/ -->
<!-- Recent version than PHP7 : mysql... -> mysqli... -->

<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="fquestions"; // Table name 

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name ORDER BY id DESC";
// OREDER BY id DESC is order result by descending
$result=mysqli_query($conn, $sql);

//count topic num
$rows_num = mysqli_num_rows($result);
$num = 1;

//Search
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$s_type = test_input($_POST["s_type"]);
	$search = test_input($_POST["search"]);

	$sql2="SELECT * FROM $tbl_name WHERE $s_type like '%".$search."%' ";
	$result=mysqli_query($conn, $sql2);
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
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
	<link rel="stylesheet" href="css/styles.css?ver=14">
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
		<table class="main_table table table-sm table-hover text-center mb-0">
			<thead>
				<tr>
					<td width="10%"><strong>번호</strong></td>
					<td><strong>글제목</strong></td>
					<td><strong>작성자</strong></td>
					<td width="10%"><strong>조회수</strong></td>
					<td width="15%"><strong>작성일</strong></td>
				</tr>
			</thead>

			<tbody>
				<?php
// Start looping table row
				while($rows = mysqli_fetch_array($result)){
					?>
					<tr style="display: none" onClick = "location.href='view_topic.php?id=<?php echo $rows['id']; ?>'">
						<td><?php echo $num++; ?></td>
						<td><?php echo $rows['topic']; ?></td>
						<td><?php echo $rows['name']; ?></td>
						<td><?php echo $rows['view']; ?></td>
						<td><?php echo $rows['datetime']; ?></td>
					</tr>

					<?php
// Exit looping and close connection 
				}
				mysqli_close($conn);
				?>
			</tbody>
			<tfoot>
				<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<tr>
						<td>
							<select name="s_type" class="form-control form-control-sm">
								<option value="topic">제목</option>
								<option value="name">작성자</option>
							</select>
						</td>
						<td width="25%">
							<input class="form-control form-control-sm" name="search" type="text" id="search" autocomplete="off"/>
						</td>
						<td class="text-left">
							<button class="btn btn-sm btn-default" type="submit">검색</button>
						</td>
						<td class="text-right" colspan="2">
							<a role="button" class="btn btn-sm btn-default" href="new_topic.php"><strong>글작성</strong></a>
						</td>
					</tr>
				</form>
			</tfoot>
		</table><br>
		<!-- pagination -->
		<div><ul id="pagination" class="pagination-sm justify-content-center"></ul></div>
	</div>

	<!-- ========================================================== -->
	<!-- JavaScript CDN LIST ====================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Jquery 3.2.1 ============================================= -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- Popper.js 1.14.3 ========================================= -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<!-- Bootstrap 4.1.3 ========================================== -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!-- /JavaScript CDN LIST ===================================== -->
	<script src="js/jquery.twbsPagination.min.js"></script>
	<script type="text/javascript">

		//pages total number
		var tp = <?php echo ceil(($num-1)/5) ?>;
		//number of pages that page shows
		var vp = 5;
		//number of table rows that page shows
		var vt = 5;
		//Pagination
		$('#pagination').twbsPagination({
			totalPages: tp,
			visiblePages: vp,
			next: 'Next',
			prev: 'Prev',
			onPageClick: function (event, page) {
        //fetch content and render here
        //first, show all topic
        $(".main_table tbody tr").each(function(i) {
        	$(this).show();
        });

        //second, hide outrange topic
        $(".main_table tbody tr").each(function(i) {
        	if(parseInt($(this).children().eq(0).text()) >page*vt || parseInt($(this).children().eq(0).text()) <=(page-1)*vt)
        		$(this).hide();
        });
      }
    });
  </script>
  <!-- ========================================================== -->
</body>
</html>