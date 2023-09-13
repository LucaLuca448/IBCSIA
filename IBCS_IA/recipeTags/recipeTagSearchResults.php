<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['tagSearch'])) {
        if($_POST['tagSearch'] == "NONE") {
            $searched = "%%";
        } else {
            $searched = $_POST['tagSearch']; 
        }
        $sql = "SELECT * FROM `Recipe_Tags` WHERE Tag_Name LIKE '$searched';";
        $result = $mysqli->query($sql);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Tag Search Results</title>
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
        <h1>Recipe Tag Search Results</h1>
        <hr>
        <?php
            if($result->num_rows == 0) {
                echo "<p>Sorry but your search returned no results</p><br>";
            } else {
                echo "<p>Here are the results of your search</p>";

                while($row = $result->fetch_assoc()) {
                    echo "Recipe Tag No. ".$row['Tag_ID'].": ".$row['Tag_Name'];
                    echo "<br>";
                    echo "<hr>";
                }
            }
        ?>
        <hr>
    </div>

    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>