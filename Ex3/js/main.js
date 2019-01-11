function datavalid() {
	//alert($("form")[0].title.value);		//jquery selector
	//alert(document.forms[0].title.value);	//javascript selector

	var title = $("form")[0].title.value;
	var writer = $("form")[0].writer.value;

	//return true, when form data is not empty
	for(var i=0; i< $("form")[0].length-1; i++)
	{
		if($("form")[0][i].value == "") {
			alert($("form")[0][i].name + " is empty.");
			return false;
		}
	}
	alert("Submit success.");
	return true;
}