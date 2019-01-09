$(function() {
// Add Button Click
$('#add_btn').click(function() {
 if($('#input_name').val() == "")       { alert("type name."); }
 else if($('#input_quan').val() == "")  { alert("type quantity."); }
 else if($('#input_pric').val() == "" ) { alert("type price."); }
 else {
  var tr = $('tr');
  var row = "<tr>" ;
  //col1
  row += "<td>";
  row += tr.length;
  row += "</td>";
  //col2
  row += "<td>";
  row += $('#input_name').val();
  row += "</td>";
  //col3
  row += "<td>";
  row += $('#input_quan').val();
  row += "</td>";
  //col4
  row += "<td>";
  row += $('#input_pric').val();
  row += "</td>";

  row += "</tr>";

  $('table').append(row);
  $('form')[0].reset();
 }
});

$("tbody").on("click", "tr", function() {
  $(this).remove();
 });
});
