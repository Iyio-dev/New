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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include 'components/user_header.php'; ?>


    <section class="videos-container">
        <h1 class="heading">Quiz Section</h1>

        <div class="box-container quiz">

            <?php
            $select_quiz = $conn->prepare("SELECT * FROM `quiz_questions` WHERE quiz_id = ?");
            $select_quiz->execute([$get_id]);
            if ($select_quiz->rowCount() > 0) {
                while ($fetch_quiz = $select_quiz->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box quizzes">
                        <div class="question">
                            <p class="question"><?= $fetch_quiz['question'] ?></p>
                        </div>
                        <div class="option">
                            <div>
                                <label for="answer"><?= $fetch_quiz['option_a'] ?>
                                </label>
                                <input id="answer" type="radio" name="answer" value="a">
                            </div>
                            <div class="option">
                                <input id="answer" type="radio" name="answer" value="b"><label for="answer"><?= $fetch_quiz['option_b'] ?></label>
                            </div>
                            <div class="option">
                                <input id="answer" type="radio" name="answer" value="c"><label for="answer"><?= $fetch_quiz['option_c'] ?></label>
                            </div>
                            <div class="option">
                                <input id="answer" type="radio" name="answer" value="d"><label for="answer"><?= $fetch_quiz['option_d'] ?></label>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no contents found</p>';
            }
            ?>
        </div>
        <div class="box">
            <?php
            $select_quiz = $conn->prepare("SELECT * FROM `quiz_questions` WHERE quiz_id = ?");
            $select_quiz->execute([$get_id]);
            if ($select_quiz->rowCount() > 0) {
                while ($fetch_quiz = $select_quiz->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div>
                        <?= $fetch_quiz['serial_no']; ?>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </section>


    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>