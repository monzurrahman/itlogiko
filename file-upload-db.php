<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Form submission and save to DB</title>
	<link rel="stylesheet" href="">
</head>
<body>
	
	<form action="" method="post" enctype="multipart/form-data">
		<label><h1>For submission to staroe and retrieve in database</h1></label>
		<input type="text" name="text_input" > <br/>
		<input type="file" name = "file_name_var"><br/><br/> 
		<input type="submit" name = "button_var">
	</form>
<?php

$db_name = "my_new_db_name";
$db_user = "root";
$db_possord = "";
$db_hostname = "localhost";
$db_connect = mysqli_connect($db_hostname, $db_user, $db_possord, $db_name );

if (isset($_POST['button_var']))
		{

					$name_var = $_POST['text_input'];
					$file_name_var = $_FILES['file_name_var']['name'];
					$file_temp_name = $_FILES['file_name_var']['tmp_name'];  // i did mistake here writing tem instead of tmp , careful. Error- Undefined array key 
					$file_type = $_FILES['file_name_var']['type'];
					$file_directory = "uploads/".basename($file_name_var); // i did 3 mistake here- omiting .basename..not a directory type error.

					if (move_uploaded_file($file_temp_name, $file_directory))
					{

					echo "File uploaded successfully"."<br/>";

						$sql = "INSERT INTO uploads (file_name, file_path, file_type) VALUES ('$name_var', '$file_directory', '$file_type')"; 
						// Got Fatal error: Uncaught mysqli_sql_exception...... when i wrote values without single quotation like,  VALUES ($name_var, $file_directory, $file_type)

						 	if(mysqli_query($db_connect, $sql))
								{
									echo "File saved to database successfully";
								}
							else echo "Failed to upload in database! ". mysqli_error($db_connect);

					}
		}

?>
</body>
</html>
<?php
/*
MySql code goes here- 

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

*/

?>
