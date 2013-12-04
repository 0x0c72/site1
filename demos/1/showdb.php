<html>

<head>

	<title>Show DB PHP</title>

</head>

<body>
	<h2> ShowDB.php (demo)</h2>

<?php

	//$dbc is the variable to connect to the SQL DB
	$dbc = mysqli_connect('localhost', 'corpjuk', 'grools2!', 'elvis_store')
		or die('Error connecting to MySQL server.');

	$query = "SELECT * FROM emailList";

	$result = mysqli_query($dbc, $query)
		or die('Query Error');

	//$row = mysqli_fetch_array($result);

	while($row = mysqli_fetch_array($result)) {

		$first_name = $row['firstName'];
		$last_name = $row['lastName'];
		$email = $row['email'];

		//mail($to, $subject, $msg, 'From: ' . $from);

		echo '<b>First Name:</b> ' . $row['firstName'] . ' <b>Last Name:</b> ' . $row['lastName'] .
		' <b>Email:</b> ' . $row['email'] . '<br />';
	}

	mysqli_close($dbc);

	//echo 'Customer Added';

?>

</body>

</html>