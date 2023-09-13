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
    <title>Edit an Existing Recipe</title>
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
    <form class='recipeEditForm' action='recipeEditing.php' method='post'>
        <div class='container'>
            <h1>Edit a Recipe</h1>
            <label for='recipeNameS'>Choose the dish you would like to edit</label>
            <select id='recipeNameS' name='recipeNameS'>
                <?php
                    $sql = "SELECT * FROM `Recipes`;";
                    $result = $mysqli->query($sql);

                    echo "<option value='0'>Select Option</option>";

                    while($row = $result->fetch_assoc()) {
                        $temp = $row['Dish_Name'];
                        echo "<option value='$temp'>$temp</option>";
                    }
                
                ?>
            </select>
        </div>
        <div class='container'>
            <label for='recipeFeatureS'>Choose the feature that you would like to edit</label>
            <select id='recipeFeatureS' name='recipeFeatureS'>
                <option value='0'>Select Option</option>
                <option value='Dish_Name'>Recipe Name</option>
                <option value='Recipe_Image'>Recipe Image</option>
                <option value='Cooking_Time'>Recipe Cooking Time</option>
                <option value='Ratings'>Recipe Ratings</option>
                <option value='Calories'>Recipe Calories</option>
                <option value='reqIngredients'>Recipe Ingredients</option>
                <option value='Recipe_Tags'>Recipe Tags</option>
                <option value='Recipe_Description'>Recipe Description</option>
                <option value='Methodology'>Recipe Method</option>
            </select>
        </div>
        <hr>
        <div>
            <button type='submit' name='recipeEdit'>Submit</button>
            <br>
        </div>
    </form>
    <hr>
    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>