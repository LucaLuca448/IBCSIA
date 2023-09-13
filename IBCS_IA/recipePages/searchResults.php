<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['submittedOrNot'])) {
        $searchedName = filter_input(INPUT_POST, 'recipeSearchBar');
        $searchedTime = filter_input(INPUT_POST, 'recipeSearchCookingTime');
        $searchedRating = filter_input(INPUT_POST, 'ratings');
        $searchedCookDate = filter_input(INPUT_POST, 'lastcooked');
        $searchedCalories = filter_input(INPUT_POST, 'recipeSearchCalorieCount');
        $searchedTags = filter_input(INPUT_POST, 'recipeTagSelection');


        if($searchedName == "NONE") {
            $tempsearchedName = "NONE";
            $searchedName = "%%";
        } else {
            $tempsearchedName = $searchedName;
        }
        if(empty($searchedTime)) {
            $tempsearchedTime = "NONE";
            $searchedTime = "%%";
        } else {
            $tempsearchedTime = $searchedTime;
        }
        if(empty($searchedRating)) {
            $tempsearchedRating = "NONE";
            $searchedRating = "%%";
        } else {
            $searchedRating = (int)$searchedRating;
            $tempsearchedRating = $searchedRating;
        }
        if(empty($searchedCookDate)) {
            $tempsearchedCookDate = "NONE";
            $searchedCookDate = "%%";
        } else {
            $tempsearchedCookDate = $searchedCookDate;
        }
        if(empty($searchedCalories)) {
            $tempsearchedCalories = "NONE";
            $searchedCalories = "%%";
        } else {
            $searchedCalories = (int)$searchedCalories;
            $tempsearchedCalories = $searchedCalories;
        }
        if(empty($searchedTags)) {
            $tempsearchedTags = "NONE";
            $searchedTags = "%%";
        } else {
            $tempsearchedTags = $searchedTags;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .DishImage {
            width: 200px;
            border-radius: 10px;
            margin-right: 10px;
        }
        #recipeImage:hover {
            opacity: 0.7;
        }

        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.9);
        }

        .modalContent {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }
        .modalContent, #caption {  
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)} 
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)} 
            to {transform:scale(1)}
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
        <?php
            echo "<h1>Your Recipe Search Results</h1>";

            echo "<hr>";

            echo "<h2>Your Search Params</h2>";

            echo "Searched Name: ".$tempsearchedName;
            echo "<br>";
            echo "Searched Cooking Time: ".$tempsearchedTime;
            echo "<br>";
            echo "Searched Rating: ".$tempsearchedRating;
            echo "<br>";
            echo "Searched Last Cook Date: ".$tempsearchedCookDate;
            echo "<br>";
            echo "Searched Caloric Value: ".$tempsearchedCalories;
            echo "<br>";
            echo "Searched Recipe Tags: ".$tempsearchedTags;
            echo "<br>";

            //displaying Search Results:
            $sql = "SELECT * FROM `Recipes` WHERE Dish_Name LIKE '$searchedName' AND Cooking_Time LIKE '$searchedTime' AND Ratings LIKE '$searchedRating' AND Last_Cooked LIKE '$searchedCookDate' AND Calories LIKE '$searchedCalories' AND Recipe_Tags LIKE '$searchedTags';";
            $result = $mysqli->query($sql);

            if($result->num_rows == 0) {
                echo "<p>Sorry your search query returned no results</p><br>";
            } else {
                //else display the returned results
                echo "<hr>";
                echo "<p>Here are the results of your search</p><br>";

                while($row = $result->fetch_assoc()) {
                    echo "Recipe No. ".$row['Recipe_ID'].": ".$row['Dish_Name'];
                    $theRecipeID = $row['Recipe_ID'];
                    $theRecipeName = $row['Dish_Name'];
                    echo "<form class='recipeViewForm' action='recipeView.php' method='post'>
                            <input type='hidden' name='recipeViewingName' value='$theRecipeName'>
                            <button type='submit' name='recipeViewBtn' value='$theRecipeID'>View Recipe</button>
                        </form>
                    ";
                    $RecipeImagePath = $row['Recipe_Image'];
                    echo "<br>";
                    echo "<img class='DishImage' id='recipeImage' src='recipeImages/$RecipeImagePath' alt='Your Recipe Image Here'><br>";
                    echo "<hr>"; 
                }
            }
        ?>

        <!-- Image Modal Thing -->
        <div id='recipeImageModal' class='modal'>
            <span class='close'>&times;</span>
            <img class='modalContent' id='img1'>
            <div id='caption'></div>
        </div>

    </div>

    <hr>
    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>

    <script>
        var myModal = document.getElementById('recipeImageModal');

        var myImgs = document.querySelectorAll('.DishImage');
        var modalImage = document.getElementById('img1');
        var captionText = document.getElementById('caption');

        function showImageModal() {
            myModal.style.display = 'block';
            modalImage.src = this.src;
            captionText.innerHTML = this.alt;
        }

        for (let i = 0; i < myImgs.length; i++) {
            myImgs[i].addEventListener("click", showImageModal);
        }

        var span = document.getElementsByClassName('close')[0];

        span.onclick = function() {
            myModal.style.display = 'none';
        }
    </script>
    
</body>
</html>