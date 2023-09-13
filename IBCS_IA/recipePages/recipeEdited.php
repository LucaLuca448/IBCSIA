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

<?php

    $desiredRecipeAlter = $_POST['desiredRecipeAlter'];
    $desiredRecipeName = $_POST['desiredRecipeName'];

    switch ($desiredRecipeAlter) {
        case 'Dish_Name':
            $toSQL = $_POST['textInput'];
            $sql = "UPDATE `Recipes` SET Dish_Name = '$toSQL' WHERE Dish_Name LIKE '$desiredRecipeName';";
            $mysqli->query($sql);
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
                    
        case 'Recipe_Image':
            $imageCheck = getimagesize($_FILES['fileInput']['tmp_name']);
            if($imageCheck !== FALSE) {
                $imageName = $_FILES['fileInput']['name'];
                $imageSize = $_FILES['fileInput']['size'];
                $tempName = $_FILES['fileInput']['tmp_name'];
                $imageError = $_FILES['fileInput']['error'];

                if($imageError !== 0) {
                    switch ($imageError) {
                        case 1:
                            echo "<p style='color: red'>PHP UPLOAD_ERR_INI_SIZE: The uploaded file exceeds the <b>upload_max_filesize</b> directive in php.ini.</p>";
                            break;
                        case 2:
                            echo "<p style='color: red'>PHP UPLOAD_ERR_FORM_SIZE: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.</p>";
                            break;
                        case 3:
                            echo "<p style='color: red'>PHP UPLOAD_ERR_PARTIAL: The uploaded file was only partially uploaded.";
                            break;
                        case 4:
                            echo "<p style='color: red'>PHP UPLOAD_ERR_NO_FILE: No file was uploaded";
                            break;
                        case 6:
                            echo "<p style='color: red'>PHP UPLOAD_ERR_NO_TMP_DIR: Missing a temporary folder.";
                        break;
                        case 7:
                            echo "<p style='color: red'>PHP UPLOAD_ERR_CANT_WRITE: Failed to write file to disk.";
                            break;
                        case 8:
                            echo "<p style='color: red'>PHP UPLOAD_ERR_EXTENSION: A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.";
                            break;
                        default:
                            echo "An unknown error occured :(";
                            break;
                    }
                } else {
                    if($imageSize > 1000000) {
                        $errormsg = "Sorry your file is too large";
                        echo "<script>alert('$errormsg');</script>";
                        //header("Location http://localhost:8081/recipePages/recipeEdited.php?error=$errormsg");
                    } else {
                        $imgExtension = pathinfo($imageName, PATHINFO_EXTENSION);
                        $img_Ex_Lc = strtolower($imgExtension);

                        $allowedExtensions = array('jpg', 'jpeg', 'png');

                        if(in_array($img_Ex_Lc, $allowedExtensions)) {
                            $newImageName = uniqid('IMG-', TRUE).'.'.$img_Ex_Lc;
                            $imageUploadPath = "recipeImages/".$newImageName;

                            move_uploaded_file($tempName, $imageUploadPath);

                            $sql = "UPDATE `Recipes` SET Recipe_Image = '$newImageName' WHERE Dish_Name LIKE '$desiredRecipeName';";
                            $mysqli->query($sql);

                            echo "<p style='color: green'>File Uploaded! Redirecting you to recipe edit pages...</p>";
                            sleep(2);
                            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
                        } else {
                            echo "<p style='color: red'>File type not supported, please upload a different file</p>";
                            $errormsg = "File type not supported, try again";
                            echo "<script>alert('$errormsg');</script>";
                            //header("Location: http://localhost:8081/recipePages/recipeEdited.php?error=$errormsg");
                        }
                    }
                }
            } else {
                echo "<p style='color: red'>File is not a proper image, please upload a differet file</p>";
            }
            break;
                
        case 'Cooking_Time':
            $toSQL = $_POST['numericalInput'];
            $sql = "UPDATE `Recipes` SET Cooking_Time = '$toSQL' WHERE Dish_Name LIKE '$desiredRecipeName';";
            $mysqli->query($sql);
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
        case 'Ratings':
            $toSQL = $_POST['numericalInput'];
            $sql = "UPDATE `Recipes` SET Ratings = '$toSQL' WHERE Dish_Name LIKE '$desiredRecipeName';";
            $mysqli->query($sql);
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
        case 'Calories':
            $toSQL = $_POST['numericalInput'];
            $sql = "UPDATE `Recipes` SET Calories = '$toSQL' WHERE Dish_Name LIKE '$desiredRecipeName';";
            $mysqli->query($sql);
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
        case 'reqIngredients':
            //todo smart things
            $sql = "SELECT * FROM `Recipes` WHERE Dish_Name LIKE '$desiredRecipeName';";
            $result = $mysqli->query($sql);
            $recordData = $result->fetch_assoc();
            $tempRecipeID = $recordData['Recipe_ID'];
            $sql = "DELETE FROM `Junction_Rel` WHERE Recipe_Ref LIKE '$tempRecipeID';";
            $mysqli->query($sql);

            $toSQL = $_POST['reqIngredients'];
            if(empty($toSQL)) {
                header("Locarion: http://localhost:8081/recipePages/recipeEdit.php");
            } else {
                $count = count($toSQL);
                $recipeList = array();
                for($i = 0; $i < $count; $i++) {
                    array_push($recipeList, $toSQL[$i]);
                    print_r($recipeList);
                }
                $sql = "SELECT * FROM `Recipes` WHERE Dish_Name LIKE '$desiredRecipeName';";
                $result = $mysqli->query($sql);

                $recordData = $result->fetch_assoc();

                $recipeRefID = $recordData['Recipe_ID'];

                echo "<br>Insert into RecipeID: ".$recipeRefID.'<br>';

                for($i = 0; $i < $count; $i++) {
                    $temp = $recipeList[$i];
                    $sql = "SELECT * FROM `Ingredients` WHERE Ingredient_Name LIKE '$temp';";
                    $result = $mysqli->query($sql);

                    $recordData = $result->fetch_assoc();

                    echo "Inserting Ingredient: ".$temp."<br>";

                    $tempIngredientRefID = $recordData['Ingredient_ID'];

                    echo "ID = ".$tempIngredientRefID.'<br>';

                    $sql = "INSERT INTO `Junction_Rel`(Junction_ID, Recipe_Ref, Ingredient_Ref) VALUES(NULL, '$recipeRefID', '$tempIngredientRefID');";
                    $mysqli->query($sql);

                }

                header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            }
            break;
        case 'Recipe_Tags':
            $toSQL = $_POST['dropdownInput'];
            $sql = "UPDATE `Recipes` SET Recipe_Tags = '$toSQL' WHERE Dish_Name LIKE '$desiredRecipeName';";
            $mysqli->query($sql);
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
        case 'Recipe_Description':
            $toSQL = $_POST['textInput'];
            $sql = "UPDATE `Recipes` SET Recipe_Description = '$toSQL' WHERE Dish_Name LIKE '$desiredRecipeName';";
            $mysqli->query($sql);
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
        case 'Methodology':
            $toSQL = $_POST['textInput'];
            $sql = "UPDATE `Recipes` SET Methodology = '$toSQL' WHERE Dish_Name LIKE '$desiredRecipeName';";
            $mysqli->query($sql);
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
        default:
            header("Location: http://localhost:8081/recipePages/recipeEdit.php");
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Edited</title>
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

    <h1>Setting Recipe Details</h1>
    <br>

    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>