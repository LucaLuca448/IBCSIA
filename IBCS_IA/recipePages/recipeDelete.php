<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['recipes'])) {
        $temp = $_POST['recipes'];
        $sql = "DELETE FROM `Recipes` WHERE Dish_Name LIKE '$temp';";
        $mysqli->query($sql);
        header("Location: http://localhost:8081/recipePages");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete a Recipe</title>
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

    <form class='recipeDeleteForm' action='' method='post'>
        <div class='container'>
            <h1>Delete a Recipe</h1>
            <br>
            <label for='recipes'>Select a Recipe to Delete</label>
            <select id='recipes' name='recipes'>
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
            <br>

            <button type='submit' name='recipeDelete'>Delete!</button>

            <br>
            <hr>
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