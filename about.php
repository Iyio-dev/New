<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
    <?php include 'components/user_header.php';?>

    <section class="about">

        <div class="row">

            <div class="image">
                <img src="images/about-img.png" alt="">
            </div>

            <div class="content">
                <h3>why choose us?</h3>
                <p>Apex Tutors is an online learning platform offering high-quality courses for tech enthusisasts</p>
                <a href="courses.php" class="inline-btn">our courses</a>
            </div>
        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-graduation-cap"></i>
                <div>
                    <h3>+10</h3>
                    <span>online courses</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3>+25</h3>
                    <span>brilliant students</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-chalkboard-user"></i>
                <div>
                    <h3>+2</h3>
                    <span>expert teachers</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-briefcase"></i>
                <div>
                    <h3>100%</h3>
                    <span>job placement</span>
                </div>
            </div>
        </div>
    </section>

        <section class="reviews">

            <h1 class="heading">student's reviews</h1>

            <div class="box-container">

                <div class="box">
                    <div class="user">
                        <img src="images/pic-1.jpg" alt="">
                        <div>
                            <h3>john deo</h3>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iste numquam perferendis autem eaque ad repellendus pariatur quod architecto reprehenderit. Iste ducimus suscipit excepturi necessitatibus esse incidunt eius ratione tempora.</p>
                </div>
                
                <div class="box">
                    <div class="user">
                        <img src="images/pic-1.jpg" alt="">
                        <div>
                            <h3>john deo</h3>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iste numquam perferendis autem eaque ad repellendus pariatur quod architecto reprehenderit. Iste ducimus suscipit excepturi necessitatibus esse incidunt eius ratione tempora.</p>
                </div>
                
                <div class="box">
                    <div class="user">
                        <img src="images/pic-1.jpg" alt="">
                        <div>
                            <h3>john deo</h3>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iste numquam perferendis autem eaque ad repellendus pariatur quod architecto reprehenderit. Iste ducimus suscipit excepturi necessitatibus esse incidunt eius ratione tempora.</p>
                </div>
                
                <div class="box">
                    <div class="user">
                        <img src="images/pic-1.jpg" alt="">
                        <div>
                            <h3>john deo</h3>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iste numquam perferendis autem eaque ad repellendus pariatur quod architecto reprehenderit. Iste ducimus suscipit excepturi necessitatibus esse incidunt eius ratione tempora.</p>
                </div>
                
                <div class="box">
                    <div class="user">
                        <img src="images/pic-1.jpg" alt="">
                        <div>
                            <h3>john deo</h3>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iste numquam perferendis autem eaque ad repellendus pariatur quod architecto reprehenderit. Iste ducimus suscipit excepturi necessitatibus esse incidunt eius ratione tempora.</p>
                </div>
                
                <div class="box">
                    <div class="user">
                        <img src="images/pic-1.jpg" alt="">
                        <div>
                            <h3>john deo</h3>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas iste numquam perferendis autem eaque ad repellendus pariatur quod architecto reprehenderit. Iste ducimus suscipit excepturi necessitatibus esse incidunt eius ratione tempora.</p>

                </div>
            </div>
        </section>






    <?php include 'components/footer.php';?>

<script src="js/script.js"></script>
</body>
</html>




