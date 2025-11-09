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
    header('location:courses.php');
    exit();
}
if (isset($_POST['like_content'])) {

    if ($user_id != '') {
        $like_id = $_POST['content_id'];
        $like_id = filter_var($like_id, FILTER_SANITIZE_STRING);

        $get_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
        $get_content->execute([$like_id]);
        $fetch_get_content = $get_content->fetch(PDO::FETCH_ASSOC);

        $tutor_id = $fetch_get_content['tutor_id'];

        $verify_like = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
        $verify_like->execute([$user_id, $like_id]);

        if ($verify_like->rowCount() > 0) {
            $remove_likes = $conn->prepare("DELETE FROM `likes` WHERE user_id = ? AND content_id = ?");
            $remove_likes->execute([$user_id, $like_id]);
            $message[] = 'removed from likes!';
        } else {
            $add_likes = $conn->prepare("INSERT INTO `likes` (user_id, tutor_id, content_id) VALUES(?,?,?)");
            $add_likes->execute([$user_id, $tutor_id, $like_id]);
            $message[] = 'added to likes!';
        }
    } else {
        $message[] = 'please login first';
    }
}

if (isset($_POST['add_comment'])) {
    $comments_id = create_unique_id();
    $comment_box = $_POST['comment_box'];
    $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);

    $select_content_tutor = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
    $select_content_tutor->execute([$get_id]);
    $fetch_content_tutor_id = $select_content_tutor->fetch(PDO::FETCH_ASSOC);
    $content_tutor_id = $fetch_content_tutor_id['tutor_id'];

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ? AND user_id = ? AND tutor_id = ? AND comment = ?");
    $verify_comment->execute([$get_id, $user_id, $content_tutor_id, $comment_box]);
    $count_comment = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ?");
    $count_comment = $count_comment->rowCount();

    if ($verify_comment->rowCount() > 0) {
        $message[] = 'comment already added';
    } else {
        $add_comment = $conn->prepare("INSERT INTO `comments`(id, content_id, user_id, tutor_id, comment) VALUES(?,?,?,?,?)");
        $add_comment->execute([$comments_id, $get_id, $user_id, $content_tutor_id, $comment_box]);
        $message[] = 'comment added sucessfully';
    }
}

if (isset($_POST['delete_comment'])) {
    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
    $verify_comment->execute([$delete_id]);

    if ($verify_comment->rowCount() > 0) {
        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
        $delete_comment->execute([$delete_id]);
        $message[] = 'comment deleted sucessfully';
    } else {
        $message[] = 'comment already deleted';
    }
}

if (isset($_POST['update_comment'])) {
    $comment_id = $_POST['comment_id'];
    $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
    $select_update_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
    $select_update_comment->execute([$comment_id]);
    $fetch_update_comment = $select_update_comment->fetch(PDO::FETCH_ASSOC);
    $comment = $fetch_update_comment['comment'];
    $message2[] = $comment;
}

if (isset($_POST['real_update'])) {
    $updated_comment = $_POST['update_comment_box'];
    $update_comment_id = $_POST['real_comment_id'];
    $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
    $update_comment->execute([$updated_comment, $update_comment_id]);
    if ($update_comment) {
        $message[] = 'comment updated sucessfully';
    }
}

if (isset($_POST['reply'])) {
    $reply_id = create_unique_id();
    $reply_text = $_POST['reply_text'];
    $reply_text = filter_var($reply_text, FILTER_SANITIZE_STRING);
    $comment_id = $_POST['comment_id'];
    $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
    $add_reply = $conn->prepare("INSERT INTO `replies`(id, reply_text, comment_id) VALUES(?,?,?)");
    $add_reply->execute([$reply_id, $reply_text, $comment_id]);
    if ($add_reply) {
        $message[] = 'comment replied sucessfully';
    }
}

if (isset($message2)) {
    foreach ($message2 as $message2) {
        echo '
            <div class="message2 form">
                <span>' . $message2 . '</span>
                <form action="" method="post">
                    <textarea name="update_comment_box" class="box" id="" required maxlength="1000" placeholder="update your comment" cols="10" rows="5"></textarea>
                    <div>
                        <input type="hidden" name="real_comment_id" value="' . $comment_id . '">
                        <input type="submit" class="inline-btn" value="update comment" name="real_update">
                        <input type="submit" class="delete-btn" value="cancel update" name="cancel_update">
                    </div>
                </form>
            </div>
        
        ';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Video</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>


    <?php include 'components/user_header.php'; ?>

    <section class="watch-video">

        <?php
        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? AND status = ?");
        $select_content->execute([$get_id, 'active']);
        if ($select_content->rowCount() > 0) {
            while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                $content_id = $fetch_content['id'];

                $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE content_id = ?");
                $select_likes->execute([$content_id]);
                $total_likes = $select_likes->rowCount();

                $user_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
                $user_likes->execute([$user_id, $content_id]);

                $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                $select_tutor->execute([$fetch_content['tutor_id']]);
                $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

        ?>
                <div class="video-details">
                    <video src="uploaded_files/<?= $fetch_content['video']; ?>" poster="uploaded_files/<?= $fetch_content['thumb']; ?>" controls autoplay></video>
                    <h3 class="title"><?= $fetch_content['title']; ?></h3>
                    <div class="info flex">
                        <p><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></p>
                        <p><i class="fas fa-heart"></i><span><?= $total_likes; ?></span></p>
                    </div>
                    <div class="tutor">
                        <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                        <div>
                            <h3><?= $fetch_tutor['name']; ?></h3>
                            <span><?= $fetch_tutor['profession']; ?></span>
                        </div>
                    </div>
                    <form action="" class="flex" method="post">
                        <input type="hidden" name="content_id" value="<?= $content_id; ?>">
                        <a href="playlist.php?get_id=<?= $fetch_content['playlist_id']; ?>" class="btn">view playlist</a>
                        <?php if ($user_likes->rowCount() > 0) { ?>
                            <button type="submit" name="like_content"><i class="fas fa-heart"></i><span>liked</span></button>
                        <?php } else { ?>
                            <button type="submit" name="like_content"><i class="fas fa-heart"></i><span>like</span></button>
                        <?php } ?>
                    </form>
                    <p class="description"><?= $fetch_content['description']; ?></p>

                </div>
        <?php
            }
        } else {
            echo '<p class="empty">no content was found</p>';
        }

        ?>
    </section>

    <section class="comment-form">

        <h1 class="heading">add comment</h1>

        <form action="" method="post">
            <textarea name="comment_box" class="box" id="" required maxlength="1000" placeholder="enter your comment" cols="30" rows="10"></textarea>
            <input type="submit" class="inline-btn" value="add comment" name="add_comment">
        </form>

        <section class="comments">
            <h1 class="heading">user comments</h1>

            <div class="box-container">
                <?php
                $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ?");
                $select_comments->execute([$get_id]);
                if ($select_comments->rowCount() > 0) {
                    while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                        $comment_id = $fetch_comment['user_id'];
                        $select_commentor = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                        $select_commentor->execute([$comment_id]);
                        $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);

                        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
                        $select_content->execute([$fetch_comment['content_id']]);
                        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
                ?>
                        <div class="box">
                            <div class="user">
                                <?php
                                if ($fetch_comment['user_id'] == 'comment from tutor') {
                                ?>
                                    <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                                <?php
                                } else {
                                ?>
                                    <img src="uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
                                <?php
                                }
                                ?>
                                <div>
                                    <?php
                                    if ($fetch_comment['user_id'] == 'comment from tutor') {
                                    ?>
                                        <h3><?= $fetch_profile['name'] ?></h3>
                                    <?php
                                    } else {
                                    ?>
                                        <h3><?= $fetch_commentor['name'] ?></h3>
                                    <?php
                                    }
                                    ?>
                                    <span><?= $fetch_comment['date']; ?></span>
                                </div>
                            </div>
                            <div class="comment-box" style="display: flex;
                                                justify-content: space-between;">
                                <p><?= $fetch_comment['comment']; ?></p>
                                <?php
                                if ($fetch_comment['user_id'] == 'comment from tutor') {
                                ?>
                                    <p style="padding-left: 20px;">Content Tutor</p>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="replies">
                                <form action="" method="post">
                                    <div class="input">
                                        <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                                        <input type="text" name="reply_text" placeholder="reply this comment" class="reply-text">
                                        <input type="submit" value="reply" class="reply-btn" name="reply">
                                    </div>
                                </form>
                            </div>
                            <?php
                                $select_comment_replies = $conn->prepare("SELECT * FROM `replies` WHERE comment_id = ?");
                                $select_comment_replies->execute([$comment_id]);
                                if ($select_comment_replies->rowCount() > 0){
                                    while ($fetch_comment_replies = $select_comment_replies->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <p>viewreplies</p>
                                <?php
                                    }
                                }else{
                                    echo '<p class="empty">no comments added yet!</p>';
                                }
                                ?>
                            <form action="" method="post">
                                <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                                <?php if ($fetch_comment['user_id'] == $user_id) { ?>
                                    <input type="submit" value="update " class="inline-option-btn" name="update_comment">
                                    <input type="submit" value="delete comment" class="inline-delete-btn" name="delete_comment">
                                <?php } else { ?>
                                <?php } ?>
                            </form>
                        </div>

                <?php
                    }
                } else {
                    echo '<p class="empty">no comments added yet!</p>';
                }

                ?>
            </div>
        </section>

    </section>





    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
    <script>
        let update = document.getElementById("update");
        let updateComment = document.getElementById("updateComment");

        updateComment.onclick = () => {
            update.style.display = "block";
        }
    </script>
</body>

</html>