<?php
$dishID = $_POST['dishIDToLoad'];
$userID = $_POST['userID'];

// Database Variables
$db_hostname = "mysql";
$db_database = "u5dc";
$db_username = "u5dc";
$db_password = "12-abcd-34";

// Connection to database
$db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
if (!$db_con) die("Unable to connect to MySQL: ".mysqli_connect_error());

// Encoding all characters interacting with MySQL in UTF-8
mysqli_set_charset($db_con,"utf8");

//Check for username in db
$query = "SELECT D.reviewID, D.comment, D.reviewDate, U.username FROM DishReview D JOIN User U ON D.userID=U.userID WHERE D.dishID = '$dishID' AND D.userID NOT IN ('$userID') AND D.comment NOT IN ('') ORDER BY D.reviewDate DESC LIMIT 5;";
$result = mysqli_query($db_con, $query);
$result || die("Database access failed: ".mysqli_error($db_con));

while($row = mysqli_fetch_array($result)) {
    $reviewID = $row['reviewID'];
    $comment = $row['comment'];
    $reviewDate = $row['reviewDate'];
    $username = $row['username'];

    $return_array[] = array("reviewID" => $reviewID, "comment" => $comment, "reviewDate" => $reviewDate, "username" => $username);
}

mysqli_free_result($result);
mysqli_close($db_con);

echo json_encode($return_array);
exit;
?>