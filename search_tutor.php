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
    <title>Contact Us</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
    <?php include 'components/user_header.php';?>

    <section class="teachers">

        <h1 class="heading">search results</h1>

        <form action="search_tutor.php" method="post" class="search-tutor">
            <input type="text" name="search_tutor_box" placeholder="search tutors" required>
            <button type="submit" name="search_tutor_btn" class="fa fa-search"></button>
        </form>

        <div class="box-container">

        <?php
        if(isset($_POST['search_tutor_box']) or isset($_POST['search_tutor_btn'])){
            $search_tutor = $_POST['search_tutor_box'];
            $select_tutors = $conn->prepare("SELECT * FROM `tutors` WHERE NAME LIKE '%{$search_tutor}%' OR profession LIKE '%{$search_tutor}%'");
            $select_tutors->execute();
            if($select_tutors->rowCount() > 0){

                while($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)){
                    $tutor_id = $fetch_tutor['id'];

                    $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
                    $count_likes->execute([$tutor_id]);
                    $total_likes = $count_likes->rowCount();

                    $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
                    $count_comments->execute([$tutor_id]);
                    $total_comments = $count_comments->rowCount();

                    $count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
                    $count_content->execute([$tutor_id]);
                    $total_content = $count_content->rowCount();

                    $count_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
                    $count_playlist->execute([$tutor_id]);
                    $total_playlist = $count_playlist->rowCount();
        ?>
        <div class="box">
            <div class="tutor">
                <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                <div>
                    <h3><?= $fetch_tutor['name']; ?></h3>
                    <span><?= $fetch_tutor['profession']; ?></span>
                </div>
            </div>
            <p>total videos : <span><?= $total_content; ?></span></p>
            <p>total courses : <span><?= $total_playlist; ?></span></p>
            <p>total likes : <span><?= $total_likes; ?></span></p>
            <p>total comments : <span><?=$total_comments; ?></span></p>
            <a href="tutor_profile.php?get_id=<?= $fetch_tutor['email']; ?>" class="inline-btn">view profile</a>
        </div>
        <?php
                }
            }else{
                echo '<p class="empty">tutors were not found</p>';
            }
        }else{
            echo '<p class="empty">search something</p>';
        }
        ?>

        </div>
</section>

    <?php include 'components/footer.php';?>

<script src="js/script.js"></script>
</body>
</html>

