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
    <title>Ingredient Search</title>
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

    <form class='ingredientSearchForm' action='ingredientSearchResults.php' method='post'>
        <div class='container'>
            <h1>Ingredient Searching</h1>
            <hr>
            <input type='hidden' id='submitted' name='submitted' value='YES'>

            <label for='ingredientSearchBar'><b>Enter Search Parameters</b></label>
            <input type='search' id='ingredientSearchBar' name='ingredientSearchBar' placeholder='Search Name' required>
            <p style='color:lawngreen'><i>Write NONE to display all ingredients stored</i></p>
            <hr>

            <label for='expiryDateSearch'><b>Search by Expiry Date</b></label>
            <input type='date' id='expiryDateSearch' name='expiryDateSearch'>
            <p><i>Leave Blank if blank</i></p>

            <hr>

            <button type='submit' name='ingredientSearchbtn'>Search!</button>
        </div>
    </form>

    <?php

        $path = "/include/footer.php";
        include($root.$path);
        
        $mysqli->close();
    ?>
</body>
</html>