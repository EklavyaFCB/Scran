<?php
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $dishID = $_POST['dishIDToLoad'];
    $userID = $_POST['userID'];

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    if ((!(preg_match("/^[a-zA-Z0-9,.!? ]*$/", $comment))) && (!($comment === NULL))) {
        $data['success'] = false;
        $data['message'] = "ERROR: COMMENT INVALID. Special characters such as ';' or '[' are not allowed";
    } else {

        $db_con = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
        if (!$db_con) die("ERROR: Cannot connect to MySQL: " . mysqli_connect_error());
        mysqli_set_charset($db_con, "utf8");


        $query = "SELECT reviewID FROM DishReview WHERE dishID = '$dishID' AND userID = '$userID';";
        $result = mysqli_query($db_con, $query);
        $row = mysqli_fetch_assoc($result);

        if ($num_rows = mysqli_num_rows($result) == 0) {
            //add comment into insert query
            $query1 = "INSERT INTO DishReview (reviewID, userID, dishID, comment, flagged, reviewDate, rating) VALUES (0, '$userID', '$dishID', '$comment', 0, now(), '$rating');";
            $result = mysqli_query($db_con, $query1);
            if ($rating === 'green') {
                $query2 = "UPDATE Dish SET greenPoints = greenPoints + 1, dishRating = dishRating + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } elseif ($rating === 'amber') {
                $query2 = "UPDATE Dish SET amberPoints = amberPoints + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } else {
                $query2 = "UPDATE Dish SET redPoints = redPoints + 1, dishRating = dishRating - 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            }
            $data['success'];
            $data['message'] = "SUCCESS: The dish review has been added";
        } elseif ($row['rating'] === 'green') {
            $query1 = "UPDATE Dish SET greenPoints = greenPoints - 1 WHERE dishID = '$dishID';";
            $query3 = "UPDATE DishReview SET rating = '$rating', reviewDate = now(), comment = '$comment' WHERE dishID = '$dishID' AND userID = '$userID';";
            $result = mysqli_query($db_con, $query1);
            $result = mysqli_query($db_con, $query3);
            if ($rating === 'green') {
                $query2 = "UPDATE Dish SET greenPoints = greenPoints + 1, dishRating = dishRating + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } elseif ($rating === 'amber') {
                $query2 = "UPDATE Dish SET amberPoints = amberPoints + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } else {
                $query2 = "UPDATE Dish SET redPoints = redPoints + 1, dishRating = dishRating - 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            }
            $data['success'];
            $data['message'] = "SUCCESS: The dish review has been added";
        } elseif ($row['rating'] === 'amber') {
            $query1 = "UPDATE Dish SET amberPoints = amberPoints - 1 WHERE dishID = '$dishID';";
            $query3 = "UPDATE DishReview SET rating = '$rating', reviewDate = now(), comment = '$comment' WHERE dishID = '$dishID' AND userID = '$userID';";
            $result = mysqli_query($db_con, $query1);
            $result = mysqli_query($db_con, $query3);
            if ($rating === 'green') {
                $query2 = "UPDATE Dish SET greenPoints = greenPoints + 1, dishRating = dishRating + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } elseif ($rating === 'amber') {
                $query2 = "UPDATE Dish SET amberPoints = amberPoints + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } else {
                $query2 = "UPDATE Dish SET redPoints = redPoints + 1, dishRating = dishRating - 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            }
            $data['success'];
            $data['message'] = "SUCCESS: The dish review has been added";
        } else {
            $query1 = "UPDATE Dish SET redPoints = redPoints - 1 WHERE dishID = '$dishID';";
            $query3 = "UPDATE DishReview SET rating = '$rating', reviewDate = now(), comment = '$comment' WHERE dishID = '$dishID' AND userID = '$userID';";
            $result = mysqli_query($db_con, $query1);
            $result = mysqli_query($db_con, $query3);
            if ($rating === 'green') {
                $query2 = "UPDATE Dish SET greenPoints = greenPoints + 1, dishRating = dishRating + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } elseif ($rating === 'amber') {
                $query2 = "UPDATE Dish SET amberPoints = amberPoints + 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            } else {
                $query2 = "UPDATE Dish SET redPoints = redPoints + 1, dishRating = dishRating - 1 WHERE dishID = '$dishID';";
                $result = mysqli_query($db_con, $query2);
            }
            $data['success'];
            $data['message'] = "SUCCESS: The dish review has been added";
        }
    }
    //$data['success'];
    //$data['userID'] = $userID;
    //$data['message'] = "SUCCESS: THAR BE YOUR USER ID";
    mysqli_free_result($result);
    mysqli_close($db_con);
    //Send data back to registerUser.html
    echo json_encode($data);
    exit;
?>