<?php
	//Connect to the ClassRegistration database
	require_once("./database.php");
	$connection = connection();

	//Get Class ID from confirm.php
	$classid = $_GET["classid"];

	//Get email address from confirm.php
	$email = $_GET["email"];

	// Add record to the registration tale
	$query = "INSERT INTO registration(class_id, student_email) VALUES ('$classid', '$email')";
	$result = mysqli_query($connection, $query);
	if(!$result){
		echo "Insert to registration failed. " . mysqli_error($connection);
		exit();
	}

	//Get the registration ID generated by insert.
	$regid = mysqli_insert_id($connection);

	//Get record from the class table
	$query = "SELECT * FROM class WHERE class_id = '$classid'";
	$result = mysqli_query($connection, $query);
	if(!$result){
		echo "Select from class failed. " . mysqli_error($connection);
		exit();
	}

	// Get selected class(row) from class table
	$classrow = mysqli_fetch_assoc($result);

	//Get record from the sutdent table
	$query = "SELECT * FROM student where student_email = '$email'";
	$result1 = mysqli_query($connection, $query);
	if(!$result1){
		echo "Select from student failed. " . mysqli_error($connection);
		exit();
	}

	//Get selected student(row) from student table
	$sturow = mysqli_fetch_assoc($result1);

	//Get record from the registration table
	$query3 = "SELECT * FROM registration WHERE reg_id = '$regid'";
	$result3 = mysqli_query($connection, $query3);
	if(!$result3){
		echo "Select from registration failed. " . mysqli_error($connection);
		exit();
	}

	//Get registration (row) from registration table
	$regrow = mysqli_fetch_assoc($result3);

	//Confirmation Email
	$to_client = $sturow['student_name'] . ' <' . $sturow['student_email'] . '>';
	$sub_client = 'Class Registration';
	$msg_client = 'Thank you for your class registration. Here is the necessary information:' . "\n\n";
	$msg_client .= 'Registration number: ' . $regrow['reg_id'] . "\n";
	$msg_client .= 'Class ID: ' . $classid . "\n";
	$msg_client .= 'Class Title: ' . $sturow['class_title'] . "\n";
	$msg_client .= 'Class Start Date: ' . $sturow['class_start'] . "\n";
	$msg_client .= 'Class Cost: $' . $sturow['class_cost'] . "\n";
	$msg_client .= 'Registration date: ' . $regrow['reg_date'] . "\n";
	$msg_client .= "\n\n";
	$msg_client .= 'Your Email Address: ' . $sturow['email_address'] . "\n";
	$msg_client .= 'Your Name: '. $sturow['student_name'] . "\n";
	$msg_client .= 'Your phone: ' . $sturow['student_phone'] . "\n\n";
	$msg_client .= 'Please contact us to arrange payment at:' . "\n\n";
	$msg_client .= 'infor@matthewstechnology.com' . "\n";
	$msg_client .= 'Thanks again, ' . "\n\n";
	$msg_client .= 'Matthews Technology' . "\n\n";
	$addl_headers_client = 'From: Matthews Technology <infor@matthewstechnology>' . "\n\n";

	mail($to_client, $sub_client, $msg_client, $addl_headers_client);
?>

<div id="main">
	<h1 id="maintitle">Class Database Update</h1>
	<p id="mainpara">Thank you for completing class registration!</br>
	Please click Complete</p>
	<div id="form">
		<!-- Go to classes.php after clicking Complete -->
		<form action="classes.php" method="post" name="form1">
			<input type="submit" name="submit" value="Complete"/>
		</form>
	</div>
</div>