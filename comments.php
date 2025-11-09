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
    <title>Comments</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <section class="comments">
        <h1 class="heading">user comments</h1>

        <div class="box-container">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
            $select_comments->execute([$user_id]);
            if ($select_comments->rowCount() > 0) {
                while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    $comment_id = $fetch_comment['id'];
                    $select_commentor = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_commentor->execute([$user_id]);
                    $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);

                    $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
                    $select_content->execute([$fetch_comment['content_id']]);
                    $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
            ?>
                    <div class="box">
                        <div class="comment-content">
                            <p><?= $fetch_content['title']; ?></p><a href="watch_video.php?get_id=<?= $fetch_content['id'] ?>" class="inline-btn">view content</a>
                        </div>
                        <div class="user">
                            <img src="uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
                            <div>
                                <h3><?= $fetch_commentor['name']; ?></h3>
                                <span><?= $fetch_comment['date']; ?></span>
                            </div>
                        </div>
                        <p class="comment-box"><?= $fetch_comment['comment']; ?></p>
                        <?php if ($fetch_comment['user_id'] = $user_id) {
                        ?>
                            <form action="" method="post">
                                <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                                <input type="submit" value="update comment" class="inline-option-btn" name="update_comment">
                                <input type="submit" value="delete comment" class="inline-delete-btn" name="delete_comment">
                            </form>
                        <?php } ?>
                    </div>

            <?php
                }
            } else {
                echo '<p class="empty">no comments added yet!</p>';
            }

            ?>
        </div>
    </section>






    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>