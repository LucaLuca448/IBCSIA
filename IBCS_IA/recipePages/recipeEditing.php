<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing Recipe...</title>
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
    <form class='goEditRecipe' action='recipeEdited.php' method='post' enctype='multipart/form-data'>
        <div class='container'>
            <?php
                echo "<h1>Editing Recipe:</h1>";

                $desiredRecipeName = $_POST['recipeNameS'];
                $desiredRecipeAlter = $_POST['recipeFeatureS'];

                echo "<h2>Your inputted Params</h2>";
                echo "<p>Recipe Name: ".$desiredRecipeName."</p><br>";
                echo "<p>What you are altering: ".$desiredRecipeAlter."</p><br>";

                if($desiredRecipeAlter != "reqIngredients" && $desiredRecipeAlter != "Recipe_Image") {
                    $sql = "SELECT * FROM `Recipes` WHERE Dish_Name LIKE '$desiredRecipeName';";
                    $result = $mysqli->query($sql);
    
                    $recordData = $result->fetch_assoc();

                    echo "<h3>Current Version: </h3>".$recordData["$desiredRecipeAlter"].'<br>';

                    if($desiredRecipeAlter == "Cooking_Time" || $desiredRecipeAlter == "Ratings" || $desiredRecipeAlter == "Calories") {
                        echo "<label for='numericalInput'>Input Number</label><br>";
                        echo "<input type='number' name='numericalInput' min='0' required><br>";
                    } elseif($desiredRecipeAlter == "Recipe_Tags") {
                        $sql = "SELECT * FROM `Recipe_Tags`;";
                        $result = $mysqli->query($sql);

                        echo "
                            <label for='dropdownInput'>Select New</label>
                            <select id='dropdownInput' name='dropdownInput'>
                                <option value='0'>Select New Tag</option>
                        ";
                        while($row = $result->fetch_assoc()) {
                            $temp = $row["Tag_Name"];
                            echo "<option value=$temp>$temp</option>";
                        }
                        echo "
                            </select><br>
                        ";
                    } else {
                        echo "
                            <label for='textInput'>State New</label>
                            <input type='text' name='textInput'><br>
                        ";
                    }
                } elseif ($desiredRecipeAlter == "Recipe_Image") {
                    echo "
                        <label for='fileInput'>Upload New</label>
                        <input type='file' accept='image/*' name='fileInput' required>
                    ";
                } elseif ($desiredRecipeAlter == NULL) {
                    header('Location: http://localhost:8081/recipePages/recipeEdit.php');
                } else { //$deriredRecipeAlter == Recipe_Ingredients
                    $sql = "SELECT * FROM `Recipes` WHERE Dish_Name LIKE '$desiredRecipeName';";
                    $result = $mysqli->query($sql);

                    $recordData = $result->fetch_assoc();
                    $tempRecipeID = $recordData['Recipe_ID'];

                    $sql = "SELECT Ingredient_Name FROM `Junction_Rel` INNER JOIN `Ingredients` ON Junction_Rel.Recipe_Ref = '$tempRecipeID' AND Junction_Rel.Ingredient_Ref = Ingredients.Ingredient_ID;";
                    $result = $mysqli->query($sql);
                    echo "<p>Current Version</p>";
                    while($row = $result->fetch_assoc()) {
                        echo $row['Ingredient_Name'];
                        echo "<br>";
                    }

                    echo "<br>";

                    echo "<h3>Select new Ingredients</h3><br>";
                    
                    $sql = "SELECT * FROM `Ingredients`;";
                    $result = $mysqli->query($sql);

                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $temp = $row['Ingredient_Name'];
                            echo "<input type='checkbox' name='reqIngredients[]' value='$temp'>";
                            echo "<label for='reqIngredients[]'>$temp</label>";
                            echo "<br>";
                        } 
                
                    } else {
                        echo "<input type='checkbox' id='0' name='0' value='0' disabled>";
                        echo "<input type='hidden' name='theIngredient' value='0'>";                      
                        echo "<label for='0'>No Ingredients stored in our database, contribute some!</label>";
                        echo "<br>";
                    }
                }

            ?>
            <br>
            <hr>
            <?php
                echo "<input type='hidden' name='desiredRecipeAlter' value='$desiredRecipeAlter'>";
                echo "<input type='hidden' name='desiredRecipeName' value='$desiredRecipeName'>";
            ?>
            <button type='submit' name='recipeEditNow'>Submit</button>
        </div>
    </form>
    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>
