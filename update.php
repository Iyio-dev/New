<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $message[] = 'name updated sucessfully';
    }

    if (!empty($email)) {
        $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
        $update_email->execute([$email, $user_id]);
        $message[] = 'email updated sucessfully';
    }

    $prev_image = $fetch_user['image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'uploaded_files/' . $rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'image size is too large';
        } else {
            $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $user_id]);
            $message[] = 'image updated sucessfully';
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($prev_image != '' and $prev_image != $rename) {
                unlink('uploaded_files/' . $prev_image);
            }
        }
    }


    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $fetch_user['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            $message[] = 'old password not matched!';
        } elseif ($new_pass != $c_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass->execute([$c_pass, $user_id]);
                $message[] = 'password updated sucessfully';
            } else {
                $message[] = 'please enter new password';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>

<body>
    <?php include 'components/user_header.php'; ?>



    <section class="form-container">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <form action="" method="post" enctype="multipart/form-data">
                <h3>update profile</h3>
                <div class="flex">
                    <div class="col">
                        <p>your name</p>
                        <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="100" class="box">
                        <p>your email</p>
                        <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="100" class="box">
                        <p>old passsword</p>
                        <input type="password" name="old_pass" placeholder="enter your old password" maxlength="50" class="box">
                    </div>
                    <div class="col">
                        <p>new passsword</p>
                        <input type="password" name="new_pass" placeholder="enter your new password" maxlength="50" class="box">
                        <p>confirm passsword</p>
                        <input type="password" name="c_pass" placeholder="confirm your new password" maxlength="50" class="box">
                        <p>update image</p>
                        <input type="file" name="image" accept="image/*" class="box">
                    </div>
                </div>
                <input type="submit" name="submit" value="update profile" class="btn">
            </form>
    </section>
<?php
        }
?>





<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>

</html>