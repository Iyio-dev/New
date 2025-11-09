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
    header('location:teachers.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Profile</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <section class="tutor-profile">
        <?php

        $verify_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
        $verify_tutor->execute([$get_id]);

        if ($verify_tutor->rowCount() > 0) {
            while ($fetch_tutor = $verify_tutor->fetch(PDO::FETCH_ASSOC)) {
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
                <h1 class="heading">profile details</h1>

                <div class="details">
                    <div class="tutor">
                        <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                        <h3><?= $fetch_tutor['name']; ?></h3>
                        <p><?= $fetch_tutor['email']; ?></p>
                        <span><?= $fetch_tutor['profession']; ?></span>
                    </div>
                    <div class="flex">
                        <p>total videos : <span><?= $total_content; ?></span></p>
                        <p>total courses : <span><?= $total_playlist; ?></span></p>
                        <p>total likes : <span><?= $total_likes; ?></span></p>
                        <p>total comments : <span><?= $total_comments; ?></span></p>
                    </div>
                </div>
        <?php

            }
        } else {
            echo '<p class="empty">tuor does not exist</p>';
        }

        ?>
    </section>

    <section class="courses">
        <h1 class="heading">tutor's courses</h1>
        <div class="box-container">

            <?php

            $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
            $select_tutor->execute([$get_id]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

            $tutor_id = $fetch_tutor['id'];

            $select_tutor_contents = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
            $select_tutor_contents->execute([$tutor_id]);

            if ($select_tutor_contents->rowCount() > 0) {
                while ($fetch_tutor_contents = $select_tutor_contents->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <div class="thumb"><img src="uploaded_files/<?= $fetch_tutor_contents['thumb']; ?>" class="thumb"></div>
                        <h3 class="title" style="color: var(--light-color);"><?= $fetch_tutor_contents['title']; ?></h3>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no content uploaded yet</p>';
            }
            ?>
        </div>
    </section>


    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>