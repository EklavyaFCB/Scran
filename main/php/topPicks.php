<?php
	//$dishNum = $_POST['count'];

	$db_hostname = "mysql";
	$db_database = "u5dc";
	$db_username = "u5dc";
	$db_password = "12-abcd-34";

	$db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
	if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());

	// Encoding all characters interacting with MySQL in UTF-8
	mysqli_set_charset($db_con,"utf8");

	$query = "SELECT D.dishID, D.dishName, R.restName, R.address FROM Dish D JOIN Restaurant R ON D.restID=R.restID ORDER BY dishRating DESC, amberPoints DESC LIMIT 10;";
	$result = mysqli_query($db_con, $query);
	$result || die("Database access failed: ".mysqli_error($db_con));

	while($row = mysqli_fetch_array($result)) {
	    $dishID = $row['dishID'];
	    $dishName = $row['dishName'];
	    $restName = $row['restName'];
	    $address = $row['address'];

	    $return_array[] = array("dishID" => $dishID, "dishName" => $dishName, "restName" => $restName, "address" => $address);
	}
	// Free and close query+connection
	mysqli_free_result($result);
	mysqli_close($db_con);

	// Send data to dish.html
	echo json_encode($return_array);
	exit;
?>