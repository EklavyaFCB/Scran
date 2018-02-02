<?php

    $restID = $_POST['restID'];

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
    $getRestInfo = "SELECT restName, email, description, address FROM Restaurant WHERE restID='".$restID."'";

    $result = mysqli_query($con,$getRestInfo);
    $result || die("Database access failed: ".mysqli_error($con));

    $row = mysqli_fetch_assoc($result);

    $data['restName'] = $row['restName'];
    $data['email'] = $row['email'];
    $data['description'] = $row['description'];
    $data['address'] = $row['address'];

    // Free and close
    mysqli_free_result($result);
    mysqli_close($con);
    
    //Send data back to editprofile.html
    echo json_encode($data);
    exit;
?>