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
    <style>
        h1 {
            text-align: center;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linking Recipes to Ingredients</title>
    <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
</head>
<body>
    <h1>Please Wait while the program links your recipe to its corresponding ingredients</h1>
    <?php
        $sql = "SELECT * FROM `Recipes`;";
        $result = $mysqli->query($sql);

        $formResults = $_POST['reqIngredients'];
        
        if(empty($formResults)) {
            echo '<p>No ingredients selected, redirecting to Home Page...</p>';
            sleep(2);
            //header("Location: http://localhost:8081");
        } else {
            $count = count($formResults);
            for($i = 0; $i < $count; $i++) {
                echo $formResults[$i]."<br>";
            }
        }


        $mysqli->close();
    ?>
</body>
</html>