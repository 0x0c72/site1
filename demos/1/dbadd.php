<html>

<head>

	<title>ty title</title>

</head>

<body>
	<h2> Thank you for joining our store! (demo)</h2>

<?php

	$first_name = $_POST['firstname'];
	$last_name = $_POST['lastname'];
	$email = $_POST['email'];

	//$dbc is the variable to connect to the SQL DB
	$dbc = mysqli_connect('localhost', 'corpjuk', 'grools2!', 'elvis_store')
		or die('Error connecting to MySQL server.');

	//$query = "INSERT INTO emailList(firstName, lastName, email)" .
	//	"VALUES ('$first_name', '$last_name', '$email')";

	if(empty($first_name) || empty($last_name) || empty($email)) {
		echo 'Please fill out entire form.<br />';
	}

	else {
	$query = "INSERT INTO emailList(firstName, lastName, email)" .
		"VALUES ('$first_name', '$last_name', '$email')";
	}

	mysqli_query($dbc, $query)
		or die('Query Error');

	mysqli_close($dbc);

	echo 'Customer Added';

?>

</body>

</html>