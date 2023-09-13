<?php
    session_start();

    $root = $_SERVER["DOCUMENT_ROOT"];

    $path = "/include/dbConn.php";

    include($root.$path);

    if(!empty($_POST["UserName"])) {
        $username = filter_input(INPUT_POST, 'UserName');
        $password = filter_input(INPUT_POST, 'PassWord');

        $sql = "SELECT * FROM Auth_Users WHERE UserName LIKE '$username' AND PassWord LIKE'$password'";
        $result = $mysqli->query($sql);

        if($result->num_rows > 0) {
            $_SESSION["AUTHENTICATED"] = TRUE;

            $recordData = $result->fetch_assoc();

            $_SESSION["User_ID"] = $recordData["User_ID"];

            $_SESSION["DisplayName"] = $recordData["UserName"];

            $_SESSION["AdminStatus"] = $recordData["AdminStatus"];


            $redirectURL = "http://localhost:8081";

            header("Location: ". $redirectURL);
        } else {
            $errorMsg = "Username or Password is Incorrect :(";

            $_SESSION["AUTHENTICATED"] = FALSE;
            $_SESSION["AdminStatus"] = "GUEST";
        }
        $mysqli->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="../css/index.css">
        <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
    </head>

    <body>
        <?php
            $path = "/include/header.php";
            include($root.$path);

            $path = "/include/menu.php";
            include($root.$path);

            echo "<form class='loginForm' action='' method='post'>";

            if($errorMsg !="") {
                echo "<p class='errs'>".$errorMsg."</p>";
            }
            echo "
                <div class='container'>
                    <h1>Login</h1>
                    <hr>
                    <div>
                        <label for='uname'><b>Enter Username</b></label>
                        <input type='text' placeholder='Enter Username' name='UserName' required>
                    </div>

                    <div>
                        <label for='pwd'><b>Enter Password</b></label>
                        <input type='password' placeholder='Enter Password' name='PassWord' required>
                    </div>

                    <div>
                        <button type='submit' name='loginButton'>Login</button>
                        <button type='button' onclick='ForgotPWredirectFunction()'>Forgot Password</button>
                    </div>
                    <hr>
                </div>
                </form>
            ";

            $path = "/include/footer.php";
            include($root.$path);
        ?>
        
        <script>
            function ForgotPWredirectFunction() {
                location.replace("http://localhost:8081/loginPage/forgotPassword.php");
            }
        </script>
    </body>
</html>