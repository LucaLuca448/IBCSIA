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
    <title>Ingredient Menu</title>
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
        <h1>Ingredients Menu</h1>

        <hr>

        <a href='ingredientSearch.php'>Search for Ingredients</a>
        <br>
        <a href='ingredientCreate.php'>Create Ingredient</a>
        <br>
        <a href='ingredientEdit.php'>Edit Ingredient</a>
        <br>
        <a href='ingredientDelete.php'>Delete Ingredient</a>
        <br>

        <hr>
    </div>
    <?php
        $path = "/include/footer.php";
        include($root.$path);
        
        $mysqli->close();
    ?>
</body>
</html>