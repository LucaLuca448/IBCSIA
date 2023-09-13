<?php
    session_start();

    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(isset($_POST["deleteAccButton"])) {
        if($_POST["deleteAccButton"] == "YES") {
            $tempUN = $_SESSION["DisplayName"];

            $_SESSION["AUTHENTICATED"] = FALSE;
            
            session_destroy();

            $sql = "DELETE FROM `Auth_Users` WHERE `UserName` LIKE '$tempUN'";
            $mysqli->query($sql);

            echo "<p style='color: Green'>Account Deleted Sucessfully!</p>";

            sleep(2);

            $redirectURL = "http://localhost:8081";
            header("Location: ".$redirectURL);
        } else {
            $redirectURL = "http://localhost:8081/accountSettings";
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
    <title>Document</title>
    <link rel='stylesheet' type='text/css' href='../css/index.css'>
    <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
</head>
<body>

    <?php
        $path = "/include/header.php";
        include($root.$path);

        $path = "/include/menu.php";
        include($root.$path);
    ?>

    <h1>DELETING ACCOUNT</h1>
    <p style='color: red'>Are you sure you want to delete your account? <b>WARNING: This cannot be undone</b></p>

    <form action='' method='post'>
        <div class='container'>
            <div>
                <button type='submit' name='deleteAccButton' value='YES'>CONFIRM</button>
                <button type='submit' name='deleteAccButton' value='NO'>GO BACK</button>
            </div>
        
        </div>
    </form>

    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>