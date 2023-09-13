<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    if(!empty($_POST["logoutButton"])) {
        if($_POST["logoutButton"] == "YES") {
            $_SESSION["AUTHENTICATED"] = FALSE;
            
            session_destroy();

            $redirectURL = "http://localhost:8081";
            header("Location: ".$redirectURL);
        }
        else {
            $redirectURL = "http://localhost:8081";
            header("Location: ".$redirectURL);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGOUT?</title>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
</head>
<body>
    <?php
        $path = "/include/header.php";
        include($root.$path);
    
    echo "<form action='' method='post'>
            <div class='container'>
                <h1>Logout?</h1>
                    <p style='color: red'>You sure you want to <b>logout?</b></p>
                <div>
                    <button type='submit' name='logoutButton' value='YES'>Confirm</button>
                    <button type='submit' name='logoutButton' value='NO'>No</button>
                </div>
            </div>
        </form>";
    ?>
</body>
</html>