<?php
    $name = $_POST['restaurantName'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $pass0 = $_POST['password'];
    $pass1 = $_POST['passwordReenter'];

    if ($_POST['description'] === '') {
        $description = NULL;
    }else {
        $description = $_POST['description'];
    }

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";


        if (preg_match("/[^A-Za-z-:. \"0-9]/", $name)) {
            $data['success'] = false;
            $data['message'] = "ERROR: USERNAME INVALID. Only alphanumeric and (-:.) allowed";
            //$data['invalid'] = $matches;
        } else if (preg_match("/[^A-Za-z0-9@!#$%&'*+-\/=?^_`{|}~]/", $email)) {
            $data['success'] = false;
            $data['message'] = "ERROR: EMAIL INVALID. Only alphanumeric and (@!#$%&'*+-/=?^_`{|}~) allowed";
            //$data['invalid'] = $matches;
        } else if (preg_match("/[^A-Za-z0-9@!#$%&'*+-\ /=?^_`{|}~]/", $pass0) || preg_match("/[^A-Za-z0-9@!#$%&'*+-\ /=?^_`{|}~]/", $pass1)) {
            $data['success'] = false;
            $data['message'] = "ERROR: PASSWORD INVALID. Only alphanumeric and (@!#$%&'*+-/=?^_`{|}~) allowed";
            //$data['invalid'] = $matches;
        } else if ($pass0 != $pass1 || $pass1 != $pass0) {
            $data['success'] = false;
            $data['message'] = "ERROR: Passwords do NOT match";
            //$data['invalid'] = $matches;
        } else if ((!preg_match("[a-zA-Z0-9,.!? ]*$", $description)) && (!$description === NULL)) {
            $data['success'] = false;
            $data['message'] = "ERROR: DESCRIPTION INVALID. Special characters such as ';' or '[' are not allowed";

        } else {
            $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
            mysqli_set_charset($db_con,"utf8");
            if (!$db_con) die($data['message'] = "ERROR: Cannot connect to database");

            $query = "SELECT restID, restName, verified FROM Restaurant WHERE restName = '$name';";
            $result = mysqli_query($db_con, $query);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["userID"];
            $verified = $row['verified'];

            if ($num_rows = mysqli_num_rows($result) == 0) {
                $query = "INSERT INTO Restaurant (restID, restName, email, address, password, restRating, verified, description) VALUES (0, '$name', '$email', '$address', '$pass0', 0, 1, $description);";

                $result = mysqli_query($db_con, $query);
                $data['success'] = true;
                $data['message'] = "SUCCESS: Your account has been registered";
                $data['name'] = $name;
                $data['userType'] = "Restaurant";
                $data['restID'] = $restID;
            } else if ($verified == 0) {
                $query = "UPDATE Restaurant SET email = '$email', address = '$address', password = '$pass0', verified = 1, description = '$description' WHERE restName = '$name';";

                $result = mysqli_query($db_con, $query);
                $data['success'] = true;
                $data['message'] = "SUCCESS: Your account has been registered \n NOTE: This restaurant already has data entered for it. Please check your restaurant page for inaccuracies";
                $data['name'] = $name;
                $data['userType'] = "Restaurant";
                $data['restID'] = $row['restID'];
        	} else {
                $data['success'] = false;
                $data['message'] = "ERROR: Username is already in use";
            }
        }
    mysqli_free_result($result);
    mysqli_close($db_con);
    //Send data back to registerUser.html
    echo json_encode($data);
    exit;
?>
       