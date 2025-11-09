<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:dashboard.php');
    exit();
}
$select_course = $conn->prepare("SELECT * FROM `courses` WHERE course_id = ?");
$select_course->execute([$get_id]);
$fetch_course = $select_course->fetch(PDO::FETCH_ASSOC);;
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    $course_name = $fetch_course['course_name'];

    if ($fetch_user['email'] == $email && $fetch_user['password'] == $pass && $fetch_user['password'] == $c_pass) {
        $message2[] = "are you sure you want to are register for $course_name";
    } else {
        $message[] = 'enter the correct email or password';
    }
}

if (isset($_POST['yes'])) {
    $select_registration = $conn->prepare("SELECT * FROM `course_registration` WHERE user_id = ? AND course_id = ?");
    $select_registration->execute([$user_id, $get_id]);

    if ($select_registration->rowCount() > 0) {
        $message[] = 'You have register for this course before';
    } else {
        $add_registration = $conn->prepare("INSERT INTO `course_registration`(user_id, course_id) VALUES(?,?)");
        $add_registration->execute([$user_id, $fetch_course['course_id']]);
        header("location:dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body style="padding-left: 0;">


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

    if (isset($message2)) {
        foreach ($message2 as $message2) {
            if (isset($_POST['yes'])) {
                echo 'helloworld';
            }
            echo '
            <div class="message2 form">
                <span>' . $message2 . '</span>
                <form method="post">
                    <input type="submit" value="yes" name="yes" class="btn">
                </form>
            </div>
        
        ';
        }
    }
    ?>



    <section class="form-container course_register">

        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>register now</h3>
            <div class="flex">
                <div class="col">
                    <p>your email <span>*</span></p>
                    <input type="text" name="email" maxlength="50" required placeholder="enter your email" class="box">
                    <p>your password <span>*</span></p>
                    <input type="password" name="pass" maxlength="20" required placeholder="enter any password" class="box">
                    <p>confirm password <span>*</span></p>
                    <input type="password" name="c_pass" maxlength="20" required placeholder="confirm password" class="box">
                </div>
            </div>
            <input type="submit" value="register now" name="submit" class="btn">
        </form>

    </section>

    <script src="js/admin_script.js"></script>

</body>

</html>