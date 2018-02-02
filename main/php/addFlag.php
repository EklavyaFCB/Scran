<?php
$reviewID = $_POST['reviewID'];

$db_hostname = "mysql";
$db_database = "u5dc";
$db_username = "u5dc";
$db_password = "12-abcd-34";

$db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());

// Encoding all characters interacting with MySQL in UTF-8
mysqli_set_charset($db_con,"utf8");

$query = "UPDATE DishReview SET flagged = flagged + 1 WHERE reviewID = '$reviewID';";
$result = mysqli_query($db_con, $query);
$result || die("Database access failed: ".mysqli_error($db_con));

$data['success'] = true;

mysqli_free_result($result);
mysqli_close($db_con);
//Send data back to registerUser.html
echo json_encode($data);
exit;
?>