<?php
$dishIDToLoad = $_POST['dishIDToLoad'];

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

// Data display query
$getDishData = "SELECT D.restID, D.course, D.dishName, D.description, D.cuisine, D.diet, D.specialReq, D.mainIngredient1, D.mainIngredient2, D.mainIngredient3, D.mainIngredient4, D.mainIngredient5, D.greenPoints, D.amberPoints, D.redPoints, R.restName
                FROM Dish D JOIN Restaurant R ON D.restID=R.restID
                WHERE dishID = '$dishIDToLoad';";
$result = mysqli_query($con,$getDishData);
$result || die("Database access failed: ".mysqli_error($con));

$row = mysqli_fetch_assoc($result);
$data['success'] = true;
$data['restID'] = $row['restID'];
$data['restName'] = $row['restName'];
$data['greenPoints'] = $row['greenPoints'];
$data['amberPoints'] = $row['amberPoints'];
$data['redPoints'] = $row['redPoints'];
$data['course'] = $row['course'];
$data['dishName'] = $row['dishName'];
if (!($row['description'] === 'NULL')) {
    $data['description'] = $row['description'];
}
$data['cuisine'] = $row['cuisine'];
$data['diet'] = $row['diet'];
if (!($row['specialReq'] === 'NULL')) {
    $data['specialReq'] = $row['specialReq'];
}
$data['mainIngredient1'] = $row['mainIngredient1'];
if (!($row['mainIngredient2'] === 'NULL')) {
    $data['mainIngredient2'] = $row['mainIngredient2'];
}
if (!($row['mainIngredient3'] === 'NULL')) {
    $data['mainIngredient3'] = $row['mainIngredient3'];
}
if (!($row['mainIngredient4'] === 'NULL')) {
    $data['mainIngredient4'] = $row['mainIngredient4'];
}
if (!($row['mainIngredient5'] === 'NULL')) {
    $data['mainIngredient5'] = $row['mainIngredient5'];
}

// Free and close query+connection
mysqli_free_result($result);
mysqli_close($con);

// Send data to dish.html
echo json_encode($data);
exit;
?>