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
    <title>Upload PFP Settings</title>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="icon" type="image/x-icon" href="../css/Favicon.ico">
</head>
<body>
    <div class="container">
        <?php
            $path = "/include/header.php";
            include($root.$path);

            $path = "/include/menu.php";
            include($root.$path);

            echo "<h1>".$displayName."'s Account Profile Pic Upload"."</h1>";

            echo "
                <form class='uploadpfpForm' action='' method='post' enctype='multipart/form-data'>
                    <input accept='image/*' type='file' name='myImage' required><input type='submit' name='submit' value='upload'>
                </form>
            ";

            if(isset($_POST["submit"]) && isset($_FILES['myImage'])) {
                $imageCheck = getimagesize($_FILES["myImage"]["tmp_name"]);
                if($imageCheck !== FALSE) {
                    echo "<p>Image Uploaded</p>";
                    echo "<pre>";
                    print_r($_FILES['myImage']);
                    echo "</pre>";

                    $imageName = $_FILES['myImage']['name'];
                    $imageSize = $_FILES['myImage']['size'];
                    $tempName = $_FILES['myImage']['tmp_name'];
                    $imageError = $_FILES['myImage']['error'];

                    if($imageError !== 0) {
                        switch ($imageError) {
                            case 1:
                                echo "<p style='color: red'>PHP UPLOAD_ERR_INI_SIZE: The uploaded file exceeds the <b>upload_max_filesize</b> directive in php.ini.</p>";
                                break;
                            case 2:
                                echo "<p style='color: red'>PHP UPLOAD_ERR_FORM_SIZE: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.</p>";
                                break;
                            case 3:
                                echo "<p style='color: red'>PHP UPLOAD_ERR_PARTIAL: The uploaded file was only partially uploaded.";
                                break;
                            case 4:
                                echo "<p style='color: red'>PHP UPLOAD_ERR_NO_FILE: No file was uploaded";
                                break;
                            case 6:
                                echo "<p style='color: red'>PHP UPLOAD_ERR_NO_TMP_DIR: Missing a temporary folder.";
                                break;
                            case 7:
                                echo "<p style='color: red'>PHP UPLOAD_ERR_CANT_WRITE: Failed to write file to disk.";
                                break;
                            case 8:
                                echo "<p style='color: red'>PHP UPLOAD_ERR_EXTENSION: A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.";
                                break;
                            default:
                                echo "An unknown error occured :(";
                                break;
                        }
                    } else {
                        if($imageSize > 1000000) {
                            $errormsg = "Sorry your file is too large";
                            echo "<script>alert('$errormsg');</script>";
                            //header("Location: http://localhost:8081/accountSettings/uploadPFP.php?error=$errormsg");
                        } else {
                            $imgExtension = pathinfo($imageName, PATHINFO_EXTENSION);
                            $img_Ex_Lc = strtolower($imgExtension);

                            $allowedExtensions = array("jpg", "jpeg", "png");

                            if(in_array($img_Ex_Lc, $allowedExtensions)) {
                                $newImageName = uniqid("IMG-", TRUE).".".$img_Ex_Lc;
                                $imageUploadPath = "uploadedImages/".$newImageName;

                                move_uploaded_file($tempName, $imageUploadPath);

                                $sql = "UPDATE `Auth_Users` SET `ProfilePic`='$newImageName' WHERE `UserName`='$displayName';";
                                $mysqli->query($sql);

                                echo "<p style='color: green'>File Uploaded! Redirecting you to your profile...</p>";
                                sleep(2);
                                header("Location: http://localhost:8081/accountSettings/");

                            } else {
                                $errormsg = "File type not supported, try again";
                                echo "<script>alert('$errormsg');</script>";
                                //header("Location: http://localhost:8081/accountSettings/uploadPFP.php?error=$errormsg");
                            }
                        }
                    }
                } else {
                    echo "<p style='color: red'>File is not a proper image, please upload a differet file</p>";
                }
        
            } else {
                echo "<p>No image uploaded</p>";
                echo "<p style='color: Green'>Accepted file formats include jpg, jpeg, png</p>";
            };

            /* $sql = "SELECT `ProfilePic` FROM `Auth_Users` WHERE `UserName` LIKE '$displayName';";
            $result = $mysqli->query($sql);

            $profileImg = imagecreatefromstring($result);

            ob_start();
            $data = ob_get_contents();
            ob_end_clean();

            echo "<img class='profileImage' src='data:image/jpg;base64,".base64_encode($data)." alt='Your Profile Picture';>";

             if($result != NULL) {
                $profileImg = imagecreatefromstring($result);

                ob_start();
                imagejpeg($profileImg, null, 80);
                $data = ob_get_contents();
                ob_end_clean();

                echo "<img class='profileImage' src='data:image/jpg;base64,".base64_encode($data)." alt='Your Profile Picture';>";
            }
            else {
                echo "<img class='profileImage' src='../css/AnonymousPerson.png' alt='Anonymous Person Picture';>";
            }; */

            $mysqli->close();
        ?>

        <div>
            <hr>
            <?php
                $path = "/include/footer.php";
                include($root.$path);
            ?>
        </div>
    </div>
</body>
</html>