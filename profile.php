<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
}

$count_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$count_likes->execute([$user_id]);
$total_likes = $count_likes->rowCount();

$count_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$count_comments->execute([$user_id]);
$total_comments = $count_comments->rowCount();

$count_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$count_bookmark->execute([$user_id]);
$total_bookmark = $count_bookmark->rowCount();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include 'components/user_header.php'; ?>


    <section class="profile">
        <h1 class="heading">profile details</h1>

        <div class="details">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="user">
                    <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                    <h3 style="color: var(--light-color);"><?= $fetch_profile['name']; ?></h3>
                    <p>student</p>
                    <a href="update.php" class="inline-btn">update profile</a>
                </div>
            <?php
            }
            ?>

            <div class="box-container">

                <div class="box">
                    <div class="flex">
                        <i class="fas fa-bookmark"></i>
                        <div>
                            <h3><?= $total_bookmark; ?></h3>
                            <span>saved playlists</span>
                        </div>
                    </div>
                    <a href="bookmark.php" class="inline-btn">view lectures</a>
                </div>

                <div class="box">
                    <div class="flex">
                        <i class="fas fa-heart"></i>
                        <div>
                            <h3><?= $total_likes; ?></h3>
                            <span>liked tutorials</span>
                        </div>
                    </div>
                    <a href="likes.php" class="inline-btn">view liked</a>
                </div>

                <div class="box">
                    <div class="flex">
                        <i class="fas fa-comment"></i>
                        <div>
                            <h3><?= $total_comments ?></h3>
                            <span>video comments</span>
                        </div>
                    </div>
                    <a href="comments.php" class="inline-btn">view comments</a>
                </div>
            </div>
        </div>
    </section>


    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>




























<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">

        <section class="flex">
            <a href="home.html" class="logo">Apex</a>

            <form action="" method="post" class="search-form">
                <input type="text" name="search-box" placeholder="search courses..." required maxlength="100">
                <button type="submit" class="fas fa-search"></button>
            </form>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="search-btn" class="fas fa-search"></div>
                <div id="user-btn" class="fa fa-user"></div>
                <div id="toggle-btn" class="fas fa-sun"></div>
            </div>

            <div class="profile">
                <img src="images/pic-1.jpg">
                <h3>iyiola ajibola</h3>
                <span>student</span>
                <a href="profile.html" class="btn">view profile</a>
                <div class="flex-btn">
                    <a href="login.html" class="option-btn">login</a>
                    <a href="register.html" class="option-btn">register</a>
                </div>
            </div>
        </section>
    </header>


    <div class="side-bar">

        <div class="close-side-bar">
            <i class="fas fa-times"></i>
        </div>

        <div class="profile">
            <img src="images/pic-1.jpg">
            <h3>iyiola ajibola</h3>
            <span>student</span>
            <a href="profile.html" class="btn">view profile</a>
        </div>

        <nav class="navbar">
            <a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
            <a href="about.php"><i class="fas fa-question"></i><span>about us</span></a>
            <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
            <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
            <a href="contact.php"><i class="fas fa-headset"></i><span>contact us</span></a>
        </nav>

    </div>



    


<footer class="footer">
    &copy; copyright @ 2024 by <span>davepet inc</span> | all rights reserved!
</footer>


<script src="js/script.js"></script>

</body>
</html>