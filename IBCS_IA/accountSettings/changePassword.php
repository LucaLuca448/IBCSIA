<?php
    session_start();
    
    if($_SESSION['AUTHENTICATED'] == FALSE) {
        header("Location: http://localhost:8081");
    }

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    $displayName = $_SESSION["DisplayName"];

    if(!empty($_POST['curPW'])) {
        $sql = "SELECT * FROM `Auth_Users` WHERE UserName LIKE '$displayName';";
        $result = $mysqli->query($sql);
        $recordData = $result->fetch_assoc();
        $toCheck = $recordData['PassWord'];
        if($toCheck == $_POST['curPW']) {
            if($_POST['confirmPW'] == $_POST['newPW']) {
                $toSQL = $_POST['newPW'];
                $sql = "UPDATE `Auth_Users` SET PassWord = '$toSQL' WHERE UserName LIKE '$displayName';";
                $mysqli->query($sql);
                echo "<script>alert('Password Updated');</script>";
                header("Location: http://localhost:8081/accountSettings");
            } else {
                echo '<script>alert("new passwords do not match")</script>';
            }
        } else {
            echo '<script>alert("Current password does not match database")</script>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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

    <form class='changePWForm' action='' method='post'>
        <div class='container'>
            <h1>Change Password</h1>
            <label for='curPW'>State Current Password</label>
            <input type='text' id='curPW' name='curPW' required>
            <br>
            <label for='newPW'>State New Password</label>
            <input type='text' id='newPW' name='newPW' required>
            <br>
            <label for='confirmPW'>Confirm new Password</label>
            <input type='text' id='confirmPW' name='confirmPW' required>
            <br>
            <button type='submit'>Submit!</button>
        </div>
    </form>

    <hr>

    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>