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
    <title>Edit Ingredient</title>
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

    <form class='ingredientEditForm' action='ingredientEditing.php' method='post'>
        <div class='container'>
            <h1>Edit an Ingredient</h1>
            <label for='ingredientNameSelect'>Choose the Ingredient to be edited</label>
            <select id='ingredientNameSelect' name='ingredientNameSelect'>
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

            <label for='ingredientFeatureSelect'>Choose the ingredient feature to be edited</label>
            <select id='ingredientFeatureSelect' name='ingredientFeatureSelect'>
                <option value='0'>Select Option</option>
                <option value='Ingredient_Name'>Ingredient Name</option>
                <option value='Count_Num'>Ingredient Count</option>
                <option value='WeightG'>Ingredient Weight</option>
                <option value='Expiration_Date'>Expiration Date</option>
            </select>
            <hr>
            <button type='submit' name='ingredientEdit'>Submit</button>
            <br>
        </div>
    </form>

    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>
