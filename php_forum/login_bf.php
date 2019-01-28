<div class="wrap">
	<div class="container px-0 text-right t17 d-flex flex-row mb-2">
		<button data-toggle="modal" data-target="#modalLoginForm" class="btn btn-outline-default btn-sm ml-auto px-2">
			<i class="fas fa-sign-in-alt"></i> <b>login</b>
		</button>
		<button id="open_reg" data-toggle="modal" data-target="#modalRegisterForm" class="btn btn-outline-default btn-sm mr-0 px-2">
			<i class="fas fa-sign-in-alt"></i> <b>register</b>
		</button>
	</div>
</div>

<!-- login modal -->
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold">로그인</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body mx-3">
				<form id="login_form">
					<div class="form-group">
						<small class="form-text text-muted">아이디</small>
						<input id="login_id" type="email" class="form-control" autocomplete="off" required>
						<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
					</div>
					<div class="form-group">
						<small class="form-text text-muted">비밀번호</small>
						<input id="login_pw" type="password" class="form-control" required>
					</div>
			
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button id="login_btn" class="btn btn-default">로그인</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- /login modal -->
<!-- register modal -->
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold">회원가입</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="reg_form">
				<div class="modal-body mx-3">
					<div class="form-group">
						<small class="form-text text-muted" id="id_label">아이디</small>
						<input id="reg_id" type="text" class="form-control" autocomplete="off" required>
						<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
					</div>
					<div class="form-group">
						<small class="form-text text-muted" id="pw_label">비밀번호</small>
						<input id="reg_pw" type="password" class="form-control" autocomplete="off" required>
					</div>
					<div class="form-group">
						<small class="form-text text-muted" id="name_label">이름</small>
						<input id="reg_name" type="text" class="form-control" autocomplete="off" required>
					</div>
					<div class="form-group">
						<small class="form-text text-muted" id="addr_label">주소</small>
						<div class="d-flex align-items-center justify-content-between">
							<input id="reg_post" type="text" class="form-control col-7" placeholder="우편번호" required readonly>
							<button id="api_btn" type="button" class="btn btn-sm btn-outline-default col-5 px-2 py-2">우편번호 찾기</button>
						</div>
						<input id="reg_addr" type="text" class="form-control mb-1" placeholder="주소" required readonly>
						<input id="reg_extraaddr" type="text" class="form-control mb-1" placeholder="참고항목" required readonly>
						<input id="reg_detailaddr" type="text" class="form-control mb-1" placeholder="상세주소">
					</div>
					<!-- iframe section -->
					<div id="iframe" style="display:none;border:1px solid;height:300px;margin:2px 0;position:relative">
						<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<button id="register_btn" class="btn btn-default">가입하기</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- register modal -->
<script>
	//LOGIN AJAX
	$("#login_btn").click( function (e) {
		//IMPORTANT!!!!
		e.preventDefault();
		var login_id = $("#login_id").val();
		var login_pw = $("#login_pw").val();

		$.ajax({
			type : "POST",
			url : "ajax_login.php",
			data : {"login_id" : login_id, "login_pw" : login_pw},
			dataType: "json",
			error : function() {
				alert("통신실패");
			},
			success : function(data) {
				if(data.res) {
					$("#login_form")[0].reset();
					$('#modalLoginForm').modal('toggle');
					window.location.reload();
					$('.wrap').load("login_af.php");
				}
				if(!data.res) {
					alert("아이디/비밀번호가 존재하지 않거나 일치하지 않습니다.");
				}
			}
		});
		
	});

	//REGISTER AJAX
	$("#register_btn").click( function (e) {
		//IMPORTANT!!!!
		e.preventDefault();
		var reg_name = $("#reg_name").val();
		var reg_id = $("#reg_id").val();
		var reg_pw = $("#reg_pw").val();
		var reg_post = $("#reg_post").val();
		var reg_addr = $("#reg_addr").val();
		var reg_extraaddr = $("#reg_extraaddr").val();
		var reg_detailaddr = $("#reg_detailaddr").val();

		$.ajax({
			type : "POST",
			url : "ajax_register.php",
			data : {"reg_name" : reg_name, "reg_id" : reg_id, "reg_pw" : reg_pw, "reg_post" : reg_post, "reg_addr" : reg_addr, "reg_extraaddr" : reg_extraaddr, "reg_detailaddr" : reg_detailaddr },
			dataType: "json",
			async : false,
			error : function() {
				alert("통신실패");
			},
			success : function(data) {
				console.log(data);
				console.log(data.name);
				if(data.name == "noname") {
					$('#name_label').html("<span class='red-text'>이름을 입력해주세요</span>");
				}
				else
					$('#name_label').html("이름");
				//
				if(data.id == "noid") {
					$('#id_label').html("<span class='red-text'>아이디를 입력해주세요.</span>");
				}
				else if(data.exist == "exist") {
					$('#id_label').html("<span class='red-text'>해당 아이디가 존재합니다.</span>");
				}
				else
					$('#id_label').html("아이디");
				//
				if(data.pw == "nopw") {
					$('#pw_label').html("<span class='red-text'>패스워드를 입력해주세요.</span>");
				}
				else
					$('#pw_label').html("비밀번호");
				//
				if(data.addr == "noaddr") {
					$('#addr_label').html("<span class='red-text'>주소를 정확히 입력해주세요.</span>");
				}
				else
					$('#addr_label').html("주소");
				//
				if(data.result== "ok") {
					alert("회원가입이 완료되었습니다.");
					$("#reg_form")[0].reset();
					$('#modalRegisterForm').modal('toggle');
					
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
          document.getElementById("reg_extraaddr").value = extraAddr;

        } 
        else {
        	document.getElementById("reg_extraaddr").value = '';
        }

        // 우편번호와 주소 정보를 해당 필드에 넣는다.
        document.getElementById('reg_post').value = data.zonecode;
        document.getElementById("reg_addr").value = addr;
        // 커서를 상세주소 필드로 이동한다.
        document.getElementById("reg_detailaddr").focus();

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