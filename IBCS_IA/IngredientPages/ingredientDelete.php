<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['ingredients'])) {
        $temp = $_POST['ingredients'];
        $sql = "DELETE FROM `Ingredients` WHERE Ingredient_Name LIKE '$temp';";
        $mysqli->query($sql);
        header("Location: http://localhost:8081/IngredientPages/ingredientDelete.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete an Ingredient</title>
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

    <form class='ingredientDeleteForm' action='' method='post'>
        <div class='container'>
            <h1>Delete an Ingredient</h1>
            <label for='ingredients'>Select ingredient to delete</label>
            <select name='ingredients' id='ingredients'>
                <?php
                    $sql = "SELECT * FROM `Ingredients`;";
                    $result = $mysqli->query($sql);

                    echo "<option value='0'>Select Option</option>";

                    while($row = $result->fetch_assoc()) {
                        $temp = $row['Ingredient_Name'];
                        echo "<option value='$temp'>$temp</option>";
                    }
                ?>
            </select>
            <br>

            <button type='submit'>Delete!</button>
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