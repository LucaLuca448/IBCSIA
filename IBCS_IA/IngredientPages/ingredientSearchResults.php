<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['submitted'])) {
        $searchedName = $_POST['ingredientSearchBar'];
        $searchedDate = $_POST['expirySearchDate'];

        if($searchedName = "NONE") {
            $tempSearchedName = "%%";
        }
        if(empty($searchedDate)) {
            $tempSearchedDate = "%%";
            $searchedDate = "NONE";
        } else {
            $tempSearchedDate = $searchedDate;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<style>
   table, th, td {
    border: 1px solid black;
   }
</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredient Search Results</title>
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

    <h1>Ingredient Search Results</h1>
    <hr>
    <p>Your Search Params</p>
    <?php
        echo "Searched Name: ".$searchedName."<br>";
        echo "Searched Date: ".$searchedDate."<br>";

        $sql = "SELECT * FROM `Ingredients` WHERE Ingredient_Name LIKE '$tempSearchedName' AND Expiration_Date LIKE '$tempSearchedDate';";
        $result = $mysqli->query($sql);

        if($result->num_rows == 0) {
            echo "<p>Sorry your query returned no results</p>";
        } else {
            echo "<hr>";
            echo "<p>Here are the results of your search</p>";

            echo "<table style='width: 100%'>
                <tr>
                    <th>Ingredient_ID</th>
                    <th>Ingredient_Name</th>
                    <th>Ingredient_Count</th>
                    <th>Ingredient_Weight</th>
                    <th>Expiration_Date</th>
                </tr>
            ";

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>$row[Ingredient_ID]</td>
                    <td>$row[Ingredient_Name]</td>
                    <td>$row[Count_Num]</td>
                    <td>$row[WeightG]</td>
                    <td>$row[Expiration_Date]</td>
                </tr>";
            }

            echo "</table>";
        }
    ?>
    <hr>



    <?php

        $path = "/include/footer.php";
        include($root.$path);
        
        $mysqli->close();
    ?>
</body>
</html>