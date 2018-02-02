<?php
$restaurantIDToLoad = $_POST['restaurantIDToLoad'];

// Database Variables
$db_hostname = "mysql";
$db_database = "u5dc";
$db_username = "u5dc";
$db_password = "12-abcd-34";

// Connection to database
$con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
if (!$con) die("Unable to connect to MySQL: ".mysqli_connect_error());

// Encoding all characters interacting with MySQL in UTF-8
mysqli_set_charset($con,"utf8");

$dishCount = "SELECT dishID FROM Dish WHERE restID = '$restaurantIDToLoad'";
$result = mysqli_query($con, $dishCount);
$result || die("Database access failed: ".mysqli_error($con));
if (mysqli_fetch_assoc($result) == 0) {
	$dishCount = "SELECT restName, description, email, address FROM Restaurant  WHERE restID = '$restaurantIDToLoad';";
} else {
	$dishCount = "SELECT D.dishID, R.restName, R.description, R.email, R.address FROM Restaurant R JOIN Dish D ON D.restID=R.restID WHERE R.restID = '$restaurantIDToLoad';";
}
// Dish count query
// $dishCount = "SELECT D.dishID, R.restName, R.description, R.email, R.address FROM Dish D JOIN Restaurant R ON D.restID=R.restID WHERE R.restID = '$restaurantIDToLoad';";
$result = mysqli_query($con, $dishCount);
$result || die("Database access failed: ".mysqli_error($con));

$row = mysqli_fetch_assoc($result);
$data['success'] = true;
$data['dishCount'] = mysqli_num_rows($result);
$data['restName'] = $row['restName'];
$data['description'] = $row['description'];
$data['email'] = $row['email'];
$data['address'] = $row['address'];

// Free and close query+connection
mysqli_free_result($result);
mysqli_close($con);

// Send data to dish.html
echo json_encode($data);
exit;
?>