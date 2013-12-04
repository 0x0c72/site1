<html>

<head>

	<title>Aliens Abducted Me - Report an Abduction</title>

</head>

<body>
	<h2> Aliens Abducted Me - Report an Abduction</h2>

<?php
	//$name = $_POST['firstname'] . ' ' . $_POST['lastname'];
	$first_name = $_POST['firstname'];
	$last_name = $_POST['lastname'];
	$how_many = $_POST['howmany'];
	$what_they_did = $_POST['whattheydid'];
	$other = $_POST['other'];
	$when_it_happened = $_POST['whenithappened'];
	$how_long = $_POST['howlong'];
	$alien_description = $_POST['aliendescription'];
	$fang_spotted = $_POST['fangspotted'];
	$email = $_POST['email'];
	$to = 'jcunningham2@email.itt-tech.edu';
	$subject = 'Aliens Abducted Me - SubjectLine';

	//$dbc is the variable to connect to the SQL DB
	$dbc = mysqli_connect('localhost', 'corpjuk', 'grools2!', 'aliendatabase')
		or die('Error connecting to MySQL server.');

	//$query is the variable holding the DB data
	//$query is just holding SQL code as a string
	$query = "INSERT INTO aliens_abduction (first_name, last_name, when_it_happened, how_long, how_many, alien_description, what_they_did, fang_spotted, other, email) " .
		"VALUES ('$first_name', '$last_name', '$when_it_happened', '$how_long', '$how_many', '$alien_description', '$what_they_did', '$fang_spotted', '$other', '$email')";

	//the mysqli_query arguements(connection, data to use)
	$result = mysqli_query($dbc, $query)
		or die('Error querying database.');

	//close connection
	mysqli_close($dbc);

	//mail($to, $subject, $msg, 'From:' . $email);

	echo 'Thanks for submitting a form' . $first_name . ' ' . $last_name . ' <br />';
	echo 'You were abductd ' . $when_it_happened;
	echo 'and were gone for ' . $how_long . '<br />';
	echo 'Number of aliens: ' . $how_many . '<br />';
	echo 'Describe them: ' . $alien_description . '<br />';
	echo 'The aliens did this: ' . $what_they_did . '<br />';
	echo 'Was fang there? ' . $fang_spotted . '<br />';
	echo 'Other comments: ' . $other . '<br />';
	echo 'Your email address is ' . $email;

	$msg = "$name was abducted $when_it_happened and was gone for $how_long.\n" .
		"Number of aliens: $how_many\n" .
		"Alien description: $alien_description\n" . 
		"What they did: $what_they_did\n" .
		"Fang spotted: $fang_spotted\n" .
		"Other comments: $other\n";

?>

</body>

</html>