<?php
    //Escape chars in string to prevent sql injection
	$username = $_POST['username'];
    $pass = $_POST['password'];

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error()."<br><br>");
    mysqli_set_charset($con,"utf8");


    // Encoding all characters interacting with MySQL in UTF-8
    mysqli_set_charset($db_con,"utf8");

    //Check for username in db
    $query = "SELECT username FROM User WHERE username = '$username' AND password = '$pass';";
    $result = mysqli_query($db_con, $query);
    
    if ($num_rows = mysqli_num_rows($result) == 0){
        $data['success'] = false;
        $data['message'] = 'ERROR: Username or password incorrect';
    } else {
        $query = "SELECT userID, userType FROM User WHERE username = '$username';";
        $result = mysqli_query($db_con, $query);
        $row = mysqli_fetch_assoc($result);

        $userID = $row["userID"];
        $userType = $row["userType"];
        
        $data['username'] = $username;
        $data['userID'] = $userID; 
        $data['userType'] = $userType; 
        $data['success'] = true;
	}
    echo json_encode($data);
    exit;
?>