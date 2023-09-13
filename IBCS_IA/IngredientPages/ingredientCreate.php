<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['ingredientName'])) {
        $ingredientName = filter_input(INPUT_POST, 'ingredientName');
        $ingredientCount = filter_input(INPUT_POST, 'ingredientCount');
        $ingredientWeight = filter_input(INPUT_POST, 'ingredientWeight');
        $expiryDate = filter_input(INPUT_POST, 'expiryDate');
        if(empty($expiryDate)) {
            $expiryDate = date("Y-m-d");
        }

        $sql = "INSERT INTO `Ingredients`(Ingredient_ID, Ingredient_Name, Count_Num, WeightG, Expiration_Date) 
                VALUES (NULL, '$ingredientName', '$ingredientCount', '$ingredientWeight', '$expiryDate');";

        $mysqli->query($sql);
        echo "<p style='color:green'>Recipe Created! Redirecting to Ingredient Menu Page</p>";
        sleep(2);
        header("Location: http://localhost:8081/IngredientPages");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ingredient</title>
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

    <form class='ingredientCreateForm' action='' method='post' enctype="multipart/form-data">
        <div class='container'>
            <h1>Ingredient Creation</h1>
            <hr>
            
            <label for='ingredientName'>Specify Ingredient Name</label>
            <textarea id='ingredientName' name='ingredientName' rows='3' cols='50' required></textarea>
            <br>
            <label for='ingredientCount'>Specify Ingredient Count (Write 0 if unknown)</label>
            <input type='number' id='ingredientCount' name='ingredientCount' min='0' required>
            <br>
            <label for='ingredientWeight'>Specify Ingredient Weight (Write 0 if unknown)</label>
            <input type='number' id='ingredientWeight' name='ingredientWeight' min='0' required>
            <br>
            <label for='expiryDate'>Specify Ingredient Expiry Date</label>
            <?php
                $dateToday = date("Y-m-d");
                echo "<input type='date' id='expiryDate' name='expiryDate' min='$dateToday'>";
            ?>


            <hr>
            <button type='submit' name='createNewIngredient'>Create</button>
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