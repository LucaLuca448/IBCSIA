<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['submittedornot'])) {
        
        $dishName = filter_input(INPUT_POST, 'dishName');
        $cookingTime = filter_input(INPUT_POST, 'cookTime');
        $lastMade = filter_input(INPUT_POST, 'lastCooked');
        $calories = filter_input(INPUT_POST, 'calorieCount');
        $recipeTag = filter_input(INPUT_POST, 'recipeTag');
        $reqIngredients = array();
        foreach($_POST['reqIngredients'] as $selectedIngredient) {
            array_push($reqIngredients, $selectedIngredient);
        }
        $description = filter_input(INPUT_POST, 'recipeDesc');
        $methodology = filter_input(INPUT_POST, 'recipeMethod');
    
        if(empty($lastMade)) {
            $lastMade = date("Y-m-d");
        }
        if(empty($calories)) {
            $calories = '0';
        }
        if(empty($recipeTag)) {
            $recipeTag = 'NONE';
        }
        if(empty($reqIngredients) || $_POST['reqIngredients'] == '0') {
            $reqIngredients = "NONE";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Recipe</title>
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
    <form class='recipeCreateForm' action='' method='post' enctype='multipart/form-data'>
        <div class='container'>
            <h1>Creating New Recipe</h1>
            <hr>
            <div>
                <input type='hidden' id='submittedornot' name='submittedornot' value='YES'>
            </div>
            <div>
                <label for='dishName'>Specify Dish Name</label><br>
                <textarea id='dishName' name='dishName' rows='3' cols='50' required></textarea>
                <br>
                <label for='cookTime'>Specify Cooking Time (Write 0 if unknown)</label>
                <input type='number' id='cookTime' name='cookTime' min='0' required>
                <br>
                <label for='lastCooked'>Specify When this dish was last made (for stats purposes)</label>
                <?php
                    $todayDate = date("Y-m-d");
                    echo "<input type='date' id='lastCooked' min='$todayDate' name='lastCooked'>";
                ?>
                <br>
                <label for='calorieCount'>Specify Calorie Count of this dish</label>
                <input type='number' id='calorieCount' name='calorieCount' min='0'>
                <br>
                <label for='recipeTag'>Specify Recipe Tag</label>
                <select id='recipeTag' name='recipeTag'>
                    <?php
                        $sql = "SELECT * FROM `Recipe_Tags`;";
                        $result = $mysqli->query($sql);

                        echo "<option value='0'>Select Option</option>";

                        while($row = $result->fetch_assoc()) {
                            $temp = $row["Tag_Name"];
                            echo "<option value=$temp>$temp</option>";
                        };
                    ?>
                </select>
                <br>
                <label for='reqIngredients'>Specify Needed Recipe Ingredients</label><br>
                <?php
                    $sql = "SELECT * FROM `Ingredients`;";
                    $result = $mysqli->query($sql);

                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $temp = $row["Ingredient_Name"];
                            echo "<input type='checkbox' name='reqIngredients[]' value=$temp>";
                            echo "<label for='reqIngredients[]'>$temp</label>";
                            echo "<br>";
                        }
                    } else {
                        echo "<input type='checkbox' id='0' name='0' value='0' disabled>";
                        echo "<input type='hidden' name='theIngredient' value='0'>";                      
                        echo "<label for='0'>No Ingredients stored in our database, contribute some!</label>";
                        echo "<br>";
                    }
                ?>
                <br>
                <label for='recipeDesc'>Give a description for this dish</label><br>
                <textarea id='recipeDesc' name='recipeDesc' rows='6' cols='50' required></textarea>
                <br>
                <label for='recipeMethod'>Specify Method of Preparation</label><br>
                <textarea id='recipeMethod' name='recipeMethod' rows='6' cols='50' required></textarea>
                <br>
                <label for='recipeImage'>Upload an image for this dish</label>
                <input type='file' accept='image/*' id='recipeImage' name='recipeImage' default='0'>
                <p style='color: yellow'>Note that if no image is uploaded, a default image will be provided</p>
                <br>
            </div> 
            <hr>
            <div>
                <button type='submit' name='newRecipeButton'>Create!</button>
            </div>
        </div>
    </form>
    <?php
        if(!empty($_POST["submittedornot"]) && !empty($_FILES["recipeImage"]['tmp_name'])) {
            $imageCheck = getimagesize($_FILES["recipeImage"]["tmp_name"]);
            if($check !== FALSE) {
                echo "<pre>";
                print_r($_FILES['recipeImage']);
                echo "</pre>";

                $imageName = $_FILES['recipeImage']['name'];
                $imageSize = $_FILES['recipeImage']['size'];
                $tempName = $_FILES['recipeImage']['tmp_name'];
                $imageError = $_FILES['recipeImage']['error'];

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
                    }
                } else {
                    if($imageSize > 1000000) {
                        $errormsg = "Sorry your file is too large";
                        echo "<script>alert('$errormsg');</script>";
                        //header("Location: http://localhost:8081/recipePages/recipeCreate.php?error=$errormsg");
                    } else {
                        $imgExtension = pathinfo($imageName, PATHINFO_EXTENSION);
                        $img_Ex_Lc = strtolower($imgExtension);

                        $allowedExtensions = array("jpg", "jpeg", "png");

                        if(in_array($img_Ex_Lc, $allowedExtensions)) {
                            $newImageName = uniqid("IMG-", TRUE).".".$img_Ex_Lc;
                            $imageUploadPath = "recipeImages/".$newImageName;

                            move_uploaded_file($tempName, $imageUploadPath);

                            $sql = "INSERT INTO `Recipes`(Recipe_ID, Dish_Name, Sufficient_Ingredients, Cooking_Time, Ratings, Last_Cooked, Calories, Recipe_Tags, Recipe_Description, Recipe_Image, Methodology) VALUES (NULL, '$dishName', '0', '$cookingTime', '0', '$lastMade', '$calories', '$recipeTag', '$description', '$newImageName', '$methodology');";
                            $mysqli->query($sql);
                            
                            //Junction Record Manipulation
                            $sql = "SELECT * FROM `Recipes`;";
                            $result = $mysqli->query($sql);
                    
                            $formResults = $_POST['reqIngredients'];
                            
                            if(empty($formResults)) {
                                echo "<p style='color: green'>Recipe Created! Redirecting you to the home page...</p>";
                                sleep(2);
                                header("Location: http://localhost:8081/");
                            } else {
                                $count = count($formResults);
                                $recipeList = array();
                                for($i = 0; $i < $count; $i++) {
                                    array_push($recipeList, $formResults[$i]);
                                    print_r($recipeList);
                                }
                                $sql = "SELECT * FROM `Recipes` WHERE Dish_Name='$dishName';";
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
                
                                    $sql = "INSERT INTO `Junction_Rel`(Junction_ID, Recipe_Ref, Ingredient_Ref) VALUES (NULL, '$recipeRefID', '$tempIngredientRefID');";
                                    $mysqli->query($sql);
                
                                }
                
                                header("Location: http://localhost:8081/recipePages");
                                
                            }
                            //Junction Record Manipulation

                        } else {
                            $errormsg = "File type not supported, try again";
                            echo "<script>alert('$errormsg');</script>";
                            //header("Location: http://localhost:8081/recipePages/recipeCreate.php?error=$errormsg");
                        }
                    }
                }
            } else {
                echo "<p style='color: red'>File is not a proper image, please upload a different file</p>";
            }
        } elseif (!empty($_POST['submittedornot']) && empty($_FILES['recipeImage']['tmp_name'])) {
            $sql = "INSERT INTO `Recipes`(Recipe_ID, Dish_Name, Sufficient_Ingredients, Cooking_Time, Ratings, Last_Cooked, Calories, Recipe_Tags, Recipe_Description, Recipe_Image, Methodology) VALUES (NULL, '$dishName', '0', '$cookingTime', '0', '$lastMade', '$calories', '$recipeTag', '$description', 'UnknownFood.png', '$methodology');";
            $mysqli->query($sql);

            //Junction Record Manipulation
            $sql = "SELECT * FROM `Recipes`;";
            $result = $mysqli->query($sql);
    
            $formResults = $_POST['reqIngredients'];
            
            if(empty($formResults)) {
                echo "<p style='color: green'>Recipe Created! Redirecting you to the home page...</p>";
                sleep(2);
                header("Location: http://localhost:8081/");
            } else {
                $count = count($formResults);
                $recipeList = array();
                for($i = 0; $i < $count; $i++) {
                    array_push($recipeList, $formResults[$i]);
                    print_r($recipeList);
                }
                $sql = "SELECT * FROM `Recipes` WHERE Dish_Name='$dishName';";
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

                    $sql = "INSERT INTO `Junction_Rel`(Junction_ID, Recipe_Ref, Ingredient_Ref) VALUES (NULL, '$recipeRefID', '$tempIngredientRefID');";
                    $mysqli->query($sql);

                }

                header("Location: http://localhost:8081/recipePages");
                
            }
            //Junction Record Manipulation

        } else {
            echo 'No recipe Made';
        }
    ?>
    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>