<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['newTagName'])) {
        $sql = "SELECT * FROM `Recipe_Tags`;";
        $result = $mysqli->query($sql);
        $existing = array();
        while($row = $result->fetch_assoc()) {
            array_push($existing, $row['Tag_Name']);
        }

        if(in_array($_POST['newTagName'], $existing)) {            
            echo "<script>alert('Recipe Tag Already Exists');</script>";
        } else {
            $toSQL = $_POST['newTagName'];
            $sql = "INSERT INTO `Recipe_Tags` VALUES(NULL, '$toSQL');";
            $mysqli->query($sql);
            echo "<script>alert('Recipe Tag Created Sucessfully');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Recipe Tag</title>
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

    <form class='createTagForm' action='' method='post'>
        <div class='container'>
            <h1>Creating New Recipe Tag</h1>
            <hr>
            <br>
            <label for='newTagName'>Enter new Tag Name: </label>
            <input type='text' id='newTagName' name='newTagName' required>
            <br>

            <button type='submit' name='createTagSubmit'>Create!</button>
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