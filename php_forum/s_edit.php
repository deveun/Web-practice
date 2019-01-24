<?php

include_once "db_config.php"; 

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

//Update data
// get data that sent from form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$topic = test_input($_POST["topic"]);
	$user_id = test_input($_POST["user_id"]);
	$detail = $_POST["detail"];
	$id = test_input($_POST["id"]);
	$delOk = test_input($_POST["delOk"]);

	// (When file exist) 
	//Check if image file is a actual image or fake image
	//before file was existed => change file
	if(!$_FILES["file"]["name"] =='') {
		//tmp_name => file temporary save directory
		$check = getimagesize($_FILES["file"]["tmp_name"]);
		/////////////VALIDATION///////////////
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "<script> alert('File is not an image.');</script>";
			$uploadOk = 0;
		}
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
		// Check file size
		if ($_FILES["file"]["size"] > 500000) {
			echo "<script> alert('Sorry, your file is too large.');</script>";
			$uploadOk = 0;
		}

		/////////////(ABOVE)VALIDATION///////////////
		// Check if $uploadOk is set to 0 by an error
		// Check if you can upload file or not
		if ($uploadOk == 0) {
			echo "<script> alert('Sorry, your file was not uploaded.');	</script>";
		}
		// if everything is ok, try to <<<UPLOAD>>> file (dir, destination)
		else {
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
			} else {
				echo "<script> alert('Sorry, there was an error uploading your file.');	</script>";
			}
		}
		//CASE1: file o, del x => new file
		if($uploadOk == 1 && $delOk == 0){
			$file_id = md5(uniqid(rand(), true));
			$sql="INSERT INTO $upload_tbl_name VALUES('$file_id', '$target_file')";
			$result=mysqli_query($conn, $sql);

			//update forum table
			$sql2="UPDATE $tbl_name SET topic='$topic', user_id='$user_id', detail='$detail', file_id='$file_id' WHERE id='$id'";
			$result2=mysqli_query($conn, $sql2);
		}
		//CASE2: file o, del o => change file
		else if($uploadOk == 1 && $delOk == 1){
			//find upload file data
			$sql3 = "SELECT * FROM $tbl_name WHERE id='$id'";
			$result3=mysqli_query($conn, $sql3);
			$rows = mysqli_fetch_array($result3);
			$file_id=$rows['file_id'];

			//delete server file
			$sql4 = "SELECT * FROM $upload_tbl_name WHERE file_id='$file_id'";
			$result4=mysqli_query($conn, $sql4);
			$rows2 = mysqli_fetch_array($result4);
			$file_dir=$rows2['file_dir'];
			unlink($file_dir);

			//change file name (file_dir)
			$sql5="UPDATE $upload_tbl_name SET file_dir ='$target_file' WHERE file_id = '$file_id'";
			$result5=mysqli_query($conn, $sql5);

			//update forum table
			$sql2="UPDATE $tbl_name SET topic='$topic', user_id='$user_id', detail='$detail' WHERE id='$id'";
			$result2=mysqli_query($conn, $sql2);
		}
	}
	else
	{
		//CASE3: file x del o => file delete
		if($delOk == 1) {

			//find upload file data
			$sql3 = "SELECT * FROM $tbl_name WHERE id='$id'";
			$result3=mysqli_query($conn, $sql3);
			$rows = mysqli_fetch_array($result3);
			$file_id=$rows['file_id'];

			//delete server file
			$sql4 = "SELECT * FROM $upload_tbl_name WHERE file_id='$file_id'";
			$result4=mysqli_query($conn, $sql4);
			$rows2 = mysqli_fetch_array($result4);
			$file_dir=$rows2['file_dir'];
			unlink($file_dir);

			//update forum table
			$sql2="UPDATE $tbl_name SET topic='$topic', user_id='$user_id', detail='$detail', file_id='0' WHERE id='$id'";
			$result2=mysqli_query($conn, $sql2);

			//delete upload_file data
			$sql5 = "DELETE FROM $upload_tbl_name WHERE file_id='$file_id'";
			$result5 = mysqli_query($conn, $sql5);
		}

		//CASE4: just update forum table
		else {
			$sql2="UPDATE $tbl_name SET topic='$topic', user_id='$user_id', detail='$detail' WHERE id='$id'";
			$result2=mysqli_query($conn, $sql2);
		}
	}

	echo "
	<script> 
	alert('수정완료');
	//document.location.href='view_main.php';
	</script>"; 
}
	/////////////////Save file to server /uploads directory
	function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
mysqli_close($conn);
?>