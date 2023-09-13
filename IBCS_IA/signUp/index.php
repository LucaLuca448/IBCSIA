<?php
    session_start();

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbconn.php";

    include($root.$path);

    $signupUN = filter_input(INPUT_POST, "SignupUN");
    $signupPW = filter_input(INPUT_POST, "SignupPW");
    $signupAdmin = filter_input(INPUT_POST, "AdminStatus");
    $signupEmail = filter_input(INPUT_POST, "SignupEmail");

    if(!empty($_POST["SignupUN"])) {
        if($signupAdmin == "GIVEADMIN") {
            $sql = "INSERT INTO `Auth_Users` (`User_ID`, `UserName`, `PassWord`, `AdminStatus`, `ProfilePic`, `UserEmail`) VALUES (NULL, '$signupUN', '$signupPW', 'ADMIN', 'AnonymousPerson.png', '$signupEmail');";
            $mysqli->query($sql);
            echo "<p style='color: red'>Account Created with Admin Permissions</p>";

            $redirectURL = "http://localhost:8081/loginPage";
            header("Location: ".$redirectURL);
    
        } else {
            $sql = "INSERT INTO `Auth_Users` (`User_ID`, `UserName`, `PassWord`, `AdminStatus`, `ProfilePic`, `UserEmail`) VALUES (NULL, '$signupUN', '$signupPW', 'USER', 'AnonymousPerson.png', '$signupEmail');";
            $mysqli->query($sql);
            if($mysqli->connect_error) {
                die("Connection Failed to ".$serverName.$mysqli->connect_error);
            } else {
                echo "<p style='color: red'>Account created</p>";
                $redirectURL = "http://localhost:8081/loginPage";
                header("Location: ".$redirectURL);
            }
            
        };
    };

    $mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/index.css">
        <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
        <title>Signup Page</title>
    </head>
    <body>
        <?php
            $path = "/include/header.php";
            include($root.$path);

            $path = "/include/menu.php";
            include($root.$path);

            echo "<form class='signupForm' action='' method='post' style='border: 1px solid #ccc'>";

            echo "
                <div class='container'>
                    <h1>Sign Up</h1>
                    <p>Please Fill out the boxes below to setup your account</p>
                    <p style='color: red;'>* marked fields are mandatory</p>
                    <hr>
                    <div>
                        <label for='uname'><b>Username *</b></label>
                        <input type='text' placeholder='Enter Username*' name='SignupUN' required>
                    </div>

                    <div>
                        <label for='pwd'><b>Password *</b></label>
                        <input type='password' placeholder='Enter Password*' name='SignupPW' required>
                    </div>

                    <div>
                        <label for='email'><b>Email Address *</b></label>
                        <input type='email' placeholder='Enter Email*' name='SignupEmail' required>
                    </div>

                    <div>
                        <label for='adminPriviliges'><b>Admin Code</b></label>
                        <input type='adminStuff' placeholder='Enter Admin Code' name='AdminStatus'>

                    </div>

                    <div>
                        <button type='submit' name='signupbutton'>Signup!</button>
                    </div>
                    <hr>
                </div>
                </form>
            ";

            $path = "/include/footer.php";
            include($root.$path);
        ?>
    </body>
</html>