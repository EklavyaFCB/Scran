<?php
$restID = $_POST['dishIDSearch'];
//$dishNum = $_POST['count'];
//$typeChoice = $_POST['choice'];

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

// Dish count query
//rest name join
$dishCount = "SELECT restID, restName, email, address FROM Restaurant WHERE restID = '$restID' ORDER BY RAND() LIMIT 1;";
$result = mysqli_query($con, $dishCount);
$result || die("Database access failed: ".mysqli_error($con));

$row = mysqli_fetch_assoc($result);
$data['restID'] = $row['restID'];
$data['restName'] = $row['restName'];
$data['email'] = $row['email'];
$data['address'] = $row['address'];

mysqli_free_result($result);
mysqli_close($con);

// Send data to dish.html
echo json_encode($data);
exit;
?>