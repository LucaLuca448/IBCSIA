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

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .profileImage {
            width: 200px;
            border-radius: 10px;
            margin-right: 10px;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
</head>
<body>
    <?php
        $path = "/include/header.php";
        include($root.$path);

        $path = "/include/menu.php";
        include($root.$path);

        echo "<h1>".$displayName."'s Account Profile"."</h1>";

        //Profile Picture Spot
        $sql = "SELECT * FROM `Auth_Users` WHERE `UserName` LIKE '$displayName';";
        $result = $mysqli->query($sql);

        $recordData = $result->fetch_assoc();

        $finalImagePath = $recordData['ProfilePic'];

        if($result->num_rows > 0) {
            echo "<div>
                    <img class='profileImage' src='uploadedImages/$finalImagePath' alt='Your Profile Picture'>
                </div>
            ";
        } else {
            echo "<div>
                    <img class='profileImage' src='uploadedImages/AnonymousPerson.png' alt='Anonymous Profile Picture'>
                </div>
            ";
        };
        ?>
        
    <a href='uploadPFP.php' target='_blank'>Upload profile Picture Here!</a>

    <br>
    
    <a href='changePassword.php'>Change Password</a>
    
    <br>
    
    <a style='color: red' href='deleteAccount.php'>Delete Account</a>

    <hr>

    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>