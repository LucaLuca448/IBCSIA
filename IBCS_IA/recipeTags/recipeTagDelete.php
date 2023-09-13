<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['tagNames'])) {
        $tagName = $_POST['tagNames'];
        $sql = "DELETE FROM `Recipe_Tags` WHERE Tag_Name LIKE '$tagName';";
        $mysqli->query($sql);
        echo "<script>alert('Recipe Tag Deleted Sucessfully');</script>";
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Recipe Tag</title>
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

    <form class='deleteTagForm' action='' method='post'>
        <div class='container'>
            <h1>Delete a Recipe Tag</h1>
            <hr>
            <label for='tagNames'>Select Tag to Delete</label>
            <select id='tagNames' name='tagNames' required>
                <option value='0'>Select Option</option>
                <?php
                    $sql = "SELECT * FROM `Recipe_Tags`;";
                    $result = $mysqli->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $temp = $row['Tag_Name'];
                        echo "<option value='$temp'>$temp</option>";
                    }
                ?>
            </select>
            <br>
            <button type='submit' name='deletTagSubmit'>Delete!</button>
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