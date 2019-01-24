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
				</form>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button id="login_btn" class="btn btn-default">로그인</button>
			</div>

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
						<small class="form-text text-muted" id="name_label">이름</small>
						<input id="reg_name" type="text" class="form-control" autocomplete="off" required>
					</div>
					<div class="form-group">
						<small class="form-text text-muted" id="id_label">아이디</small>
						<input id="reg_id" type="text" class="form-control" autocomplete="off" required>
						<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
					</div>
					<div class="form-group">
						<small class="form-text text-muted" id="pw_label">비밀번호</small>
						<input id="reg_pw" type="password" class="form-control" autocomplete="off" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button id="register_btn" class="btn btn-default">가입하기</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- register modal -->
<script>

	//var login_info = "<?php echo $_SESSION['user_id']; ?>"; 
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

		$.ajax({
			type : "POST",
			url : "ajax_register.php",
			data : {"reg_name" : reg_name, "reg_id" : reg_id, "reg_pw" : reg_pw},
			dataType: "json",
			async : false,
			error : function() {
				alert("통신실패");
			},
			success : function(data) {
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
				if(data.result== "ok") {
					alert("회원가입이 완료되었습니다.");
					$("#reg_form")[0].reset();
					$('#modalRegisterForm').modal('toggle');
					
				}
			}
		});
	});

</script>