<?php

    $data['favRest'] = $_POST['favRestForm'];
    $data['favCuisine'] = $_POST['favCuisineForm'];
    $data['favDish'] = $_POST['favDishForm'];

    // Encoding all characters interacting with MySQL in UTF-8
    mysqli_set_charset($con,"utf8");
    
    //Send data back to editprofile.html
    echo json_encode($data);
    exit;
?>