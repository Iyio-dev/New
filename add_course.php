<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}

if (isset($_POST['submit'])) {

    $course_id = create_unique_id();
    $course_name = $_POST['course_name'];
    $course_name = filter_var($course_name, FILTER_SANITIZE_STRING);
    $course_details = $_POST['course_details'];
    $course_details = filter_var($course_details, FILTER_SANITIZE_STRING);
    $course_price = $_POST['course_price'];
    $course_price = filter_var($course_price, FILTER_SANITIZE_STRING);
    $course_duration = $_POST['course_duration'];
    $course_duration = filter_var($course_duration, FILTER_SANITIZE_STRING);

    $course_img = $_FILES['course_img']['name'];
    $course_img = filter_var($course_img, FILTER_SANITIZE_STRING);
    $course_img_ext = pathinfo($course_img, PATHINFO_EXTENSION);
    $rename_course_img = create_unique_id() . '.' . $course_img_ext;
    $course_img_tmp_name = $_FILES['course_img']['tmp_name'];
    $course_img_size = $_FILES['course_img']['size'];
    $course_img_folder = '../uploaded_files/' . $rename_course_img;

    $verify_course = $conn->prepare("SELECT * FROM `courses` WHERE course_name = ?");
    $verify_course->execute([$course_name]);

    if ($verify_course->rowCount() > 0) {
        $message[] = 'course already created';
    } else {
        if ($course_img_size > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $add_course = $conn->prepare("INSERT INTO `courses`(course_id, course_name, course_details, course_img, course_price, course_duration) VALUES(?,?,?,?,?,?)");
            $add_course->execute([$course_id, $course_name, $course_details, $rename_course_img, $course_price, $course_duration]);
            move_uploaded_file($course_img_tmp_name, $course_img_folder);
            $message[] = 'new course created';
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add course</title>

    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php
    include '../components/admin_header.php';
    ?>


    <section class="crud-form">

        <h1 class="heading">add content</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <p>course name <span>*</span></p>
            <input type="text" class="box" name="course_name" maxlength="250" placeholder="enter course name" required>
            <p>course details <span>*</span></p>
            <textarea name="course_details" class="box" cols="30" required placeholder="enter course details" maxlength="1000" rows="10" id=""></textarea>
            <p>course image <span>*</span></p>
            <input type="file" name="course_img" class="box" required accept="image/*">
            <p>course price <span>*</span></p>
            <input type="text" class="box" name="course_price" maxlength="250" placeholder="enter course price" required>
            <p>course duration <span>*</span></p>
            <input type="text" class="box" name="course_duration" maxlength="250" placeholder="enter course duration" required>
            <input type="submit" value="add course" class="btn" name="submit">
        </form>
    </section>


    <?php
    include '../components/footer.php';
    ?>

    <script src="../js/admin_script.js"></script>

</body>

</html>