<?php

    $restID = $_POST['restID'];

    $updatedName = $_POST['nameForm'];
    $updatedEmail = $_POST['emailForm'];
    $updatedDescription = $_POST['descriptionForm'];
    $updatedAddress = $_POST['addressForm'];

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
    // Query 2 -------------------------------------------------------------
    // $updateRestInfo = "UPDATE Restaurant SET email='".$updatedEmail."', description='".$updatedDescription."', address='".$updatedAddress."' WHERE restID='".$restID"'";

    $updateQ = "UPDATE Restaurant SET restName='".$updatedName."' , email='".$updatedEmail."' , description='".$updatedDescription."' , address='".$updatedAddress."' WHERE restID='".$restID."'";

    // $updateQ = "UPDATE Restaurant SET email='lolwut@gmail.com' , description='Charlotte hates everything tho' , address='L1 DA HOUSE' WHERE restID='22'";

    $result = mysqli_query($con,$updateQ);
    $result || die("Database access failed: ".mysqli_error($con));

    // Query 3 -------------------------------------------------------------
    //$getRestInfo = "SELECT email, description, address FROM Restaurant WHERE restID='".$restID."'";

    //$result = mysqli_query($con,$getRestInfo);
    //$result || die("Database access failed: ".mysqli_error($con));

    //$row = mysqli_fetch_assoc($result);

    // $data['emailUpdt'] = $row['email'];
    // $data['descriptionUpdt'] = $row['description'];
    // $data['addressUpdt'] = $row['address'];

    // Free and close
    mysqli_free_result($result);
    mysqli_close($con);
    
    //Send data back to editprofile.html
    echo json_encode($data);

    exit;
?>