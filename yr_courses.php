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
            <a href="yr_contact.php">Contact Us</a>
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

    <section class="course-catalog">
        <h1 class="heading">Our Courses</h1>
        <div class="box-container">
            <?php
            $select_courses = $conn->prepare("SELECT * FROM `courses`");
            $select_courses->execute();
            if ($select_courses->rowCount() > 0) {
                while ($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                    $course_id = $fetch_course['course_id'];

            ?>
                    <div class="box">
                        <div class="thumb">
                            <img src="uploaded_files/<?= $fetch_course['course_img']; ?>" alt="">
                        </div>
                        <h3 class="title"><?= $fetch_course['course_name']; ?></h3>
                        <span class="details"><?= $fetch_course['course_details']; ?></span>
                        <div class="flex">
                            <span><?= $fetch_course['course_price']; ?></span>
                            <span><?= $fetch_course['course_duration']; ?></span>
                        </div>
                        <a href="register.php?get_id=<?= $course_id; ?>" class="inline-btn">register now</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no courses added yet!</p>';
            }
            ?>
        </div>
    </section>


    <section class="features">
        <h1 class="heading">key features</h1>
        <div class="box-container">
            <div class="box">
                <h3>Recorded Sessions</h3>
                <p>Download past classes and learn at your own pace</p>
            </div>
            <div class="box">
                <h3>Certification</h3>
                <p>Earn certificate upon course completion</p>
            </div>
            <div class="box">
                <h3>Student Dashboard</h3>
                <p>Track you progress and manage enrolled course</p>
            </div>
            <div class="box">
                <h3>Discussion Forum</h3>
                <p>Engage with instructors and fellow students</p>
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

        const quotes1 = [
            "Empowering the next generation of tech creators - one line of code at a time.",
            "We don't just teach tech skills - we build careers, confidence, and creators.",
            "Accessible. Practical. Powerful. That's our education model.",
            "Learn by building. Grow by doing. Suceed by becoming",
            "From curiosity to career - we guide you every step of the way."
        ];

        const quotes2 = [
            "Empowering the next generation of tech creators - one line of code at a time.",
            "We don't just teach tech skills - we build careers, confidence, and creators.",
            "Accessible. Practical. Powerful. That's our education model.",
            "Learn by building. Grow by doing. Suceed by becoming",
            "From curiosity to career - we guide you every step of the way."
        ];

        let index = 0;
        let index2 = 0;
        const quoteEl = document.getElementById("mission-quotes");
        const quoteEl2 = document.getElementById("mission-quotes2");

        function rotatingQuote1() {
            quoteEl.textContent = quotes1[index];
            index = (index + 1) % quotes1.length;
        }

        function rotatingQuote2() {
            quoteEl2.textContent = quotes2[index2];
            index2 = (index2 + 1) % quotes2.length;
        }

        rotatingQuote1();
        rotatingQuote2();
        setInterval(rotatingQuote1, 5000);
        setInterval(rotatingQuote2, 5000);
    </script>
</body>

</html>