$(function() {

	//update button click -> change view
	$("#update_btn").click( function () {
		$(".view_table").hide();
		$(".update_table").show();
	});

	//cancel button click -> change view
	$("#cancel_btn").click( function () {
		$(".view_table").show();
		$(".update_table").hide();
	});

});
