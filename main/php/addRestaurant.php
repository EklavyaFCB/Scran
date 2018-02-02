<?php
    $restName = $_POST['restName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    if ($_POST['description'] === '') {
        $description = NULL;
    }else {
        $description = $_POST['description'];
    }

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    if (!preg_match("~^[\p{L}\p{Z}]+$~u", $restName)) {
        $data['success'] = false;
        $data['message'] = 'ERROR: RESTAURANT NAME INVALID. Only letters and spaces allowed';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $data['success'] = false;
        $data['message'] = "ERROR: EMAIL INVALID. Please enter a valid email address";
    } else if (!preg_match("/^[a-zA-Z0-9,.&\- ]*$/", $address)) {
        $data['success'] = false;
        $data['message'] = "ERROR: ADDRESS INVALID. Only letters, spaces, numbers and certain special characters (,.&-) allowed";
    } else if ((!preg_match("[a-zA-Z0-9,.!?&\- ]*$", $description)) && (!$description === NULL)) {
        $data['success'] = false;
        $data['message'] = "ERROR: DESCRIPTION INVALID. Only letters, spaces, numbers and certain special characters (,.!?&-) allowed";
    } else {
        $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
        if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());
        mysqli_set_charset($db_con,"utf8");

        $query = "SELECT restName, restID FROM Restaurant WHERE restName = '$restName';";
        $result = mysqli_query($db_con, $query);
        $row = mysqli_fetch_assoc($result);
        $restID = $row["restID"];

        if ($num_rows = mysqli_num_rows($result) == 0){
            $query = "INSERT INTO Restaurant (restID, restName, email, address, restRating, verified, description) VALUES (0, '$restName', '$email', '$address', 0, 0, '$description');";
            $result = mysqli_query($db_con, $query);
            $data['success'] = true;
            $data['message'] = "SUCCESS: The restaurant has been added";
        } else {
            $data['success'] = false;
            $data['message'] = "ERROR: This restaurant already exists";
        }
    }
    mysqli_free_result($result);
    mysqli_close($db_con);
    //Send data back to addRestaurant.html
    echo json_encode($data);
    exit;
?>