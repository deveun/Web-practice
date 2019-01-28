<?php

include_once "db_config.php"; 

//Update data
// get data that sent from form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$category = $_POST["category"];
	$topic = test_input($_POST["topic"]);
	$user_id = test_input($_POST["user_id"]);
	$detail = $_POST["detail"];
	$topic_id = test_input($_POST["topic_id"]);

	//update forum
	$sql2="UPDATE $tbl_name SET category='$category', topic='$topic', detail='$detail' WHERE topic_id='$topic_id'";
	$result2=mysqli_query($conn, $sql2);

	/////////////////////////////
	//Set file upload directory
	//upload file directory
	$root_dir = "uploads/"; 
	//file length
	$total = count($_FILES["file"]["name"]);

	for($i=0; $i<$total ; $i++) {
		//make save directory
		if(!is_dir($root_dir.$topic_id)) mkdir($root_dir.$topic_id);
		//upload file type (extension)
		$file_type[$i]=pathinfo(basename($_FILES["file"]["name"][$i]), PATHINFO_EXTENSION);
		//file name (without extension)
		$file_realname[$i] = pathinfo(basename($_FILES["file"]["name"][$i]),PATHINFO_FILENAME);
		//Datebase file save name (without extension)
		$file_savename[$i] = $file_realname[$i].date("Ymd");
		//(full file name) directory + filename + extension 
		$file_path[$i] = $root_dir.$topic_id."/".$file_savename[$i].'.'.$file_type[$i];
		
		$uploadOk[$i] = 0;
	}
	////////////////////////////

	//count file->delete
	if(isset($_POST["file_id"])) {
		$del_total = count($_POST["file_id"]);
		for($i=0;$i<$del_total;$i++)
		{
			$del_id = $_POST["file_id"][$i];
			$sql = "SELECT file_dir FROM $upload_tbl_name WHERE file_id='$del_id'";
			$result = mysqli_query($conn, $sql);
			$rows_del = mysqli_fetch_array($result);
			$del_dir = $rows_del['file_dir'];
			//delete file dir
			unlink($del_dir);
			//delete file db
			$sql3 = "DELETE FROM $upload_tbl_name WHERE file_id = '$del_id'";
			$result3 = mysqli_query($conn, $sql3);
		}
	}

	//INSERT MULTIPLE FILES
	for($j=0;$j<$total;$j++) {
		// (When file exist) 
		//Check if image file is a actual image or fake image
		if(!$_FILES["file"]["name"][$j] =='') {
			//tmp_name => file temporary save directory
			$check = getimagesize($_FILES["file"]["tmp_name"][$j]);
			/////////////VALIDATION///////////////
			// Check if file already exists
			$exist_flag = 0;
			$i = 0;
			// !!!Add number to filename!!!!!!!
			while($exist_flag != 1){
				if (file_exists($file_path[$j])) {
					$file_path[$j] = $root_dir.$topic_id."/".$file_savename[$j].$i.'.'.$file_type[$j];
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
			$uploadOk = 0;}*/
			/////////////(ABOVE)VALIDATION///////////////
			// Check if $uploadOk is set to 0 by an error
			// Check if you can upload file or not
			if ($uploadOk == 0) {
				echo "<script> 
				alert('Sorry, your file was not uploaded.');
				location.href='view_main.php'; </script>";
				return;
			}
		// if everything is ok, try <<<UPLOADING>>> file (dir, destination)
			else {
				if (move_uploaded_file($_FILES["file"]["tmp_name"][$j], $file_path[$j])) {
					//echo "The file ". basename( $_FILES["file"]["name"][$j]). " has been uploaded.";
				} else {
					echo "<script> alert('Sorry, there was an error uploading your file.');	//location.href='view_main.php';
					</script>";
					return;
				}
			}
		}
		/////////////////Save file to server /uploads directory

		// //INSERT ROW (DATA)
		// //if upload_file is exist => $file_id=random / if not => 0
		// $file_id = 0;
		// if($uploadOk == 1){
		// 	$file_id = md5(uniqid(rand(), true));
		// 	$sql="INSERT INTO $upload_tbl_name VALUES('$file_id', '$target_file')";
		// 	$result=mysqli_query($conn, $sql);
		// }

		//INSERT files to upload_file table
		if($uploadOk == 1){
			$sql="INSERT INTO $upload_tbl_name (file_type, file_name, file_dir, topic_id) VALUES('$file_type[$j]', '$file_realname[$j]', '$file_path[$j]', '$topic_id')";
			$result=mysqli_query($conn, $sql);
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