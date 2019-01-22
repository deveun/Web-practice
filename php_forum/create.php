<?php

$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="1234"; // Mysql password 
$db_name="myforum"; // Database name 
$tbl_name="fquestions"; // Table name 
$upload_tbl_name="upload_file";

// Connect to server and select databse.
$conn = mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn, $db_name)or die("cannot select DB");

/////////////////////////////
//Set file upload directory
//upload file directory
$target_dir = "uploads/"; 
//(full file name) directory + filename + extension 
$target_file = $target_dir . basename($_FILES["file"]["name"]);
//file name without type(extension)
$target_realname = pathinfo($target_file,PATHINFO_FILENAME); 
//upload file type (extension)
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); 

$uploadOk = 0;
////////////////////////////

// get data that sent from form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$topic = test_input($_POST["topic"]);
	$detail = $_POST["detail"];
	$name = test_input($_POST["name"]);
	$email = test_input($_POST["email"]);
	$datetime=date("y/m/d h:i A"); //create date time

	// (When file exist) 
	//Check if image file is a actual image or fake image
	if(!$_FILES["file"]["name"] =='') {
		//tmp_name => file temporary save directory
		$check = getimagesize($_FILES["file"]["tmp_name"]);
		/////////////VALIDATION///////////////
		// Check if file already exists
		$exist_flag = 0;
		$i = 0;
		// !!!Add number to filename!!!!!!!
		while($exist_flag != 1){
			if (file_exists($target_file)) {
				$target_file = $target_dir.$target_realname.$i.'.'.$imageFileType;
				$i = $i+1;
			}
			else {
				$exist_flag = 1;
				$uploadOk = 1;
			}
		//echo "<script> alert("Sorry, file already exists.");</script>";
		}
		//check file is image or not
		// if($check !== false) {
		// 	echo "File is an image - " . $check["mime"] . ".";
		// 	$uploadOk = 1;
		// } else {
		// 	echo "<script> alert('File is not an image.');</script>";
		// 	$uploadOk = 0;
		// }
		// // Check file size
		// if ($_FILES["file"]["size"] > 500000) {
		// 	echo "<script> alert('Sorry, your file is too large.');</script>";
		// 	$uploadOk = 0;
		// }
		
		// Allow certain file formats
		/*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"	&& $imageFileType != "gif" ) {
			echo "<script> alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');	</script>";
			$uploadOk = 0;
		}*/
		/////////////(ABOVE)VALIDATION///////////////
		// Check if $uploadOk is set to 0 by an error
		// Check if you can upload file or not
		if ($uploadOk == 0) {
			echo "<script> 
			alert('Sorry, your file was not uploaded.');
			document.location.href='main_forum.php'; </script>";
			return;
		}
		// if everything is ok, try to <<<UPLOAD>>> file (dir, destination)
		else {
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
			} else {
				echo "<script> alert('Sorry, there was an error uploading your file.');	document.location.href='main_forum.php';</script>";
				return;
			}
		}
	}
	/////////////////Save file to server /uploads directory

	//INSERT ROW (DATA)
	//if upload_file is exist => $file_id=random / if not => 0
	$file_id = 0;
	if($uploadOk == 1){
		$file_id = md5(uniqid(rand(), true));
		$sql="INSERT INTO $upload_tbl_name VALUES('$file_id', '$target_file')";
		$result=mysqli_query($conn, $sql);
	}
	
	$sql1="INSERT INTO $tbl_name(topic, detail, name, email, datetime, view,file_id)VALUES('$topic', '$detail', '$name', '$email', '$datetime', 0, '$file_id')";

	
	$result1=mysqli_query($conn, $sql1);
	echo "
	<script> 
	alert('작성완료');
	document.location.href='main_forum.php';
	</script>"; 

}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
mysqli_close($conn);
?>