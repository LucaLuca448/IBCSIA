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
    <title>Recipe Menu</title>
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

        <h1>Recipes Menu</h1>

        <hr>

        <a href='recipeSearch.php'>Search for Recipes</a>
        <br>
        <a href='recipeCreate.php'>Create and Store New Recipe</a>
        <br>
        <a href='recipeEdit.php'>Edit an Existing Recipe (one at a time)</a>
        <br>
        <a href='recipeDelete.php'>Delete an Existing Recipe</a>

        <hr>

    </div>
    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>