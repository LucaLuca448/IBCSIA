<?php
session_start();

if ($_SESSION["AdminStatus"] == "ADMIN"){
    $sayHi = "Hi, ADMIN";
}
elseif($_SESSION["AdminStatus"] == "USER"){
    $sayHi = "Hi, User ". $_SESSION["User_ID"];
}
else{
    $sayHi = "Hi, GUEST, please log in to continue";
}
$root = $_SERVER['DOCUMENT_ROOT'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="HTML, CSS" />
    <meta name="description" content="An XD catalogue" />

    <title>
      MainPage
    </title>

    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">

  </head>

  <body>

    <?php 
      $path = "/include/header.php";
      include_once($root.$path);
    ?>

    <?php
      $path = "/include/menu.php";
      include_once($root.$path);
      echo "<br>"."<p class='greeting'>".$sayHi."</p>"."</br>";
      echo "<p>This is the home page</p>";
    ?>

    <?php
      $path = "/include/footer.php";
      include_once($root.$path);
    ?>
    
  </body>
</html>
