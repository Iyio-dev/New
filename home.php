<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
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
    <title>Home</title>

    
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
    <?php include 'components/user_header.php';?>

<section class="quick-select">
    <h1 class="heading">quick options</h1>

    <div class="box-container">

        <?php if($user_id != ''){?>
            <div class="box">
                <h3 class="title">likes and comments</h3>
                <p>total likes : <span><?= $total_likes; ?></span></p>
                <a href="likes.php" class="inline-btn">view likes</a>
                <p>total comments : <span><?= $total_comments; ?></span></p>
                <a href="comments.php" class="inline-btn">view comments</a>
            </div>
        <?php }else{  header('location:login.php')?>
            <div class="box">
                <h3 class="title">login or register</h3>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
            </div>    
        <?php } ?>

        <div class="box">
                <h3 class="title">top categories</h3>
                <div class="flex">
                    <a href=""><i class="fas fa-code"></i><span>web development</span></a>
                    <a href=""><i class="fas fa-code"></i><span>web development</span></a>
                    <a href=""><i class="fas fa-code"></i><span>java basics</span></a>
                    <a href=""><i class="fas fa-code"></i><span>python basics</span></a>
                    <a href=""><i class="fas fa-code"></i><span>app development</span></a>
                    <a href=""><i class="fas fa-code"></i><span>machine learning/data science</span></a>
                </div>
            </div>

            <div class="box">
                <h3 class="title">popular topics</h3>
                <div class="flex">
                    <a href=""><i class="fab fa-html5"></i><span>HTML</span></a>
                    <a href=""><i class="fab fa-css3"></i><span>CSS</span></a>
                    <a href=""><i class="fab fa-js"></i><span>Javascript</span></a>
                    <a href=""><i class="fab fa-flutter"></i><span>Flutter</span></a>
                    <a href=""><i class="fab fa-html5"></i><span>PHP</span></a>
                    <a href=""><i class="fab fa-html5"></i><span>PYTHON</span></a>
                </div>
            </div>
        </div>
</section>

<section class="courses">
    <h1 class="heading">lastest lectures</h1>

    <div class="box-container">

    <?php
        $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? AND course_id = ? ORDER BY date DESC LIMIT 9");
        $select_playlists->execute(['active', $course_id]);
        if($select_playlists->rowCount() > 0){
            while($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)){
                $playlist_id = $fetch_playlist['id'];

                $count_playlist = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ?");
                $count_playlist->execute([$playlist_id, 'active']);
                $total_playlists = $count_playlist->rowCount();

                $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                $select_tutor->execute([$fetch_playlist['tutor_id']]);
                $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

    ?>
        <div class="box">
            <div class="tutor">
                <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                <div>
                <h3><?= $fetch_tutor['name']; ?></h3>
                <span><?= $fetch_playlist['date']; ?></span>
                </div>   
            </div>
            <div class="thumb">
                <span><?= $total_playlists; ?></span>
                <img src="uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
            </div>
            <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
            <a href="playlist.php?get_id=<?= $playlist_id; ?>" class="inline-btn">view playlist</a>
        </div>
    <?php
        }
    }else{
        echo '<p class="empty">no courses added yet!</p>';
    }
    ?>
    </div>
    <div style="margin-top: 2rem; text-align:center;">
        <a href="courses.php" class="inline-option-btn">view all</a>
    </div>
</section>









    <?php include 'components/footer.php';?>

<script src="js/script.js"></script>
</body>
</html>







































































<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

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



    <section class="quick-select">
        <h1 class="heading">quick options</h1>

        <div class="box-container">
            <div class="box">
                <h3 class="title">likes and comments</h3>
                <p>total likes : <span>14</span></p>
                <a href="#" class="inline-btn">view likes</a>
                <p>total comments : <span>5</span></p>
                <a href="#" class="inline-btn">view comments</a>
                <p>saved playlists : <span>14</span></p>
                <a href="#" class="inline-btn">view playlists</a>
            </div>

            <div class="box">
                <h3 class="title">top categories</h3>
                <div class="flex">
                    <a href=""><i class="fas fa-code"></i><span>web development</span></a>
                    <a href=""><i class="fas fa-code"></i><span>web development</span></a>
                    <a href=""><i class="fas fa-code"></i><span>java basics</span></a>
                    <a href=""><i class="fas fa-code"></i><span>python basics</span></a>
                    <a href=""><i class="fas fa-code"></i><span>app development</span></a>
                    <a href=""><i class="fas fa-code"></i><span>machine learning/data science</span></a>
                </div>
            </div>

            <div class="box">
                <h3 class="title">popular topics</h3>
                <div class="flex">
                    <a href=""><i class="fab fa-html5"></i><span>HTML</span></a>
                    <a href=""><i class="fab fa-css3"></i><span>CSS</span></a>
                    <a href=""><i class="fab fa-js"></i><span>Javascript</span></a>
                    <a href=""><i class="fab fa-flutter"></i><span>Flutter</span></a>
                    <a href=""><i class="fab fa-html5"></i><span>PHP</span></a>
                    <a href=""><i class="fab fa-html5"></i><span>PYTHON</span></a>
                </div>
            </div>


            <div class="box tutor">
                <h3 class="title">become a tutor</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Temporibus, tenetur ducimus? Eum consectetur quas error reiciendis doloremque repellendus earum, ex nemo corrupti, nostrum debitis quaerat fugiat repudiandae facere officia cupiditate.</p>
                <a href="register.html" class="inline-btn">get started</a>
            </div>
        </div>
    </section>


    <section class="courses">
        <h1 class="heading">our courses</h1>

        <div class="box-container">
            <div class="box">
                <div class="tutor">
                    <img src="images/pic-1.jpg">
                    <div>
                        <h3>iyiola ajibola</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <img src="images/thumb-1.png" class="thumb">
                <h3 class="title">complete HTML tutorial</h3>
                <a href="playlist.html" class="inline-btn">view playlist</a>
            </div>

            <div class="box">
                <div class="tutor">
                    <img src="images/pic-1.jpg">
                    <div>
                        <h3>iyiola ajibola</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <img src="images/thumb-1.png" class="thumb">
                <h3 class="title">complete CSS tutorial</h3>
                <a href="playlist.html" class="inline-btn">view playlist</a>
            </div>

            <div class="box">
                <div class="tutor">
                    <img src="images/pic-1.jpg">
                    <div>
                        <h3>iyiola ajibola</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <img src="images/thumb-1.png" class="thumb">
                <h3 class="title">complete JS tutorial</h3>
                <a href="playlist.html" class="inline-btn">view playlist</a>
            </div>

            <div class="box">
                <div class="tutor">
                    <img src="images/pic-1.jpg">
                    <div>
                        <h3>iyiola ajibola</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <img src="images/thumb-1.png" class="thumb">
                <h3 class="title">complete Flutter tutorial</h3>
                <a href="playlist.html" class="inline-btn">view playlist</a>
            </div>

            <div class="box">
                <div class="tutor">
                    <img src="images/pic-1.jpg">
                    <div>
                        <h3>iyiola ajibola</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <img src="images/thumb-1.png" class="thumb">
                <h3 class="title">complete JAVA tutorial</h3>
                <a href="playlist.html" class="inline-btn">view playlist</a>
            </div>

            <div class="box">
                <div class="tutor">
                    <img src="images/pic-1.jpg">
                    <div>
                        <h3>iyiola ajibola</h3>
                        <span>21-25-2022</span>
                    </div>
                </div>
                <img src="images/thumb-1.png" class="thumb">
                <h3 class="title">complete PYTHON tutorial</h3>
                <a href="playlist.html" class="inline-btn">view playlist</a>
            </div>

            

        </div>

        <div class="more-btn">
            <a href="courses.html" class="inline-option-btn">view more</a>
        </div>
    </section>








    <footer class="footer">
        &copy; copyright @ 2024 by <span>davepet inc</span> | all rights reserved!
    </footer>


    <script src="js/script.js"></script>

</body>
</html>
--->