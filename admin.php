<?php 
session_start();
if (!isset($_SESSION['loggedin'])){
	header('Location: index.php');
	exit();
}  



// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_new_db_name"; // Replace with your database name

// Create connection using procedural style
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to retrieve all data from the uploads table
$sql = "SELECT * FROM uploads";
$result = mysqli_query($conn, $sql);

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Welcome admin</title>
	<link rel="stylesheet" href="">

	<style>
		
		h1,h2,h3,h4,h5{color:#049eca;}
		body{}
		input, #address_t, #file_attach_button{width: 80%; padding: 10px; margin: 8px 0; border-radius: 5px; border:1px solid #049eca}
		#logout_button, input[type="file"]::file-selector-button {
							  border-radius: 4px;
							  padding: 0 16px;
							  height: 40px;
							   border: 1px solid #049eca;
								font-weight:bold; font-size:20px;				 }
		#form_1{width: 400px; margin: 20px auto; border:1px dotted gray; padding:10px; }
		#top_bottom {width: 100%; min-height: 100px; background:#1b1919; float: left;}
		#form_div{width: 100%; height:auto; float:left;}
		table, th, td {
						  border: 1px solid black;
					  }
		#top_middle, #middle_body{width:922px; margin: 0 auto;}
	</style>
</head>
<body>


	<div class="main" style="width: 100%; height:auto;">
		

		<div id="top_bottom">
			<div id="top_middle">
				<div style="float:left;"><a href="index.php"><img src="http://localhost/project/uploads/logo.png"/></a></div>
				<div style="float:right"> <!-- onclick="return confirm('Are you sure you want to log out?')" -->
					  <form method="post" action="logout.php">
				        <button type="submit" id="logout_button">Logout</button>
				      </form>
				</div> 
		    </div>
	    </div>


	    <div id="middle_body">
	    	<h1> You are logged in.   Admin panel is here.</h1>


						<table>
						    <tr>
						        <th>ID</th>
						        <th>Name</th>
						        <th>Email</th>
						        <th>Phone</th>
						        <th>Address</th>
						        <th>File Path</th>
						       
						    </tr>

						    <?php
						    // Check if there are any results and display them in the table. $result = mysqli_query($conn, $sql);
						    if (mysqli_num_rows($result) > 0) {
						        // Fetch each row and display it in the table
						        while($row = mysqli_fetch_assoc($result)) {
						            echo "<tr>";
						            echo "<td>" . $row['id'] . "</td>";
						            echo "<td>" . $row['person_name'] . "</td>";
						            echo "<td>" . $row['person_email'] . "</td>";
						            echo "<td>" . $row['person_phone'] . "</td>";
						            echo "<td>" . $row['person_address'] . "</td>";
						            ?>
						            <td><embed src="http://localhost/project/<?php echo $row['file_path']; ?>" type="" width="400" height="400">  </td>
						           <?php
						            echo "</tr>";
						        }
						    } else {
						        echo "<tr><td colspan='8'>No data found</td></tr>";
						    }

						    // Close the connection
						    mysqli_close($conn);
						    ?>
						</table>


	    </div>



	    <div id="top_bottom">
			
	    </div>


	</div>
	

</body>
</html>
