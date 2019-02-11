<?php

include_once "db_config.php"; 

// get data that sent from form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$category = $_POST["category"];
	$topic = test_input($_POST["topic"]);
	$detail = $_POST["detail"];
	$user_id = test_input($_POST["user_id"]);
	$email = test_input($_POST["email"]);
	$datetime=date("y/m/d H:i:s"); //create date time

	//INSERT topic to forum table
	$sql1="INSERT INTO $tbl_name (category, topic, detail, user_id, email, datetime)VALUES('$category', '$topic', '$detail', '$user_id', '$email', '$datetime')";	
	$result1=mysqli_query($conn, $sql1);

	//count total user post num (calculate grade)
	$sql = "SELECT * FROM $tbl_name WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $sql);
	$user_post_num = mysqli_num_rows($result);
	//echo $user_post_num;
	if(intval($user_post_num) <5)
	{
		$sql="UPDATE $user_tbl_name SET user_grade= '1' WHERE user_id='$user_id'";
		$_SESSION['user_grade'] = 1;
	}
	else if(intval($user_post_num) >=5)
	{
		$sql="UPDATE $user_tbl_name SET user_grade= '2' WHERE user_id='$user_id'";
		$_SESSION['user_grade'] = 2;
	}
	else if(intval($user_post_num) >=15)
	{
		$sql="UPDATE $user_tbl_name SET user_grade= '3' WHERE user_id='$user_id'";
		$_SESSION['user_grade'] = 3;
	}
	else if(intval($user_post_num) >=50)
	{
		$sql="UPDATE $user_tbl_name SET user_grade= '4' WHERE user_id='$user_id'";
		$_SESSION['user_grade'] = 4;
	}
	$result = mysqli_query($conn, $sql);

	//select new inserted ID
	$sql2="SELECT topic_id FROM $tbl_name ORDER BY topic_id DESC";
	$result2=mysqli_query($conn, $sql2);
	$rows = mysqli_fetch_array($result2);
	$new_id = $rows['topic_id'];

	/////////////////////////////
	//Set file upload directory
	//upload file directory
	$root_dir = "uploads/"; 
	//file length
	$total = count($_FILES["file"]["name"]);

	for($i=0; $i<$total ; $i++) {
		//upload file type (extension)
		$file_type[$i]=pathinfo(basename($_FILES["file"]["name"][$i]), PATHINFO_EXTENSION);
		//file name (without extension)
		$file_realname[$i] = pathinfo(basename($_FILES["file"]["name"][$i]),PATHINFO_FILENAME);
		//Datebase file save name (without extension)
		$file_savename[$i] = date("YmdGis");
		//(full file name) directory + filename + extension 
		$file_path[$i] = $root_dir.$new_id."/".$file_savename[$i].'.'.$file_type[$i];
		
		$uploadOk[$i] = 0;
	}
////////////////////////////

	//INSERT MULTIPLE FILES
	for($j=0;$j<$total;$j++) {
		// (When file exist) 
		//Check if image file is a actual image or fake image
		if(!$_FILES["file"]["name"][$j] =='') {
			//make save directory
			if(!is_dir($root_dir.$new_id)) mkdir($root_dir.$new_id);
			//tmp_name => file temporary save directory
			$check = getimagesize($_FILES["file"]["tmp_name"][$j]);
			/////////////VALIDATION///////////////
			// Check if file already exists
			$exist_flag = 0;
			$i = 0;
			// !!!Add number to filename!!!!!!!
			while($exist_flag != 1){
				if (file_exists($file_path[$j])) {
					$file_path[$i] = $root_dir.$new_id."/".$file_savename[$i].$i.'.'.$file_type[$i];
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
			/*if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"	&& $file_type != "gif" ) {
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
		// 	$sql="INSERT INTO $upload_tbl_name VALUES('$file_id', '$file_path')";
		// 	$result=mysqli_query($conn, $sql);
		// }

		

		//INSERT files to upload_file table
		if($uploadOk == 1){
			$sql="INSERT INTO $upload_tbl_name (file_type, file_name, file_dir, topic_id) VALUES('$file_type[$j]', '$file_realname[$j]', '$file_path[$j]', '$new_id')";
			$result=mysqli_query($conn, $sql);
		}
	}


	echo "
	<script> 
	alert('작성완료');
	document.location.href='view_main.php';
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