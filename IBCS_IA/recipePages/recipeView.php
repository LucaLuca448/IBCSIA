<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .recipeImg {
            width: 200px;
            border-radius: 10px;
            margin-right: 10px;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe View</title>
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
        <?php
            $RecipeID = $_POST['recipeViewBtn'];
            $RecipeName = $_POST['recipeViewingName'];
            echo "Selected Recipe Number: ".$RecipeID."<br>"."Recipe Name: ".$RecipeName;
            echo "<br><hr>";

            $sql = "SELECT * FROM `Recipes` WHERE Recipe_ID LIKE $RecipeID";
            $recipeResult = $mysqli->query($sql);

            $recordData = $recipeResult->fetch_assoc();

            $recipeName = $recordData['Dish_Name'];
            $recipePic = $recordData['Recipe_Image'];
            $recipeCookTime = $recordData['Cooking_Time'];
            $recipeRating = $recordData['Ratings'];
            $recipeLastCooked = $recordData['Last_Cooked'];
            $recipeCalories = $recordData['Calories'];
            $recipeTags = $recordData['Recipe_Tags'];
            $recipeDesc = $recordData['Recipe_Description'];
            $recipeMethod = $recordData['Methodology'];

            echo "<h1><b>$recipeName<b></h1><br>";

            echo "<img class='recipeImg' src=recipeImages/$recipePic><br>";
            echo "<hr>";
            echo "<h3>Rating: $recipeRating/5</h3><br>";

            echo "<p>Required Ingredients</p>";
            $sql = "SELECT Ingredient_Name FROM `Junction_Rel` INNER JOIN `Ingredients` ON Junction_Rel.Recipe_Ref = '$RecipeID' AND Junction_Rel.Ingredient_Ref = Ingredients.Ingredient_ID;";
            $result = $mysqli->query($sql);
            while($row = $result->fetch_assoc()) {
                echo $row['Ingredient_Name'];
                echo "<br>";
            }

            echo "<hr>";
            
            echo "<p>$recipeDesc</p><br>";

            echo "<hr>";

            echo "<br><p>$recipeMethod</p><br>";
        ?>
    </div>
    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>