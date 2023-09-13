<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE || $_SESSION['AdminStatus'] !== "ADMIN") {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .recipeImg {
            width: 100px;
            border-radius: 10px;
            margin-left: 10px;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats Page</title>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
</head>
<body>
    <?php
        $path = "/include/header.php";
        include($root.$path);

        $path = "/include/menu.php";
        include($root.$path);
    ?>

    <div class='container'>
        <h1>Admin Stats Page</h1>
        <hr>
        <p><b>Most Popular Dish:</b></p>
        <?php 
            $sql = "SELECT * FROM `Recipes` ORDER BY Ratings DESC;";
            $result = $mysqli->query($sql);
            $recordData = $result->fetch_assoc();

            echo "$recordData[Dish_Name]";
            //print_r($result);
        ?>
        <br>
        <hr>
        <p><b>Least Popular Dish:</b></p>
        <?php
            $sql = "SELECT * FROM `Recipes` ORDER BY Ratings;";
            $result = $mysqli->query($sql);
            $recordData = $result->fetch_assoc();

            echo "$recordData[Dish_Name]";

            echo "<br>";
            $imgPath = $recordData['Recipe_Image'];

            echo "<img class='recipeImg' src='../recipePages/recipeImages/$imgPath' alt='Recipe Image Displayed'>";
        ?>
        <hr>
        <p><b>Least Used ingredient:</b></p>
        <?php
            $sql = "SELECT * FROM `Junction_Rel` ORDER BY Ingredient_Ref DESC;";
            $result = $mysqli->query($sql);
            $recordData = $result->fetch_assoc();
            $highestIng = $recordData['Ingredient_Ref'];

            $lowIngredientRef;
            $curCount = 9999999999999999999999999999999;

            //echo $highestIng;

            for($i = $highestIng; $i > 0; $i--) {
                $sql = "SELECT * FROM `Junction_Rel` WHERE Ingredient_Ref LIKE '$i';";
                $result = $mysqli->query($sql);
                //print_r($result); //test
                $count = mysqli_num_rows($result);
                $recordData = $result->fetch_assoc();
                $IngredientRef = $recordData['Ingredient_Ref'];
                if($count < $curCount) {
                    $curCount = $count;
                    $lowIngredientRef = $IngredientRef;
                }

            }

            $sql = "SELECT * FROM `Ingredients` WHERE Ingredient_ID LIKE '$lowIngredientRef';";
            $result = $mysqli->query($sql);
            $recordData = $result->fetch_assoc();
            $name = $recordData['Ingredient_Name'];

            echo $name;

        ?>
        <hr>
        <p><b>Dish cooked longest ago:</b></p>
        <?php 
            $sql = "SELECT * FROM `Recipes` ORDER BY Last_Cooked;";
            $result = $mysqli->query($sql);
            $recordData = $result->fetch_assoc();
            $name = $recordData['Dish_Name'];

            echo $name;
        ?>
        <hr>

        <p><b>Dish cooked most recently:</b></p>
        <?php
            $sql = "SELECT * FROM `Recipes` ORDER BY Last_Cooked DESC;";
            $result = $mysqli->query($sql);
            $recordData = $result->fetch_assoc();
            $name = $recordData['Dish_Name'];

            echo $name;

            $imagePage = $recordData['Recipe_Image'];

            echo "<br>";

            echo "<img class='recipeImg' src='../recipePages/recipeImages/$imagePage' alt='Recipe Image Displayed'>";
        ?>
        <hr>
    </div>

    <hr>
    <?php
        $path = "/include/footer.php";
        include($root.$path);
        
        $mysqli->close();
    ?>
</body>
</html>