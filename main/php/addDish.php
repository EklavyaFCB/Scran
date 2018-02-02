<?php

    $restID = $_POST['restIDToLoad'];
    $dishName = $_POST['dishName'];
    $cuisine = $_POST['cuisine'];
    $course = $_POST['course'];
    $diet = $_POST['diet'];
    $mainIngredient1 = $_POST['mainIngredient1'];
    if($_POST['mainIngredient2'] === ''){
        $mainIngredient2 = NULL;
    }else{
    	$mainIngredient2 = $_POST['mainIngredient2'];
    }if($_POST['mainIngredient3'] === ''){
        $mainIngredient3 = NULL;
    }else{
    	$mainIngredient3 = $_POST['mainIngredient3'];
    }if($_POST['mainIngredient4'] === ''){
        $mainIngredient4 = NULL;
    }else{
    	$mainIngredient4 = $_POST['mainIngredient4'];
    }if($_POST['mainIngredient5'] === ''){
        $mainIngredient5 = NULL;
    }else{
    	$mainIngredient5 = $_POST['mainIngredient5'];
    }if($_POST['description'] === ''){
        $description = NULL;
    }else{
    	$description = $_POST['description'];
    }if($_POST['specialReq'] === ''){
        $specialReq = NULL;
    }else{
    $specialReq = $_POST['specialReq'];
    }

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";


    if (!(preg_match("/^[a-zA-Z\s]+$/", $dishName))) {
        $data['success'] = false;
        $data['message'] = 'ERROR: DISH NAME INVALID. Only letters and spaces allowed';
        $data['dishName'] = $dishName;
    } else if (!(preg_match("~^[\p{L}\p{Z}]+$~u", $mainIngredient1))) {
        $data['success'] = false;
        $data['message'] = "ERROR: MAIN INGREDIENT 1 INVALID. Only letters and spaces allowed";
        $data['mainIngredient1'] = $mainIngredient1;
    } else if ((!(preg_match("~^[\p{L}\p{Z}]+$~u", $mainIngredient2))) && (!($mainIngredient2 === NULL))) {
        $data['success'] = false;
        $data['message'] = "ERROR: MAIN INGREDIENT 2 INVALID. Only letters and spaces allowed";
    } else if ((!(preg_match("~^[\p{L}\p{Z}]+$~u", $mainIngredient3))) && (!($mainIngredient3 === NULL))) {
        $data['success'] = false;
        $data['message'] = "ERROR: MAIN INGREDIENT 3 INVALID. Only letters and spaces allowed";
    } else if ((!(preg_match("~^[\p{L}\p{Z}]+$~u", $mainIngredient4))) && (!($mainIngredient4 === NULL))) {
        $data['success'] = false;
        $data['message'] = "ERROR: MAIN INGREDIENT 4 INVALID. Only letters and spaces allowed";
    } else if ((!(preg_match("~^[\p{L}\p{Z}]+$~u", $mainIngredient5))) && (!($mainIngredient5 === NULL))) {
        $data['success'] = false;
        $data['message'] = "ERROR: MAIN INGREDIENT 5 INVALID. Only letters and spaces allowed";
    } else if ((!(preg_match("[a-zA-Z0-9,.!?&\- ]*$", $description))) && (!($description === NULL))) {
        $data['success'] = false;
        $data['message'] = "ERROR: DESCRIPTION INVALID. Only letters, spaces, numbers and certain special characters (,.!?&-) allowed";
    } else if ((!(preg_match("[a-zA-Z0-9,.!?&\- ]*$", $specialReq))) && (!($specialReq === NULL))) {
        $data['success'] = false;
        $data['message'] = "ERROR: SPECIAL REQUIREMENTS INVALID. Only letters, spaces, numbers and certain special characters (,.!?&-) allowed";
    } else {
        $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
        if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());
        mysqli_set_charset($db_con,"utf8");

        $query = "SELECT dishName, dishID FROM Dish WHERE dishName = '$dishName' AND restID = '$restID';";
        $result = mysqli_query($db_con, $query);
        $row = mysqli_fetch_assoc($result);
        $dishID = $row["dishID"];

        if ($num_rows = mysqli_num_rows($result) == 0){
            $query = "INSERT INTO Dish (dishID, restID, dishRating, dishName, description, cuisine, course, diet, specialReq, date, mainIngredient1, mainIngredient2, mainIngredient3, mainIngredient4, mainIngredient5) VALUES (0, '$restID', 0, '$dishName', '$description', '$cuisine', '$course', '$diet', '$specialReq', now(), '$mainIngredient1', '$mainIngredient2', '$mainIngredient3', '$mainIngredient4', '$mainIngredient5');";
            $result = mysqli_query($db_con, $query);
            $data['success'] = true;
            $data['message'] = "SUCCESS: The dish has been added";
            $data['dishName'] = $dishName;
            $data['restID'] = $restID;
        } else {
            $data['success'] = false;
            $data['message'] = "ERROR: This dish already exists";
        }
    }
    mysqli_free_result($result);
    mysqli_close($db_con);
    //Send data back to registerUser.html
    echo json_encode($data);
    exit;
?>