<?php
include 'components/connect.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Courses</title>
    <link rel="stylesheet" href="css/base.css">
</head>

<body>
    <div class="minor-header" id="minor-header">
        <img src="images/logo.png" alt="">
        <div class="open-btn" id="open-bar">k</div>
    </div>
    <header class="header" id="header">
        <div class="close-btn" id="close-bar">X</div>
        <div class="flex">
            <a href="#" class="logo"><img src="images/logo.png" alt=""></a>
        </div>

        <div class="navlinks">
            <a href="index.php">Home</a>
            <a href="user_about.php">About Us</a>
            <a href="yr_courses.php">Courses</a>
            <a href="#Contact">Contact Us</a>
        </div>

        <div class="flex-btn">
            <a href="login.php" class="option-btn">Login</a>
            <a href="register.php" class="option-btn">Register</a>
        </div>

    </header>


    <div class="n-home" id="home">
        <h2>Welcome to Apex Tutors - Way to the future</h2>
        <a href="yr_courses.php" id="courses" class="option-btn" style="width: 200px;">Browse Courses</a>
    </div>

    <section class="contact">
        <h1 class="heading">Get in touch</h1>

        <div class="flex">

            <form action="submit_contact.php" method="post">
                <div class="box">
                    <span>Full Name</span>
                    <input type="text" class="text-box" name="name" required>
                </div>
                <div class="box">
                    <span>Email Address</span>
                    <input type="email" class="text-box" name="email" required>
                </div>
                <div class="box">
                    <span>Subject</span>
                    <textarea name="subject" id="" placeholder="enter your message" cols="30" rows="10" required></textarea>
                </div>
                <input type="submit" value="send message" class="inline-btn" name="submit">
            </form>

            <div class="contact-info">
                <h1>Contact Information</h1>
                <div class="top">
                    <p><i class="fas fa-envelope"></i> contact@apextutors.com</p>
                    <p><i class="fas fa-phone"></i> +234 8038013507</p>
                </div>
                <div class="bottom">
                    <div><i class="fas fa-facebook"></i></div>
                    <div><i class="fas fa-twitter"></i></div>
                    <div><i class="fas fa-instagram"></i></div>
                </div>
            </div>
        </div>
    </section>


    <footer>
        <div class="box">
            <img src="images/logo.png" alt="">
        </div>
        <div class="section">
            <h1>Contact</h1>
            <a href="apextutors.com">Website: apextutors.com</a>
            <a>Phone/Whatsapp: 08038013507 08028916801</a>
            <a>Email: info@apextutors.com</a>
        </div>
        <div class="section">
            <h1>About</h1>
            <a href="about.html">About Us</a>
            <a href="privacy.html">Privacy Policy</a>
            <a href="tandc.html">Terms and Conditions</a>
        </div>
        <div class="section">
            <h1>My Account</h1>
            <div class="flex-btn">
                <a href="login.php" class="option-btn" style="padding-top: 10px;">Login</a>
                <a href="register.php" class="option-btn" style="padding-top: 10px;">Register</a>
            </div>
        </div>
    </footer>


    <script>
        var bar = document.getElementById("header");
        var smallBar = document.getElementById("minor-header");
        var openBar = document.getElementById("open-bar");
        var closeBar = document.getElementById("close-bar");
        var home = document.getElementById("home");

        openBar.onclick = () => {
            smallBar.style.display = "none";
            home.style.height = "100vh";
            bar.style.left = "0";
        }

        closeBar.onclick = () => {
            smallBar.style.display = "flex";
            home.style.height = "50vh";
            bar.style.left = "-25rem";
        }

        window.onscroll = () => {
            if (window.innerWidth < 1200) {
                smallBar.style.display = "flex";
                home.style.height = "50vh";
                bar.style.left = "-25rem";
            }
        }
    </script>
</body>

</html>