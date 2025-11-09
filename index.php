<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apex Programming Tutors APT</title>
    <link rel="stylesheet" href="css\base.css">
</head>

<body>
    <?php include "components/welcome_header.php"; ?>


    <!--<section class="about" id="about">
        <h1 class="heading">About Us</h1>

        <div class="about-container">
        <div class="about-img">
            <img src="images/flier.png" alt="">
        </div>

        <div class="about-text">
            <h1>Why Choose Us</h1>
            <span>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam similique harum, eius nostrum earum laudantium ab totam. Quasi, minima perferendis esse, dolorem fugit ad provident amet cupiditate ipsum voluptatem eveniet!</span>
        </div>
        </div>
    </section>-->

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

    <section class="testimonials">
        <h1 class="heading">
            Testiomonials
        </h1>
        <div class="box-container">
            <div class="box">
                <img src="images/pic-1.jpg" alt="">
                <div class="testimonial-details">
                    <h1>
                        Osungbure Feranmi
                    </h1>
                    <span>
                        "Apex Tutors helped me land my first tech job"
                    </span>
                </div>
            </div>

            <div class="box">
                <img src="images/pic-1.jpg" alt="">
                <div class="testimonial-details">
                    <h1>
                        Iyiola Ajibola
                    </h1>
                    <span>
                        "I now earn in 6 digits all because of Apex tutors"
                    </span>
                </div>
            </div>

            <div class="box">
                <img src="images/pic-1.jpg" alt="">
                <div class="testimonial-details">
                    <h1>
                        Jane Doe
                    </h1>
                    <span>
                        "Apex Tutors helped me to have a first class in the university"
                    </span>
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

    <img src="images/logo.png" alt="" class="rotating-image" id="rotatingImage">

    <!--<section class="courses" id="courses">
        <h1 class="heading">Our Courses</h1>

        <div class="box-container">
            <div class="box">
                <div class="course-img">
                    <img src="images/thumb-1.png" alt="">
                </div>
                <div class="course-details">
                    <h1>Web Development</h1>
                    <span>Price: $10/month</span>
                    <span>Course Duration: 8months</span>
                    <a href="register.php" class="option-btn">Register Now</a>

                </div>
            </div>

            <div class="box">
                <div class="course-img">
                    <img src="images/thumb-1.png" alt="">
                </div>
                <div class="course-details">
                    <h1>App Development</h1>
                    <span>Price: $10/month</span>
                    <span>Course Duration: 8months</span>
                    <a href="register.php" class="option-btn">Register Now</a>
                </div>
            </div>

            <div class="box">
                <div class="course-img">
                    <img src="images/thumb-1.png" alt="">
                </div>
                <div class="course-details">
                    <h1>Web Development</h1>
                    <span>Price: $10/month</span>
                    <span>Course Duration: 8months</span>
                    <a href="register.php" class="option-btn">Register Now</a>
                </div>
            </div>

            <div class="box">
                <div class="course-img">
                    <img src="images/thumb-1.png" alt="">
                </div>
                <div class="course-details">
                    <h1>Web Development</h1>
                    <span>Price: $10/month</span>
                    <span>Course Duration: 8months</span>
                    <a href="register.php" class="option-btn">Register Now</a>
                </div>
            </div>
        </div>
    </section>
-->

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
            home.style.height = "90vh";
            bar.style.left = "-25rem";
        }

        window.onscroll = () => {
            if (window.innerWidth < 1200) {
                smallBar.style.display = "flex";
                home.style.height = "90vh";
                bar.style.left = "-25rem";
            }
        }

        const images = ["images/logo.png",
            "images/logo.jpg",
            "images/logo-2.png"
        ];
        let index = 0;

        setInterval(() => {
            const img = document.getElementById("rotatingImage");
            index = (index + 1) % images.length;
            img.src = images[index];
        }, 4000)

        let minorHeader = document.getElementById("minor-header");

        if (window.innerWidth > 1000) {
            minorHeader.style.display = "none";
        }
    </script>


</body>

</html>