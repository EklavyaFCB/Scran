<?php
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass0 = $_POST['password'];
    $email = $_POST['email'];
    $pass1 = $_POST['passwordReenter'];
    $userType = $_POST['userType'];

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

        if (preg_match("/[^A-Za-z0-9]/", $username)) {
            $data['success'] = false;
            $data['message'] = 'ERROR: USERNAME INVALID. Only alphanumeric allowed';
            //$data['invalid'] = $matches;
        } else if (preg_match("/[^A-Za-z0-9@!#$%&'*+-\/=?^_`{|}~]/", $email)) {
            $data['success'] = false;
            $data['message'] = "ERROR: EMAIL INVALID. Only alphanumeric and (@!#$%&'*+-/=?^_`{|}~) allowed";
            //$data['invalid'] = $matches;
        } else if (preg_match("/[^A-Za-z0-9@!#$%&'*+-\/=?^_`{|}~]/", $pass0) || preg_match("/[^A-Za-z0-9@!#$%&'*+-\/=?^_`{|}~]/", $pass1)) {
            $data['success'] = false;
            $data['message'] = "ERROR: PASSWORD INVALID. Only alphanumeric and (@!#$%&'*+-/=?^_`{|}~) allowed";
            //$data['invalid'] = $matches;
        } else if ($pass0 != $pass1 || $pass1 != $pass0) {
            $data['success'] = false;
            $data['message'] = 'ERROR: Passwords do NOT match';
            //$data['invalid'] = $matches;
        } else {
            $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
            if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error());
            mysqli_set_charset($db_con,"utf8");

            $query = "SELECT username, userID, emailAddress FROM User WHERE username = '$username' OR emailAddress = '$email';";
            $result = mysqli_query($db_con, $query);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["userID"];
            $emailAddress = $row["emailAddress"];
            $data['emailAddress'] = $emailAddress;
            $data['email'] = $email;

            if ($email != $emailAddress) {
                if ($num_rows = mysqli_num_rows($result) == 0){
            		$query = "INSERT INTO User (userID, userType, username, password, emailAddress, karma, adminComments) VALUES (0, 'User', '$username', '$pass0', '$email', 0, 'NONE');";

                	$result = mysqli_query($db_con, $query);
                    $data['success'] = true;
                    $data['message'] = "SUCCESS: Your account has been registered";
                    $data['username'] = $username; 
                    $data['userType'] = $userType; 
                    $data['userID'] = $userID; 
            	} else {
                    $data['success'] = false;
                    $data['message'] = "ERROR: Username is already in use";
                }
            } else {
                $data['success'] = false;
                $data['message'] = "ERROR: Email is already in use";
            }
        }
    mysqli_free_result($result);
    mysqli_close($db_con);
    //Send data back to registerUser.html
    echo json_encode($data);
    exit;
?>
       