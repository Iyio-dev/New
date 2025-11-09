<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}

if (isset($_POST['submit'])) {

    $id = create_unique_id();
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $course = $_POST['course'];
    $course = filter_var($course, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/' . $rename;

    $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ? AND title = ? AND description = ?");
    $verify_playlist->execute([$tutor_id, $title, $description]);

    if ($verify_playlist->rowCount() > 0) {
        $message[] = 'playlist already created';
    } else {
        $add_playlist = $conn->prepare("INSERT INTO `playlist`(id, tutor_id, title, description, course_id, thumb, status) VALUES(?,?,?,?,?,?,?)");
        $add_playlist->execute([$id, $tutor_id, $title, $description, $course, $rename, $status]);
        move_uploaded_file($thumb_tmp_name, $thumb_folder);
        $message[] = 'new playlist created';
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

    <section class="crud-form">

        <h1 class="heading">add playlist</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <p>plalyist status <span>*</span></p>
            <select name="status" required id="" class="box">
                <option value="active">active</option>
                <option value="deactive">deactive</option>
            </select>
            <p>playlist title <span>*</span></p>
            <input type="text" class="box" name="title" maxlength="100" placeholder="enter playlist title" required>
            <p>playlist description <span>*</span></p>
            <textarea name="description" class="box" cols="30" required placeholder="enter playlist description" maxlength="1000" rows="10" id=""></textarea>
            <p>select course <span>*</span></p>
            <select name="course" class="box">
                <option value="" disabled selected>-- select playlist course</option>
                <option value="1679046">Front-end Web Development
                </option>
                <option value="1526628">Back-end web development</option>
                <option value="795124">Data Analytics</option>
                <option value="746294">Data Science</option>
            </select>
            <p>playlist thumbnail <span>*</span></p>
            <input type="file" name="thumb" class="box" required accept="image/*">
            <input type="submit" value="create playlist" class="btn" name="submit">
        </form>
    </section>



    <?php
    include '../components/footer.php';
    ?>

    <script src="../js/admin_script.js"></script>

</body>

</html>