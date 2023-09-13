<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    $selectedTag = $_POST['tagNameS'];

    if(!empty($_POST['newTagname'])) {
        $sql = "SELECT * FROM `Recipe_Tags`;";
        $result = $mysqli->query($sql);
        $existing = array();
        while($row = $result->fetch_assoc()) {
            array_push($existing, $row['Tag_Name']);
        }
        if(in_array($_POST['newTagname'], $existing)) {
            echo "<script>alert('Recipe Tag Already Exists');</script>";
        } else {
            $toSQL = $_POST['newTagname'];
            $selectedTag = $_POST['selectTag'];
            $sql = "UPDATE Recipe_Tags SET Tag_Name = '$toSQL' WHERE Tag_Name LIKE '$selectedTag';";
            $mysqli->query($sql);
            echo "<script>alert('Recipe Tag Edited Sucessfully');</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing Tag</title>
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

    <form class='tagEditing' action='' method='post'>
        <div class='container'>
            <h1>Edit a Tag</h1>
            <hr>
            <?php
                echo "<p>You selected: ".$selectedTag."<p>";
                echo "<input type='hidden' id='selectTag' name='selectTag' value='$selectedTag'>";
            ?>
            <label for='newTagname'>Enter new Tag Name</label>
            <input type='text' id='newTagname' name='newTagname' required>
            <br>
            <button type='submit' name='newTagSubmit'>Create</button>
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