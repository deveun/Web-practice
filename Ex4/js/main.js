$(document).ready(function() {

	/*Shopping Cart Merchandise Price Total*/
	var m_sum = 0;
	var s_sum = 0;

	/* Table Click Event ============================= */
	/*Merchandise Table list Click Event (Add to cart)*/
	$(".m_table tbody").on("click", "tr", function() {

		var cur_tr = $(this);
		var is_exist = 0;
		
		/*CASE1::: If selected item is already existed in shopping cart*/
		/*Increase quantity and amount */
		$(".c_m_table tbody tr").each(function(i) {
			if(cur_tr.children().eq(0).text()==$(this).children().eq(0).text())
			{
				var pre_quan = parseInt($(this).children().eq(1).text());
				var pre_sum = parseInt($(this).children().eq(2).text());
				$(this).children().eq(1).text(pre_quan+1);
				$(this).children().eq(2).text(pre_sum/pre_quan*(pre_quan+1));
				is_exist =1;
				return false;
			}
		});
		/*CASE1::: If selected item is not existed in shopping cart*/
		/*Add new list*/
		if(is_exist == 0)
		{	
			var td = cur_tr.html();
			var row = "<tr>";
			row += td;
			row += "<td><span class=\"badge badge-pill badge-danger\">x</span></td></tr>";
			$('.c_m_table').append(row);
		}
		/* calculate cart merchandise total price*/
		m_sum += parseInt(cur_tr.children().eq(2).text());
		update_total();
	});
	/*Service Table list Click Event (Add to cart)*/
	$(".s_table tbody").on("click", "tr", function() {

		var cur_tr = $(this);
		var is_exist = 0;
		
		/*CASE1::: If selected item is already existed in shopping cart*/
		$(".c_s_table tbody tr").each(function(i) {
			if(cur_tr.children().eq(0).text()==$(this).children().eq(0).text())
			{
				is_exist =1;
				return false;
			}
		});
		/*CASE1::: If selected item is not existed in shopping cart*/
		/*Add new list*/
		if(is_exist == 0)
		{	
			var td = cur_tr.html();
			var row = "<tr>";
			row += td;
			row += "<td><span class=\"badge badge-pill badge-danger\">x</span></td></tr>";
			$('.c_s_table').append(row);
			/* calculate cart service total price*/
			s_sum += parseInt(cur_tr.children().eq(1).text());
			update_total();
		}
	});
	/*Merchandise Cart Click Event (Delete)*/
	$(".c_m_table tbody").on("click", "tr", function() {
		$(this).remove(); 
		/* calculate cart merchandise total price*/
		m_sum -= parseInt($(this).children().eq(2).text());
		update_total();
	});
	/*Service Cart Click Event (Delete)*/
	$(".c_s_table tbody").on("click", "tr", function() {
		$(this).remove();
		/* calculate cart merchandise total price*/
		s_sum -= parseInt($(this).children().eq(1).text());
		update_total();
	});
	/* Table Click Event ================================== */


	/* Cart Drawer Open/Close ============================= */
	$(".cart_title").click(function() {
		var cart_area = $(this).parent();
		cart_area.toggleClass("cart_toggle");
	});
	/* Cart Drawer Open/Close ============================= */

	/*Update shopping cart total price*/
	/*Execute when click(Add or Delete) list */
	function update_total () {
		$('#m_sum').text(m_sum);
		$('#s_sum').text(s_sum);
		$('#total').text(m_sum+s_sum);
	}
});