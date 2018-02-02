<?php
    $commNum = $_POST['count'];
    //Escape chars in string to prevent sql injection

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error()."<br><br>");

    // Encoding all characters interacting with MySQL in UTF-8
    mysqli_set_charset($db_con,"utf8");

    //Check for username in db
    $query = "SELECT reviewID, userID, comment, flagged FROM DishReview WHERE flagged > 0 LIMIT $commNum,1;";
    $result = mysqli_query($db_con, $query);
    $row1 = mysqli_fetch_assoc($result);
    $reviewID = $row1["reviewID"];
    $userID = $row1["userID"];
    $comment = $row1["comment"];
    $flagged = $row1["flagged"];
    
    $query = "SELECT username FROM User JOIN DishReview ON User.userID = DishReview.userID WHERE User.userID = '$userID';";
    $result = mysqli_query($db_con, $query);
    $row2 = mysqli_fetch_assoc($result);
    $username = $row2["username"];
    
    $data['reviewID'] = $reviewID;
    $data['username'] = $username;
    $data['comment'] = $comment; 
    $data['flagged'] = $flagged; 

    mysqli_free_result($result);
    mysqli_close($db_con);

    echo json_encode($data);
    exit;
?>