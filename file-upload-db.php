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
		<label><h1>For submission to store and retrieve in database</h1></label>

		<input type="text" name="text_input" id="name" placeholder="Name"> <br/>
		<input type="email" name="email" id="email" placeholder="Email" required> <br/>
		<input type="number" name="phone" id="phone" placeholder="Phone Number" min="1" max="1999999999" required> <br/>
		<textarea name="address_text" id="address_t" placeholder="Enter your address by 100 characters" maxlength="100" ></textarea><br/>
		<input type="file" name = "file_name_var" accept=" .pdf"><br/><br/> 
		<input type="submit" name = "button_var">

	</form>
<?php

// Database issue- DB connection setup
$db_name = "my_new_db_name";
$db_user = "root";
$db_possord = "";
$db_hostname = "localhost";
$db_connect = mysqli_connect($db_hostname, $db_user, $db_possord, $db_name );

// file type validation
/*	if(isset($_FILES['file_name_var']))
						{
							$file_name_var = $_FILES['file_name_var']['name']; 
							$allowed_extension = '.pdf';
							$file_extension = strtolower((pathinfo( $file_name_var, PATHINFO_EXTENSION)));
							if ($file_extension == $allowed_extension)
								{
									echo "Correct file uploaded";
								}
							else die("Unable to upload file. Please upload .pdf file only"); 
						}
*/

// file type validation cods ends here

if (isset($_POST['button_var']) && isset($_FILES['file_name_var']))
		{ 

			// Form related data taken here-
				$input_name    = htmlspecialchars($_POST['text_input']);
				$input_email   = htmlspecialchars($_POST['email']);
				$input_phone   = htmlspecialchars($_POST['phone']);
				$input_address = htmlspecialchars($_POST['address_text']);
			//  $_SERVER['HTTP_REFERER'] can be applied to check if the form is actioned from it's self domain.. althoug it has vulnerable  issue
			// the data of the form fields can be sanitize by htmlspecialchars — Convert special characters to HTML entities. i.e. > converts to &gt;
					// $name_var = $_POST['text_input'];
				$file_name_var = $_FILES['file_name_var']['name'];
				$file_temp_name = $_FILES['file_name_var']['tmp_name'];  // i did mistake here writing tem instead of tmp , careful. Error- Undefined array key 
				$file_type = $_FILES['file_name_var']['type'];
				$file_directory = "uploads/".basename($file_name_var); // i did 3 mistake here- omiting .basename..not a directory type error.
				
			//Specify the size of the file
				$file_size_limit = 2 * 1024 * 1024; // 2MB limit
				$file_size_uploaded = $_FILES['file_name_var']['size'];
 

			// Filter out file type .pdf
				$allowed_extension = 'pdf';
				$file_extension = strtolower((pathinfo( $file_name_var, PATHINFO_EXTENSION)));

				if (($file_extension == $allowed_extension) && ($file_size_uploaded<=$file_size_limit))
					{
									


					if (move_uploaded_file($file_temp_name, $file_directory))
					{

					echo "File uploaded successfully"."<br/>";

						$sql = "INSERT INTO uploads (person_name, person_email, person_phone, person_address, file_name, file_path, file_type) VALUES ('$input_name', '$input_email', '$input_phone', '$input_address', '$file_name_var', '$file_directory', '$file_type')"; 
						// i did same mistake for the 3 times.. Got Fatal error: Uncaught mysqli_sql_exception...... when i wrote values without single quotation i.e.,  VALUES ($name_var, $file_directory, $file_type)

						 	if(mysqli_query($db_connect, $sql))
								{
									echo "File saved to database successfully";
								}
							else echo "Failed to upload in database! ". mysqli_error($db_connect);

					}
					}
					else die("Sorry! Unable to process. please upload only .pdf file that is less than 2MB size");
		}

?>
</body>
</html>
<?php
/*

Second stage DB code goes here-

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_name` varchar(255) NOT NULL,
  `person_email` varchar(255) NOT NULL,
  `person_phone` varchar(255) NOT NULL,
  `person_address` varchar(255),
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

*/

?>
