<?php
	$dishID = $_POST['dishIDToLoad'];
	$userID = $_POST['userID'];

	$db_hostname = "mysql";
	$db_database = "u5dc";
	$db_username = "u5dc";
	$db_password = "12-abcd-34";

	$db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
	if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());

    // Encoding all characters interacting with MySQL in UTF-8
    mysqli_set_charset($db_con,"utf8");

	$query = "SELECT rating, comment FROM DishReview WHERE dishID = '$dishID' AND userID = '$userID';";
	$result = mysqli_query($db_con, $query);
	$row = mysqli_fetch_assoc($result);

	if ($num_rows = mysqli_num_rows($result) == 0){
	    $data['success'] = true;
	} else {
	    $data['success'] = true;
	    $data['rating'] = $row['rating'];
	    $data['comment'] = $row['comment'];
	}

	mysqli_free_result($result);
	mysqli_close($db_con);
	//Send data back to registerUser.html
	echo json_encode($data);
	exit;
?>