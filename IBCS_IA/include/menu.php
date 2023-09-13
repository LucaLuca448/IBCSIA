<?php
    echo "<div class='topnav'>
            <a href='/' class='active'>Home</a>";


    // SHOW/HIDE Admin Functions
    if ($_SESSION["AdminStatus"] == "ADMIN" && $_SESSION["AUTHENTICATED"] == TRUE){
        echo "<a href='/admin'>Admin Stats Page</a>";
        echo "<a href='/IngredientPages'>Ingredient Menu</a>";
        echo "<a href='/recipePages'>Recipe Menu</a>";
        echo "<a href='/recipeTags'>Recipe Tags</a>";
        echo "<a href='/accountSettings'>Account Settings</a>";
        echo "<a href='/logoutPage'>LOGOUT</a>";
    }
    elseif ($_SESSION["AUTHENTICATED"] == TRUE) {
        echo "<a href='/IngredientPages'>Ingredient Menu</a>";
        echo "<a href='/recipePages'>Recipe Menu</a>";
        echo "<a href='/recipeTags'>Recipe Tags</a>";
        echo "<a href='/accountSettings'>Account Settings</a>";
        echo "<a href='/logoutPage'>LOGOUT</a>";
    } 
    else { 
        echo "<a href='/loginPage'>LOGIN</a>";
        echo "<a href='/signUp'>SIGNUP</a>";
    };


    echo "</div>";
?>