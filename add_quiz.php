<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}

if (isset($_POST['submit'])) {

    $quiz_id = create_unique_id();
    $quiz_playlist = $_POST['playlist'];
    $serial_no = $_POST['serial_no'];
    $serial_no = filter_var($serial_no, FILTER_SANITIZE_STRING);
    $quiz_playlist = filter_var($quiz_playlist, FILTER_SANITIZE_STRING);
    $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
    $select_playlist->execute([$tutor_id]);
    $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);
    $quiz_question = $_POST['question'];
    $quiz_question = filter_var($quiz_question, FILTER_SANITIZE_STRING);
    $option_a = $_POST['option_a'];
    $option_a = filter_var($option_a, FILTER_SANITIZE_STRING);
    $option_b = $_POST['option_b'];
    $option_b = filter_var($option_b, FILTER_SANITIZE_STRING);
    $option_c = $_POST['option_c'];
    $option_c = filter_var($option_c, FILTER_SANITIZE_STRING);
    $option_d = $_POST['option_d'];
    $option_d = filter_var($option_d, FILTER_SANITIZE_STRING);
    $correct_option = $_POST['correct_option'];
    $correct_option = filter_var($correct_option, FILTER_SANITIZE_STRING);


    $verify_quiz = $conn->prepare("SELECT * FROM `quiz_questions` WHERE question = ?");
    $verify_quiz->execute([$quiz_question]);

    if ($verify_quiz->rowCount() > 0) {
        $message[] = 'quiz already created';
    } else {
        $add_quiz = $conn->prepare("INSERT INTO `quiz_questions`(serial_no, quiz_id, playlist_id, tutor_id, question, option_a, option_b, option_c, option_d, correct_option) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $add_quiz->execute([$serial_no, $quiz_id, $fetch_playlist['id'], $tutor_id, $quiz_question, $option_a, $option_b, $option_c, $option_d, $correct_option]);
        $message[] = 'new quiz created';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add quiz</title>

    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php
    include '../components/admin_header.php';
    ?>


    <section class="crud-form">

        <h1 class="heading">add quiz</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <p>quiz content <span>*</span></p>
            <select name="playlist" class="box" id="" required>
                <option value="" disabled selected>--select playlist</option>
                <?php

                $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
                $select_playlist->execute([$tutor_id]);
                if ($select_playlist->rowCount() > 0) {
                    while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <option value="<?= $fetch_playlist['id'] ?>"><?= $fetch_playlist['title'] ?></option>
                <?php

                    }
                } else {
                    echo '<option value="" disabled>no playlist created yet!</option>';
                }
                ?>
            </select>
            <p>serial no <span>*</span></p>
            <input type="text" class="box" name="serial_no" maxlength="50" placeholder="enter the serial no" required>
            <p>quiz question <span>*</span></p>
            <input type="text" class="box" name="question" maxlength="250" placeholder="enter quiz question" required>
            <p>option a <span>*</span></p>
            <input type="text" class="box" name="option_a" maxlength="250" placeholder="enter option a" required>
            <p>option b <span>*</span></p>
            <input type="text" class="box" name="option_b" maxlength="250" placeholder="enter option b" required>
            <p>option c <span>*</span></p>
            <input type="text" class="box" name="option_c" maxlength="250" placeholder="enter option c" required>
            <p>option d <span>*</span></p>
            <input type="text" class="box" name="option_d" maxlength="250" placeholder="enter option d" required>
            <p>correct option <span>*</span></p>
            <input type="text" class="box" name="correct_option" maxlength="250" placeholder="enter the correct option " required>
            <input type="submit" value="add quiz" class="btn" name="submit">
        </form>
    </section>


    <?php
    include '../components/footer.php';
    ?>

    <script src="../js/admin_script.js"></script>

</body>

</html>