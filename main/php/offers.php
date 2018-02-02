<?php

    $username = $_POST['usn'];
    $data['username'] = $username;
    $restID = 1; // Weeky offer restID

    // Database Variables
    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";
 
    // Connection to database
    $con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$con) die("Unable to connect to MySQL: ".mysqli_connect_error());
    mysqli_set_charset($con,"utf8");


    // Encoding all characters interacting with MySQL in UTF-8
    mysqli_set_charset($con,"utf8");

    // Query processing

    // Query 1 -------------------------------------------------------------
    $getWeekOffer = "SELECT Offers.RestID, Restaurant.restName, Restaurant.address, Offers.Description, Offers.Requirements FROM Restaurant INNER JOIN Offers ON Offers.RestID=Restaurant.restID WHERE Restaurant.restID=$restID";

    $result = mysqli_query($con,$getWeekOffer);
    $result || die("Database access failed: ".mysqli_error($con));

    while ($row = mysqli_fetch_assoc($result)) {
        $restName = $row['restName'];
        $address = $row['address'];
        $Description = $row['Description'];
        $Requirements = $row['Requirements'];

        $return_array[] = array("restName" => $restName, "address" => $address, "Description" => $Description, "Requirements" => $Requirements);
    }

    // One Query to rule them all ----------------------------------------
    $getAllOffers = "SELECT Restaurant.restName, Restaurant.address, Offers.Description, Offers.Requirements FROM Restaurant INNER JOIN Offers ON Offers.RestID=Restaurant.restID WHERE Offers.RestID NOT IN ($restID) ORDER BY rand() LIMIT 4";

    $result = mysqli_query($con,$getAllOffers);
    $result || die("Database access failed: ".mysqli_error($con));

    while($row = mysqli_fetch_array($result)) {
        $restName = $row['restName'];
        $address = $row['address'];
        $Description = $row['Description'];
        $Requirements = $row['Requirements'];

        $return_array[] = array("restName" => $restName, "address" => $address, "Description" => $Description, "Requirements" => $Requirements);
    }

    // Free and close -----------------------------------------------------------

    mysqli_free_result($result);
    mysqli_close($con);
    
    //Send data back to profile.html
    echo json_encode($return_array);
    exit;

?>