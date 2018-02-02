<?php
    if ($_POST['restName'] == NULL ) {
        $restName = $_POST['username'];
    } else {
        $restName = $_POST['restName'];
    }
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());

    // Encoding all characters interacting with MySQL in UTF-8
    mysqli_set_charset($db_con,"utf8");

    $restNameCheck = "SELECT restName FROM Restaurant WHERE restName = '$restName';";
    $result = mysqli_query($db_con, $restNameCheck);

    if (!preg_match("~^[\p{L}\p{Z}]+$~u", $restName)) {
        $data['success'] = false;
        $data['message'] = 'ERROR: RESTAURANT NAME INVALID. Only letters and spaces allowed';
    } elseif ($num_rows = mysqli_num_rows($result) == 0){
        $data['success'] = false;
        $data['message'] = 'ERROR: RESTAURANT NAME INVALID. Restaurant does not exist in the database';
    } else if ((!preg_match("~^[\p{L}\p{Z}]+$~u", $description)) && (!$description === NULL)) {
        $data['success'] = false;
        $data['message'] = "ERROR: DESCRIPTION INVALID. Only letters and spaces allowed";
    } else if ((!preg_match("~^[\p{L}\p{Z}]+$~u", $requirements)) && (!$requirements === NULL)) {
        $data['success'] = false;
        $data['message'] = "ERROR: REQUIREMENTS INVALID. Only letters and spaces allowed";
    } else {
        $query = "SELECT O.Description, O.Requirements, R.restName FROM Offers O JOIN Restaurant R ON O.RestID=R.restID WHERE O.Description = '$description' AND O.Requirements = '$requirements' AND R.restName = '$restName';";
        $result = mysqli_query($db_con, $query);

        if ($num_rows = mysqli_num_rows($result) == 0) {
            $queryRest = "SELECT restID FROM Restaurant WHERE restName = '$restName';";
            $result = mysqli_query($db_con, $queryRest);
            $row = mysqli_fetch_assoc($result);
            $restID = $row['restID'];
            $query = "INSERT INTO Offers (OfferID, RestID, Description, Requirements) VALUES (0, '$restID', '$description', '$requirements');";
            $result = mysqli_query($db_con, $query);
            $data['success'] = true;
            $data['message'] = "SUCCESS: The offer has been added";
        } else {
            $data['success'] = false;
            $data['message'] = "ERROR: This offer already exists";
        }
    }
    mysqli_free_result($result);
    mysqli_close($db_con);
    //Send data back to registerUser.html
    echo json_encode($data);
    exit;
?>