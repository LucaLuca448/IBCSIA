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
        $searchedName = filter_input(INPUT_POST, 'searchByName');
        $searchedTime = filter_input(INPUT_POST, 'recipeSearchCookingTime');
        $searchedRating = filter_input(INPUT_POST, 'ratings');
        $searchedCookDate = filter_input(INPUT_POST, 'lastcooked');
        $searchedCalories = filter_input(INPUT_POST, 'recipeSearchCalorieCount');
        $searchedTags = filter_input(INPUT_POST, 'recipeTagSelection');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Search</title>
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

    <form class='recipeSearchForm' action='searchResults.php' method='post'>
        <div class="container">
            <h1>Recipe Searching</h1>
            <hr>
            <div>
                <input type='hidden' id='submittedOrNot' name='submittedOrNot' value='YES'>
            </div>
            <div>
                <label for='recipeSearchBar'><b>Enter Search Parameters</b></label>
                <input type='search' id='recipeSearchBar' placeholder='Search Name' name='recipeSearchBar' required><br>
                <p style='color: Blue'><i>Write "NONE" if you want to display <b>all</b> recipes</i></p>
            </div>
            <hr>
            <h2>Advanced Search Options:</h2>
            <hr>
            <div>
                <label for='recipeSearchCookingTime'><b>Cooking Time</b></label>
                <input type='number' name='recipeSearchCookingTime' defuault='NULL' min='0' max='1000'>
            </div>
            <div>
                <p><b>Ratings</b></p>
                <input type='radio' id='rating1' name='ratings' value='1'>
                <label for='rating1'>1 star</label><br>
                <input type='radio' id='rating2' name='ratings' value='2'>
                <label for='rating2'>2 star</label><br>
                <input type='radio' id='rating3' name='ratings' value='3'>
                <label for='rating3'>3 star</label><br>
                <input type='radio' id='rating4' name='ratings' value='4'>
                <label for='rating4'>4 star</label><br>
                <input type='radio' id='rating5' name='ratings' value='5'>
                <label for='rating5'>5 star</label><br>
            </div>
            <div>
                <p><b>Last Cooked Date</b></p>
                <input type='date' id='recipeSearchLastCooked' name='lastcooked' default='NULL'>
                <label for='recipeSearchLastCooked'>Search for inputted date or earlier</label><br>
            </div>
            <div>
                <p><b>Calorie Count</b></p>
                <label for='recipeSearchCalorieCount'><b>Search for inputted calorie count or lower</b></label>
                <input type='number' name='recipeSearchCalorieCount' default='NULL' min='0' max='2500'><br>
            </div>

            <div>
                <p><b>Recipe Tags</b></p>
                <label for='recipeTagSelection'>Choose Recipe Tags</label>
                <select id='recipeTagSelection' name='recipeTagSelection'>
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
            </div>

            <hr>
            <div>
                <button type='submit' name='recipeSearchBtn'>Search!</button>
            </div>
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