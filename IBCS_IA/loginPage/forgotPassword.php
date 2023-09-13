<?php
    session_start();

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    if(!empty($_POST['userEmail'])) {
        $retrievalEmail = filter_input(INPUT_POST, "userEmail");

        $sql = "SELECT * FROM `Auth_Users` WHERE UserEmail LIKE '$retrievalEmail';";
        $result = $mysqli->query($sql);

        if($result->num_rows > 0) {
            $recordData = $result->fetch_assoc();

            $retrievedPassword = "<p style='color: Green'>Thank you! Your password is: ".$recordData['PassWord'];
        } else {
            $retrievedPassword = "<p style='color: Red'>Sorry, your email isn't registered on our database, either check for a typo or signup <a href='/signUp'>here</a>.</p>";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
    
    <form class='forgotPasswordForm' action='' method='post'>
        <div class='container'>
            <h1>Password Retrieval</h1>
            <hr>
            <div>
                <input type='email' id='userEmail' name='userEmail' placeholder='Enter Email'>
                <label for='userEmail'>Enter your registered Email to verify your identity</label>
                <br>
                <button type='submit' name='forgotPWEmailSubmitBtn'>Submit</button>
                <hr>
            </div>
            <?php
                if(!empty($_POST['userEmail'])) {
                    echo $retrievedPassword;
                }
            ?>
        </div>
    </form>
    
    <?php
        $path = "/include/footer.php";
        include($root.$path);

        $mysqli->close();
    ?>
</body>
</html>