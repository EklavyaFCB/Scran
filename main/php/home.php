
<?php
    //echo "<h1>  test55 </h1>";
    $userID = $_POST['userID'];
    //$userID = 153;

    $db_hostname = "mysql";
    $db_database = "u5dc";
    $db_username = "u5dc";
    $db_password = "12-abcd-34";

    $db_con = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
    if (!$db_con) die("ERROR: Cannot connect to MySQL: ".mysqli_connect_error()."<br><br>");
    mysqli_set_charset($db_con,"utf8");

    $data = array();
    $dishID = array();
    $greenIngredients = array();
    $amberIngredients = array();
    $redIngredients = array();
    //Add ingredients even if some of dish are null

    $query = "SELECT mainIngredient1 FROM Dish JOIN DishReview ON DishReview.dishID = Dish.dishID WHERE DishReview.userID = '$userID' AND DishReview.rating = 'green' AND Dish.mainIngredient1 IS NOT NULL ORDER BY RAND() LIMIT 8;";
    $result = mysqli_query($db_con, $query);

    if ($num_rows = mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            array_push($greenIngredients, $rows["mainIngredient1"]);  
        }

    }

    // mysqli_free_result($result);
    $query = "SELECT mainIngredient1 FROM Dish JOIN DishReview ON DishReview.dishID = Dish.dishID WHERE DishReview.userID = '$userID' AND DishReview.rating = 'amber' AND Dish.mainIngredient1 IS NOT NULL ORDER BY RAND() LIMIT 8;";
    $result = mysqli_query($db_con, $query);
    //$num_rows = 0;
    if ($num_rows = mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            array_push($amberIngredients, $rows["mainIngredient1"]);  
        }
    } else {
        mysqli_free_result($result);
        $query = "SELECT mainIngredient1 FROM Dish WHERE Dish.mainIngredient1 IS NOT NULL ORDER BY RAND() LIMIT 8;";
        $result = mysqli_query($db_con, $query);
        if ($num_rows = mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                array_push($redIngredients, $rows["mainIngredient1"]);  
            }   
        }
    }

    for ($i=0; $i<= 15; $i++) {
        $ingr1Index = rand(0, sizeof($greenIngredients)-1);

        $query = "SELECT dishID FROM Dish WHERE mainIngredient1 = '$greenIngredients[$ingr1Index]' OR mainIngredient2 = '$greenIngredients[$ingr1Index]' OR mainIngredient3 = '$greenIngredients[$ingr1Index]' OR mainIngredient4 = '$greenIngredients[$ingr1Index]' ORDER BY RAND() LIMIT 1;";
        $result = mysqli_query($db_con, $query);
        $rows = mysqli_fetch_assoc($result);

        $dishID = $rows["dishID"];
        if (in_array($dishID, $data) == 0) {
            array_push($data, $dishID);
        } 
    }

    if (count($data) < 20) {
           //get results from amber
        for ($i=0; $i<= 15; $i++) {

            $ingr1Index = rand(0, sizeof($amberIngredients)-1);

            $query = "SELECT dishID FROM Dish WHERE mainIngredient1 = '$amberIngredients[$ingr1Index]' OR mainIngredient2 = '$amberIngredients[$ingr1Index]' OR mainIngredient3 = '$amberIngredients[$ingr1Index]' OR mainIngredient4 = '$amberIngredients[$ingr1Index]' ORDER BY RAND() LIMIT 1;";
            $result = mysqli_query($db_con, $query);
            $rows = mysqli_fetch_assoc($result);

            $dishID = $rows["dishID"];
            if (in_array($dishID, $data) == 0) {
                array_push($data, $dishID);
            } 
        }
    }
        if (count($data) < 20) {
            for ($i=0; $i<= 30; $i++) {
                $ingr1Index = rand(0, sizeof($redIngredients)-1);
                $ingr2Index = rand(0, sizeof($redIngredients)-1);
                $ingr3Index = rand(0, sizeof($redIngredients)-1);

                $query = "SELECT dishID FROM Dish WHERE mainIngredient1 = '$redIngredients[$ingr1Index]' OR mainIngredient2 = '$redIngredients[$ingr2Index]' OR mainIngredient3 = '$redIngredients[$ingr3Index]' OR mainIngredient4 = '$redIngredients[$ingr1Index]' ORDER BY RAND() LIMIT 1;";
                $result = mysqli_query($db_con, $query);
                $rows = mysqli_fetch_assoc($result);

                $dishID = $rows["dishID"];
                if (in_array($dishID, $data) == 0 && count($data) < 20) {
                    array_push($data, $dishID);
                } 
            }
       }

    mysqli_free_result($result);
    mysqli_close($db_con);
    // //Send data back to registerUser.html
    echo json_encode($data);
    exit;
    //AND cuisine = '$cuisine[$cuisineIndex]' AND diet = '$diet[$dietIndex]' AND specialReq = '$req[$reqIndex]'
?>