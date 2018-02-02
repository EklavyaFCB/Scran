<?php

    $username = $_POST['usn'];
    $data['username'] = $username;

    $userID = $_POST['usnID'];
    $data['userID'] = $userID;

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

    // Query processing

    // Query 1 -------------------------------------------------------------
    $getDish1 = "SELECT dishID, dishName, description FROM Dish WHERE dishID=(SELECT dishID FROM DishReview WHERE reviewDate=(SELECT MAX(reviewDate) FROM DishReview WHERE userID='".$userID."'))";

    $result = mysqli_query($con,$getDish1);
    $result || die("Database access failed: ".mysqli_error($con));

    $row = mysqli_fetch_assoc($result);

    $data['dishID1'] = $row['dishID'];
    $data['dishName1'] = $row['dishName'];
    $data['dishDescription1'] = $row['description'];

    // Query 2 -------------------------------------------------------------

    $getDish2 = "SELECT dishID, dishName, description FROM Dish WHERE dishID=(SELECT dishID FROM DishReview WHERE reviewDate=(SELECT reviewDate FROM DishReview WHERE userID='".$userID."' ORDER BY reviewDate DESC LIMIT 1,1))";

    $result = mysqli_query($con,$getDish2);
    $result || die("Database access failed: ".mysqli_error($con));

    $row = mysqli_fetch_assoc($result);

    $data['dishID2'] = $row['dishID'];
    $data['dishName2'] = $row['dishName'];
    $data['dishDescription2'] = $row['description'];

    // Query 3 -------------------------------------------------------------

    $getEmail = "SELECT emailAddress, userType, karma FROM User WHERE username='".$username."'";
    $result = mysqli_query($con,$getEmail);
    $result || die("Database access failed: ".mysqli_error($con));

    $row = mysqli_fetch_assoc($result);

    $data['email'] = $row['emailAddress'];
    $data['userType'] = $row['userType'];
    $data['karma'] = $row['karma'];

    // Query 4 -------------------------------------------------------------

    $getDish3 = "SELECT dishID, dishName, description FROM Dish WHERE dishID=(SELECT dishID FROM DishReview WHERE reviewDate=(SELECT reviewDate FROM DishReview WHERE userID='".$userID."' ORDER BY reviewDate DESC LIMIT 2,1))";

    $result = mysqli_query($con,$getDish3);
    $result || die("Database access failed: ".mysqli_error($con));

    $row = mysqli_fetch_assoc($result);

    $data['dishID3'] = $row['dishID'];
    $data['dishName3'] = $row['dishName'];
    $data['dishDescription3'] = $row['description'];

    // Query 5 -------------------------------------------------------------

    $getDish3 = "SELECT dishID, dishName, description FROM Dish WHERE dishID=(SELECT dishID FROM DishReview WHERE reviewDate=(SELECT reviewDate FROM DishReview WHERE userID='".$userID."' ORDER BY reviewDate DESC LIMIT 3,1))";

    $result = mysqli_query($con,$getDish3);
    $result || die("Database access failed: ".mysqli_error($con));

    $row = mysqli_fetch_assoc($result);

    $data['dishID4'] = $row['dishID'];
    $data['dishName4'] = $row['dishName'];
    $data['dishDescription4'] = $row['description'];

    // Free and close 
    mysqli_free_result($result);
    mysqli_close($con);
    
    //Send data back to profile.html
    echo json_encode($data);
    exit;
?>