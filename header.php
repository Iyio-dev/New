<?php
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:../login.php');
}
$db_name = 'mysql:host=localhost;dbname=apex_tutors_db';
$db_user_name = 'root';
$db_user_pass = '';

$conn = new PDO($db_name, $db_user_name, $db_user_pass);

//$confirm_unsubscribed_user = $conn->prepare("SELECT * FROM `users` WHERE active = ? AND id = ?");
//$confirm_unsubscribed_user->execute(['deactive', $user_id]);
//$fetch_unsubscribed_user_id = $confirm_unsubscribed_user->fetch();
//$unsubscribed_user_id = $fetch_unsubscribed_user_id['id']; 

//if($unsubscribed_user_id == $user_id){
//header('location:unsubscribed.php');
// }


if (isset($_POST['home'])) {
    $course_id = $_POST['courseID'];
    setcookie('course_id', $course_id, time() + 60 * 60 * 24 * 30, '/');
    header('location:home.php');
}

?>

<?php

if (isset($message)) {
    foreach ($message as $message) {
        echo '
                <div class="message">
                    <span>' . $message . '</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
            
            ';
    }
}
?>
<style>
    div form input {
        background: transparent;
        color: var(--light-color);
        font-size: 17px;
        cursor: pointer;
    }
</style>

<header class="header">


    <section class="flex">

        <a href="home.php" class="logo">Apex</a>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <img src="uploaded_files/<?= $fetch_profile['image'] ?>" alt="">
                <h3><?= $fetch_profile['name']; ?></h3>
                <span><?= $fetch_profile['course'] ?></span>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
                <a href="components/user_logout.php" onclick="return confirm('logout from this page')" class="delete-btn">logout</a>
            <?php
            } else {

            ?>
                <h3>please login first</h3>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
</header>

<div class="side-bar">

    <div class="close-side-bar">
        <i class="fa fa-times">x</i>
    </div>
    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <img src="uploaded_files/<?= $fetch_profile['image'] ?>" alt="">
            <h3><?= $fetch_profile['name']; ?></h3>
            <span><?= $fetch_profile['course'] ?></span>
            <a class="btn" id="dropDownBtn">registered courses</a>
        <?php
        } else {
            header('location:login.php')
        ?>
            <h3>please login first</h3>
            <div class="flex-btn">
                <a href="login.php" class="option-btn">login</a>
                <a href="register.php" class="option-btn">register</a>
            </div>
        <?php
        }
        ?>
        <form method="post" class="navbar">
            <?php
            $select_course_id = $conn->prepare("SELECT * FROM `course_registration` WHERE user_id = ?");
            $select_course_id->execute([$user_id]);

            if ($select_course_id->rowCount() > 0) {
                while ($fetch_course_id = $select_course_id->fetch(PDO::FETCH_ASSOC)) {
                    $select_course = $conn->prepare("SELECT * FROM `courses` WHERE course_id = ?");
                    $select_course->execute([$fetch_course_id['course_id']]);
                    $fetch_course = $select_course->fetch(PDO::FETCH_ASSOC);
            ?>
                    <div style="padding-top: 20px;">
                        <form action="" method="post">
                            <input type="hidden" name="courseID" value="<?= $fetch_course['course_id']; ?>">
                            <input name="home" type="submit" value="<?= $fetch_course['course_name']; ?>"></input>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<span>no course registerd yet</span>";
            }

            ?>
        </form>
    </div>

</div>