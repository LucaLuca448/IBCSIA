<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    $desiredIngredientName = $_POST['ingredientNameSelect'];
    $desiredIngredientFeature = $_POST['ingredientFeatureSelect'];

    if(!empty($_POST['editing'])) {
        switch($desiredIngredientFeature) {
            case '0':
                header("Location: http://localhost:8081/IngredientPages/ingredientEdit.php");
                break;
            case 'Ingredient_Name':
                $toSQL = filter_input(INPUT_POST, 'textIn');
                $sql = "UPDATE `Ingredients` SET Ingredient_Name = '$toSQL' WHERE Ingredient_Name LIKE '$desiredIngredientName';";
                $mysqli->query($sql);
                header("Location: http://localhost:8081/IngredientPages/ingredientEdit.php");
                break;
            case 'Count_Num':
                $toSQL = filter_input(INPUT_POST, 'numIn');
                $sql = "UPDATE `Ingredients` SET Count_Num = '$toSQL' WHERE Ingredient_Name LIKE '$desiredIngredientName';";
                $mysqli->query($sql);
                header("Location: http://localhost:8081/IngredientPages/ingredientEdit.php");
                break;
            case 'WeightG':
                $toSQL = filter_input(INPUT_POST, 'numIn');
                $sql = "UPDATE `Ingredients` SET WeightG = '$toSQL' WHERE Ingredient_Name LIKE '$desiredIngredientName';";
                $mysqli->query($sql);
                header("Location: http://localhost:8081/IngredientPages/ingredientEdit.php");
                break;
            case 'Expiration_Date':
                $toSQL = filter_input(INPUT_POST, 'dateIn');
                $sql = "UPDATE `Ingredients` SET Expiration_Date = '$toSQL' WHERE Ingredient_Name LIKE '$desiredIngredientName';";
                $mysqli->query($sql);
                header("Location: http://localhost:8081/IngredientPages/ingredientEdit.php");
                break;
        }
    } else if(empty($_POST['ingredientNameSelect']) || empty($_POST['ingredientFeatureSelect'])) {
        header("Location: http://localhost:8081/IngredientPages/ingredientEdit.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing Ingredient...</title>
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

    <form class='goEditIngredient' action='' method='post' enctype='multipart/form-data'>
        <div class='container'>
            <h1>Editing Ingredient</h1>
            <?php

                echo "<h2>Your inputted params</h2>";
                echo "<p>Ingredient Name: $desiredIngredientName</p>";
                echo "<p>What you are altering: $desiredIngredientFeature</p>";

                $sql = "SELECT * FROM `Ingredients` WHERE Ingredient_Name LIKE '$desiredIngredientName';";
                $result = $mysqli->query($sql);

                $recordData = $result->fetch_assoc();

                echo "<h3>Current Version: $recordData[$desiredIngredientFeature]</h3>";

                switch($desiredIngredientFeature) {
                    case '0':
                        break;
                    case 'Ingredient_Name':
                        echo "
                            <label for='textIn'>State New</label>
                            <input type='text' name='textIn' required>
                            <input type='hidden' value='1' name='verify' id='verify'>
                            <br>
                        ";
                        break;
                    case 'Count_Num':
                        echo "
                            <label for='numIn'>State New</label>
                            <input type='number' name='numIn' min='0' required>
                            <input type='hidden' value='1' name='verify' id='verify'>
                            <br>
                        ";
                        break;
                    case 'WeightG':
                        echo "
                            <label for='numIn'>State New</label>
                            <input type='number' name='numIn' min='0' required>
                            <input type='hidden' value='1' name='verify' id='verify'>
                            <br>
                        ";
                        break;
                    case 'Expiration_Date':
                        $todayDate = date("Y-m-d");
                        echo "
                            <label for='dateIn'>State New</label>
                            <input type='date' name='dateIn' min='$todayDate' required>
                            <input type='hidden' value='1' name='verify' id='verify'>
                            <br>
                        ";
                        break;
                }

                echo "<input type='hidden' name='ingredientFeatureSelect' id='ingredientFeatureSelect' value='$desiredIngredientFeature'>";
                echo "<input type='hidden' name='ingredientNameSelect' id='ingredientNameSelect' value='$desiredIngredientName'>";
                
            ?>
            
            <input type='hidden' name='editing' id='editing' value='yes'>
            <hr>
            <button type='submit' name='editingIngredient'>Submit!</button>
            <hr>
        </div>
    </form>

    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>