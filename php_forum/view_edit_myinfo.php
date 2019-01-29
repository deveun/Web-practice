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
	<!-- DAUM address API ========================================= -->
	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>


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
			<tr><td width="25%">이름: </td><td><?php echo $_SESSION['user_name'];?></td>	</tr>
			<tr><td>현재 비밀번호: </td><td><input id="pre_pw" type="password" class="form-control form-control-sm" autocomplete="off" required></td>	</tr>
			<tr><td>새 비밀번호: </td><td><input id="new_pw" type="password" class="form-control form-control-sm" autocomplete="off"></td>	</tr>
			<tr><td colspan="2">
				<form>
					<div class="form-group">
						<small class="form-text text-muted" id="addr_label">주소</small>
						<div class="d-flex align-items-center justify-content-between">
							<input id="new_post" type="text" class="form-control col-7" placeholder="우편번호" required readonly>
							<button id="api_btn" type="button" class="btn btn-sm btn-outline-default col-5 px-2 py-2">우편번호 찾기</button>
						</div>
						<input id="new_addr" type="text" class="form-control mb-1" placeholder="주소" required readonly>
						<input id="new_extraaddr" type="text" class="form-control mb-1" placeholder="참고항목" required readonly>
						<input id="new_detailaddr" type="text" class="form-control mb-1" placeholder="상세주소">
					</div>
					<!-- iframe section -->
					<div id="iframe" style="display:none;border:1px solid;height:300px;margin:2px 0;position:relative">
						<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
					</div>
				</form>
			</td></tr>
		</table>
		<div class="d-flex justify-content-center">
			<button class="btn btn-default btn-sm m-2" id="edit_btn">확인</button>
			<button class="btn btn-default btn-sm m-2" onclick="location.href='view_myinfo.php'">취소</button>
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

	//EDIT_INFO AJAX
	$("#edit_btn").click( function (e) {
		//IMPORTANT!!!!
		e.preventDefault();
		var user_id = '<?php echo $_SESSION['user_id'];?>';
		var pre_pw = $("#pre_pw").val();
		var new_pw = $("#new_pw").val();
		var new_post = $("#new_post").val();
		var new_addr = $("#new_addr").val();
		var new_extraaddr = $("#new_extraaddr").val();
		var new_detailaddr = $("#new_detailaddr").val();

		$.ajax({
			type : "POST",
			url : "ajax_edit_myinfo.php",
			data : {"user_id": user_id, "pre_pw": pre_pw, "new_pw":new_pw, "new_post":new_post, "new_addr" : new_addr, "new_extraaddr" : new_extraaddr, "new_detailaddr" : new_detailaddr },
			dataType: "json",
			error : function() {
				alert("통신실패");
			},
			success : function(data) {
				if(data.update =='ok')	{
					location.href="view_myinfo.php";
					return;
				}
				else if(data.pre_pw =='nopw') {
					alert("현재 비밀번호를 입력해주세요.");
				}
				else if(data.addr =='noaddr') {
					alert("주소를 다시 입력해주세요.");
				}
				else if(data.update =='no') {
					alert("현재 비밀번호가 틀렸습니다.");
				}
			}
		});
	});

	//ADDRESS DAUM API
	// 우편번호 찾기 찾기 화면을 넣을 element
	var element_wrap = document.getElementById('iframe');

	function foldDaumPostcode() {
  	// iframe을 넣은 element를 안보이게 한다.
  	element_wrap.style.display = 'none';
  }

  $("#api_btn").click( function (e) {
		//IMPORTANT!!!!
		e.preventDefault();

		new daum.Postcode({
			oncomplete: function(data) {
        // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

        // 각 주소의 노출 규칙에 따라 주소를 조합한다.
        // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
        // 주소 변수
        var addr = ''; 
        // 참고항목 변수
        var extraAddr = ''; 

        //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
        if (data.userSelectedType === 'R') { 
          // 사용자가 도로명 주소를 선택했을 경우
          addr = data.roadAddress;
        } 
        else { 
          // 사용자가 지번 주소를 선택했을 경우(J)
          addr = data.jibunAddress;
        }

        // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
        if(data.userSelectedType === 'R') {
          // 법정동명이 있을 경우 추가한다. (법정리는 제외)
          // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
          if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
          	extraAddr += data.bname;
          }
          // 건물명이 있고, 공동주택일 경우 추가한다.
          if(data.buildingName !== '' && data.apartment === 'Y'){
          	extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
          }
          // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
          if(extraAddr !== ''){
          	extraAddr = ' (' + extraAddr + ')';
          }
          // 조합된 참고항목을 해당 필드에 넣는다.
          document.getElementById("new_extraaddr").value = extraAddr;

        } 
        else {
        	document.getElementById("new_extraaddr").value = '';
        }

        // 우편번호와 주소 정보를 해당 필드에 넣는다.
        document.getElementById('new_post').value = data.zonecode;
        document.getElementById("new_addr").value = addr;
        // 커서를 상세주소 필드로 이동한다.
        document.getElementById("new_detailaddr").focus();

        // iframe을 넣은 element를 안보이게 한다.
        // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
        element_wrap.style.display = 'none';
      },
      // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
      onresize : function(size) {
      	//element_wrap.style.height = size.height+'px';
      },
      width : '100%',
      height : '100%'
    }).embed(element_wrap);

    // iframe을 넣은 element를 보이게 한다.
    element_wrap.style.display = 'block';
  });

</script>