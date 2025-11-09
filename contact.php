<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $message = $_POST['message'];
    $message = filter_var($message, FILTER_SANITIZE_STRING);

    $to = 'iyiolaaibola71@gmail.com';
    $subject = 'Contact Message';
    $message = '$message';
    $headers = "From: $name $email $phone\r\n";
    if (mail($to, $subject, $message, $headers)) {
        $message[] = 'message sent sucessfully';
    } else {
        $message[]  = 'something went wrong';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <section class="contact">

        <div class="row">

            <div class="image">
                <img src="images/contact-img.png" alt="">
            </div>

            <form action="" method="post">
                <h3>get in touch</h3>
                <input type="text" placeholder="enter your name" required maxlength="100" name="name" class="box">
                <input type="text" placeholder="enter your email" required maxlength="100" name="email" class="box">
                <input type="text" placeholder="enter your number" required maxlength="100" name="phone" class="box">
                <textarea name="message" id="" class="box" placeholder="enter your message" cols="30" rows="10" required></textarea>
                <input type="submit" value="send message" class="inline-btn" name="submit">
            </form>
        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-phone"></i>
                <h3>phone number</h3>
                <a href="tel:08038013507">08038013507</a>
                <a href="tel:08028916809">08028916809</a>
            </div>

            <div class="box">
                <i class="fas fa-envelope"></i>
                <h3>email address</h3>
                <a href="mailto:iyiolaajibola71@gmail.com">iyiolaajibola71@gmail.com</a>
                <a href="tel:iyiolaajibola71@gmail.com">iyiolaajibola71@gmail.com</a>
            </div>

            <div class="box">
                <i class="fas fa-map-marker-alt"></i>
                <h3>social media</h3>
                <a href="#">whatapp</a>
                <a href="#">facebook</a>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>