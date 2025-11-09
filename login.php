<?php
    include 'components/connect.php';

    if(isset($_COOKIE['user_id'])){
        $tutor_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }


    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $verify_tutor = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
        $verify_tutor->execute([$email, $pass]);
        $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);

            if($verify_tutor->rowCount() > 0){
                setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
                header('location:dashboard.php');
            }
            else{
                $message[] = 'incorrect email or password';
            }


    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body style="padding-left: 0;" class="FormContainer">
<?php

if(isset($message)){
    foreach($message as $message){
        echo '
            <div class="message form">
                <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();">x</i>
            </div>
        
        ';
    }
}
?>    

    <div class="formContainer">
    <img src="images/ruach_academy_logo.png" alt="" class="formContainer-img">
    <h3>welcome back!</h3>
        <form action="" method="post" class="register-form">

            <div class="col">
            <p>your email <span>*</span></p>
            <input type="email" name="email" placeholder="enter your email" maxlength="100" class="box" required>
            </div>
            <div class="col" style="position: relative;">
            <p>your passsword <span>*</span></p>
            <input type="password" name="pass" placeholder="enter your password" maxlength="50" class="box" required id="pass">
            <img src="images/eye-close.png" alt="" style="position: absolute;
                                                                    width :3rem;
                                                                    height: 3rem;
                                                                    right: 10px;
                                                                    bottom: 5px"
                                                                    id="icon">
            </div>
            <input type="submit" name="submit" value="login now" class="btn">
            <p class="link">dont have an account yet     <a href="register.php">register now</a></p>
        </form>
    </div>

    <footer class="footer">
        &copy; copyright @ <?= date('Y'); ?> by <span>Davepet</span> | all rights reserved
    </footer>


    <script src="js/script.js"></script>
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