<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
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

    <section class="student-profile">
        <h1 class="heading">All students</h1>

        <div class="box-container">
            <?php
            $select_student = $conn->prepare("SELECT * FROM `users`");
            $select_student->execute();

            if ($select_student->rowCount() > 0) {

                while ($fetch_student = $select_student->fetch(PDO::FETCH_ASSOC)) {

            ?>
                    <div class="box">
                        <div class="student">
                            <img src="../uploaded_files/<?= $fetch_student['image']; ?>" alt="">
                            <div class="students-details">
                                <span><?= $fetch_student['name']; ?></span>
                                <span><?= $fetch_student['email']; ?></span>
                                <span><?= $fetch_student['course']; ?></span>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
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