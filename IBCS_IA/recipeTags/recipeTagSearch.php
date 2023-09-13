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
    <title>Search Recipe Tag</title>
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

    <form class='tagSearchForm' action='recipeTagSearchResults.php' method='post'>
        <div class='container'>
            <h1>Search for Recipe Tag</h1>
            <hr>
            <label for='tagSearch'>Search Tag Name</label>
            <input type='search' name='tagSearch' id='tagSearch' placeholder='Search Tag' required>
            <br>
            <button type='submit' name='tagSearchbtn'>Search!</button>
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