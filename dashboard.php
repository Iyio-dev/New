<?php
    include 'components/connect.php';

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        $tutor_id = '';
        header('location:login.php');
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">
    

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
    <?php
        include 'components/header.php';
    ?>

    <section class="dashboard">

        <h1 class="heading">dashboard</h1>

        <div class="box-container">

            <div class="box">
                <h3>welcome!</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <p><?= $fetch_profile['email']; ?></p>
            </div>

            <div class="box">
                <h3>referal code</h3>
                <p>refer your friend for rewards</p>
                <p><?= $fetch_profile['id'];?></p>
            </div>
            <div class="box">
                <h3>registered courses</h3>
                <p><?= $fetch_profile['id'];?></p>
            </div>
            <div class="box">
                <h3>certificates earned</h3>
                <p><?= $fetch_profile['id'];?></p>
            </div>
        </div>
    </section>
    
    <section class="course-catalog">
        <h1 class="heading">Our Courses</h1>
        <div class="box-container">
        <?php
        $select_courses = $conn->prepare("SELECT * FROM `courses`");
        $select_courses->execute();
        if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                $course_id = $fetch_course['course_id'];

    ?>
        <div class="box">
            <div class="thumb">
                <img src="uploaded_files/<?= $fetch_course['course_img']; ?>" alt="">
            </div>
            <h3 class="title"><?= $fetch_course['course_name']; ?></h3>
            <span class="details"><?= $fetch_course['course_details'];?></span>
            <div class="flex">
            <span><?= $fetch_course['course_price'];?></span>
            <span><?= $fetch_course['course_duration'];?></span>
            </div>
            <a href="course_register.php?get_id=<?= $course_id; ?>" class="inline-btn">register now</a>
        </div>
    <?php
        }
    }else{
        echo '<p class="empty">no courses added yet!</p>';
    }
    ?>
        </div>
    </section>

    <?php
        include 'components/footer.php';
    ?>

    <script>





    </script>
    <script src="js/script.js"></script>

    
</body>
</html>