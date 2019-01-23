<!-- ***REFERENCE *** --> 
<!-- http://pixelcode.co.uk/tutorials/php/simple-php-forum/ -->
<!-- Global Variables (SESSION): http://www.tizag.com/phpT/phpsessions.php -->
<!-- Recent version than PHP7 : mysql... -> mysqli... -->


<?php 
session_start();

include_once "db_config.php"; 

if(isset($_GET['category'])) {
	$category=$_GET['category'];
	$_SESSION['category'] = $category;
}

if($_SESSION['category'] != "all" )
{
	$sql="SELECT * FROM $tbl_name WHERE category = '".$_SESSION['category']."' ORDER BY id DESC";
}
else {
	$sql="SELECT * FROM $tbl_name ORDER BY id DESC";
}
// OREDER BY id DESC is order result by descending
$result=mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$s_type = test_input($_POST["s_type"]);
	$search = test_input($_POST["search"]);

	if($_SESSION['category'] != "all") {
		$sql2="SELECT * FROM $tbl_name WHERE category = '".$_SESSION['category']."' AND $s_type like '%".$search."%' ";
	}
	else {
		$sql2="SELECT * FROM $tbl_name WHERE $s_type like '%".$search."%' ";
	}
	$result=mysqli_query($conn, $sql2);
}
//count topic num
$rows_num = mysqli_num_rows($result);
$num = 1;

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

	<?php include_once "top_nav.php"; ?> 

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
					<tr style="display: none" onClick = "location.href='view_topic.php?id=<?php echo $rows['id'];?>&num=<?php echo $num;?>'">
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
					<input class="d-none" name="category" type="text" id="category" value= "<?php echo $category; ?>"/>
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

		//navbar active
		if("<?php echo $_SESSION['category'];?>" != "all") {
			$('.navbar-nav' ).find( 'li.active' ).removeClass('active');
			$('#<?php echo $_SESSION['category']?>' ).parent('li').addClass('active');
		}
		//pages total number
		var tp = <?php echo ceil(($num-1)/5); ?>;
		//number of pages that page shows
		var vp = 5;
		//number of table rows that page shows
		var vt = 5;
		//Pagination (at least one topic is needed)
		if(tp>0) {
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
		}
		else {
			var ins = 
			"<tr><td colspan=5>데이터가 존재하지 않습니다.</td></tr>";
			$('.table tbody').html(ins);
		}


		//////////
		$( '.navbar-nav a' ).on('click', function () {
			var category = $(this).attr('id');
			location.href = 'main_forum.php?category='+category;
		});
		//////////
    //Nav Click event
    // $("#all_nav").click( function () {
    // 	$("#all_nav").parent('li').addClass('active');
    // 	location.href = "main_forum.php?category=all";
    // });

    // $("#news_nav").click( function () {
    	
    // 	location.href = "main_forum.php?category=news";
    // });

    // $("#music_nav").click( function () {
    // 	$("#music_nav").parent('li').addClass('active');
    // 	location.href = "main_forum.php?category=music";	
    // });

    // $("#movie_nav").click( function () {
    // 	$("#movie_nav").parent('li').addClass('active');
    // 	location.href = "main_forum.php?category=movie";
    // });

    // $("#book_nav").click( function () {
    // 	$("#book_nav").parent('li').addClass('active');
    // 	location.href = "main_forum.php?category=book";
    // });

  </script>
  <!-- ========================================================== -->
</body>
</html>