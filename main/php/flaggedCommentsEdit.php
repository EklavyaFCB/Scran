<?php
    $action = $_POST['action'];
    $reviewID = $_POST['reviewID'];
    //Escape chars in string to prevent sql injection

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    if ($action == 1) {
        $query = "UPDATE DishReview SET flagged = 0 WHERE reviewID = '$reviewID';";
    } else if ($action != 1) {
        $query = "DELETE FROM DishReview WHERE reviewID = '$reviewID';";
    }


    $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error()."<br><br>");

    // Encoding all characters interacting with MySQL in UTF-8
    mysqli_set_charset($db_con,"utf8");

    //Check for username in db
    $result = mysqli_query($db_con, $query);
    
    mysqli_free_result($result);
    mysqli_close($con);

    exit;
?>


