<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:playlist.php');
}

if (isset($_POST['delete_content'])) {

    $delete_id = $_POST['content_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_content = $conn->prepare("SELECT * FROM `content` WHERE id  = ?");
    $verify_content->execute([$delete_id]);

    if ($verify_content->rowCount() > 0) {
        $fetch_content = $verify_content->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/' . $fetch_content['thumb']);
        unlink('../uploaded_files/' . $fetch_content['video']);
        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
        $delete_comment->execute([$delete_id]);
        $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE id = ?");
        $delete_likes->execute([$delete_id]);
        $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
        $delete_content->execute([$delete_id]);
        header('location:contents.php');
    } else {
        $message[] = 'content already deleted';
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

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ? AND tutor_id = ? AND comment = ?");
    $verify_comment->execute([$get_id, $content_tutor_id, $comment_box]);
    $count_comment = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ?");
    $count_comment = $count_comment->rowCount();

    if ($verify_comment->rowCount() > 0) {
        $message[] = 'comment already added';
    } else {
        $add_comment = $conn->prepare("INSERT INTO `comments`(id, content_id, user_id, tutor_id, comment) VALUES(?,?,?,?,?)");
        $add_comment->execute([$comments_id, $get_id, 'comment from tutor', $content_tutor_id, $comment_box]);
        $message[] = 'comment added sucessfully';
    }
}


if (isset($_POST['delete_comment'])) {
    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_conmment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
    $verify_conmment->execute([$delete_id]);

    if ($verify_conmment->rowCount() > 0) {
        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
        $delete_comment->execute([$delete_id]);
        $message[] = 'comment deleted sucessfully';
    } else {
        $message[] = 'comment already deleted';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php
    include '../components/admin_header.php';
    ?>

    <section class="view-content">

        <?php
        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
        $select_content->execute([$get_id]);
        if ($select_content->rowCount() > 0) {
            while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                $content_id = $fetch_content['id'];

                $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ? AND content_id = ?");
                $count_likes->execute([$tutor_id, $content_id]);
                $total_likes = $count_likes->rowCount();

                $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ? AND content_id = ?");
                $count_comments->execute([$tutor_id, $content_id]);
                $total_comments = $count_comments->rowCount();

        ?>
                <div class="content">
                    <video src="../uploaded_files/<?= $fetch_content['video']; ?>" poster="../uploaded_files/<?= $fetch_content['thumb']; ?>" controls autoplay></video>
                    <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></div>
                    <h3 class="title"><?= $fetch_content['title']; ?></h3>
                    <div class="flex">
                        <div><i class="fas fa-heart"></i><span><?= $total_likes; ?></span></div>
                        <div><i class="fas fa-comment"></i><span><?= $total_comments; ?></span></div>
                    </div>
                    <p class="description"><?= $fetch_content['description']; ?></p>
                    <form action="" method="post" class="flex-btn">
                        <input type="hidden" name="content_id" value="<?= $content_id; ?>">
                        <input type="submit" value="delete content" name="delete_content" class="delete-btn">
                        <a href="update_content.php?get_id=<?= $content_id; ?>" class="option-btn">update content</a>
                    </form>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">content was not found!</p>';
        }
        ?>

    </section>

    <section class="comment-form">

        <h1 class="heading">add comment</h1>

        <form action="" method="post">
            <textarea name="comment_box" class="box" id="" required maxlength="1000" placeholder="enter your comment" cols="30" rows="10"></textarea>
            <input type="submit" class="inline-btn" value="add comment" name="add_comment">
        </form>

    </section>

    <section class="comments">
        <h1 class="heading">user comments</h1>

        <div class="box-container">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ? AND tutor_id = ?");
            $select_comments->execute([$get_id, $tutor_id]);
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
                                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                            <?php
                            } else {
                            ?>
                                <img src="../uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
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
                        <form action="" method="post">
                            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                            <input type="submit" value="delete comment" class="inline-delete-btn" name="delete_comment">
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

    <?php
    include '../components/footer.php';
    ?>

    <script src="../js/admin_script.js"></script>

</body>

</html>