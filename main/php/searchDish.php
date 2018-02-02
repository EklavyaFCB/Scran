<?php
    //
    $search = $_POST['search'];

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error()."<br><br>");
	mysqli_set_charset($db_con,"utf8");

    $data = array();
    $dishIDs = array();

	//loop through 10 times, add the IDs to an array that gets sent to search results 
	 while ($count <=20) {
    	$query = "SELECT dishID FROM Dish WHERE dishName LIKE '%$search%' OR description LIKE '%$search%' OR cuisine LIKE '%$search%' OR mainIngredient1 LIKE '%$search%' OR mainIngredient2 LIKE '%$search%' OR mainIngredient3 LIKE '%$search%' OR mainIngredient4 LIKE '%$search%' OR mainIngredient5 LIKE '%$search%'  ORDER BY RAND() LIMIT 1;";

    	$result = mysqli_query($db_con, $query);
    	$row = mysqli_fetch_assoc($result);

        if (!empty($row["dishID"])) {
    	$dishID = $row["dishID"];
    	if (in_array($dishID, $data) == 0) {
	    	array_push($data, $dishID);
    	} 
    }
        $count++;
    }

    mysqli_free_result($result);
    mysqli_close($db_con);
    //Send data back to registerUser.html
    echo json_encode($data);
    exit;
?>
       