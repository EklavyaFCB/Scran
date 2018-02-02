<?php
//php.get
	//echo "<h1> TEST 29 </h1>";
    //$course = $cuisine = $diet = $req = array();
    $course = $_POST['course'];
    $cuisine = $_POST['cuisine'];
    $diet = $_POST['diet'];
    $req = $_POST['req'];
 //    //2$distance = $_POST['distance'];

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());
	mysqli_set_charset($con,"utf8");

 //    // $courseSize = sizeof($course);
 //    // $cuisineSize = sizeof($cuisine);
    $data = array();
    $dishIDs = array();
    // //$coutn = 0;

    //echo "Query: $query"



    // //loop through 10 times, add the IDs to an array that gets sent to search results 
     while ($count <30) {

        $courseIndex = rand(0, sizeof($course)-1);
        $cuisineIndex = rand(0, sizeof($cuisine)-1);
        $dietIndex = rand(0, sizeof($diet)-1);
        $reqIndex = rand(0, sizeof($req)-1);

    if ($course == "" && $cuisine == "") {
    	$query = "SELECT dishID FROM Dish ORDER BY RAND() LIMIT 1;";
    } else if ($course != "" && $cuisine == "") {
    	$query = "SELECT dishID FROM Dish WHERE course = '$course[$courseIndex]' ORDER BY RAND() LIMIT 1;";
    } else if ($course == "" && $cuisine != "") {
        $query = "SELECT dishID FROM Dish WHERE cuisine = '$cuisine[$cuisineIndex]' ORDER BY RAND() LIMIT 1;";
    } else if ($diet == "" && $req != "") {
        $query = "SELECT dishID FROM Dish WHERE course = '$course[$courseIndex]' AND cuisine = '$cuisine[$cuisineIndex]' AND specialReq = '$req[$reqIndex]' ORDER BY RAND() LIMIT 1;";
    } else if ($diet != "" && $req == "") {
        $query = "SELECT dishID FROM Dish WHERE course = '$course[$courseIndex]' AND cuisine = '$cuisine[$cuisineIndex]' AND diet = '$diet[$dietIndex]' ORDER BY RAND() LIMIT 1;";
    } else if ($diet == "" && $req == "") {
        $query = "SELECT dishID FROM Dish WHERE course = '$course[$courseIndex]' AND cuisine = '$cuisine[$cuisineIndex]' ORDER BY RAND() LIMIT 1;";
    } else {
        $query = "SELECT dishID FROM Dish WHERE course = '$course[$courseIndex]' AND cuisine = '$cuisine[$cuisineIndex]' AND diet = '$diet[$dietIndex]' AND specialReq = '$req[$reqIndex]' ORDER BY RAND() LIMIT 1;";
    }
    	////$query = "SELECT dishID FROM Dish WHERE course = 'Starter' AND cuisine = 'British' AND diet = 'Vegetarian' AND specialReq = 'Nut Free' ORDER BY RAND() LIMIT 1;";
    	//$query = "SELECT dishID FROM Dish WHERE course = '$course[$courseIndex]' AND cuisine = '$cuisine[$cuisineIndex]' AND diet = '$diet[$dietIndex]' AND specialReq = '$req[$reqIndex]' ORDER BY RAND() LIMIT 1;";

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
	// //echo "<h3>$data</h3>";
    mysqli_free_result($result);
    mysqli_close($db_con);
 //    //Send data back to registerUser.html
    //$data['course'] = $course;
    echo json_encode($data);
    exit;
    //AND cuisine = '$cuisine[$cuisineIndex]' AND diet = '$diet[$dietIndex]' AND specialReq = '$req[$reqIndex]'
?>
       