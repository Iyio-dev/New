<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <section class="courses">
        <h1 class="heading">all lectures</h1>

        <div class="box-container">

            <?php
            $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? AND course_id = ? ORDER BY date DESC");
            $select_playlists->execute(['active', $course_id]);
            if ($select_playlists->rowCount() > 0) {
                while ($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)) {
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
            } else {
                echo '<p class="empty">no courses added yet!</p>';
            }
            ?>
        </div>
    </section>









    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>