<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
if (isset($_POST['submit'])) {

    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'uploaded_files/' . $rename;

    $select_user_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user_email->execute([$email]);

    if ($select_user_email->rowCount() > 0) {
        $message[] = 'email already taken';
    } else {
        if ($pass != $c_pass) {
            $message[] = 'password not matched!';
        } else {
            if ($image_size > 20000000) {
                $message[] = 'image is too large!';
            } else {
                $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image) VALUES(?,?,?,?,?)");
                $insert_user->execute([$id, $name, $email, $c_pass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);

                $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
                $verify_user->execute([$email, $c_pass]);
                $row = $verify_user->fetch(PDO::FETCH_ASSOC);

                if ($insert_user) {
                    if ($verify_user->rowCount() > 0) {
                        setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
                        header('location:dashboard.php');
                    } else {
                        $message[] = 'something went wrong';
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin_style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body style="padding-left: 0;" class="FormContainer">


    <?php

    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message form">
                <span>' . $message . '</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        
        ';
        }
    }
    ?>


    <div class="formContainer">
    <img src="images/ruach_academy_logo.png" alt="" class="formContainer-img">

    <h3>register now</h3>
        <form action="" method="post" enctype="multipart/form-data" class="register-form">
                <div class="col">
                    <p>your name <span>*</span></p>
                    <input type="text" name="name" maxlength="50" required placeholder="enter your name" class="box">
                </div>
                <div class="col">
                    <p>your email <span>*</span></p>
                    <input type="text" name="email" maxlength="50" required placeholder="enter your email" class="box">
                </div>
                <div class="col" style="position: relative;">
                    <p>your password <span>*</span></p>
                    <input type="password" name="pass" maxlength="20" required placeholder="enter any password" class="box" id="pass">
                    <img src="images/eye-close.png" alt="" style="position: absolute;
                                                                    width :3rem;
                                                                    height: 3rem;
                                                                    right: 10px;
                                                                    bottom: 5px"
                                                                    id="icon">
                </div>
                <div class="col" style="position: relative;">
                    <p>confirm password <span>*</span></p>
                    <input type="password" name="c_pass" maxlength="20" required placeholder="confirm password" class="box">
                </div>

                <div class="col">
                    <p>select pic <span>*</span></p>
                    <input type="file" name="image" class="box" required accept="image/*">
                </div>
            <input type="submit" value="register now" name="submit" class="btn">
            <p class="link">already have an account <a href="login.php">login now</a></p>

        </form>

    </div>

    <script src="js/admin_script.js"></script>
    <script>
        var pass = document.getElementById("pass");
        var icon = document.getElementById("icon");

        icon.onclick = function() {
            if (pass.type == "password"){
                pass.type = "text";
                icon.src = "images/eye-open.png";
            }
            else{
                pass.type = "password";
                icon.src = "images/eye-close.png";
            }
        }
    </script>

</body>

</html>