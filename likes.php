<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>liked videos</title>

    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>
    <?php include 'components/user_header.php';?>

    <section class="contents">

        <h1 class="heading">liked videos</h1>

        <div class="box-container">
            <?php
                $select_liked_content = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
                $select_liked_content->execute([$user_id]);
                if($select_liked_content->rowCount() > 0){
                    while($fetch_liked_content = $select_liked_content->fetch(PDO::FETCH_ASSOC)){

                        $select_contents = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
                        $select_contents->execute([$fetch_liked_content['content_id']]);
                        $fetch_contents = $select_contents->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box">
                <div class="flex">
                    <p><i class="fas fa-circle-dot" style="color:<?php if($fetch_contents['status'] == 'active'){echo 'limegreen';}else{echo 'red';}?>;"></i><span style="color:<?php if($fetch_contents['status'] == 'active'){echo 'limegreen';}else{echo 'red';}?>;"><?=$fetch_contents['status']?></span></p>
                    <p><i class="fas fa-calendar"></i><span><?= $fetch_contents['date']?></span></p>
                </div>
                    <img src="uploaded_files/<?= $fetch_contents['thumb']?>" alt="">
                    <h3 class="title"><?= $fetch_contents['title']; ?></h3>
                    <a href="watch_video.php?get_id=<?= $fetch_contents['id']; ?>" class="btn">view content</a>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">you have not liked any content</p>';
                }
            ?>
        </div>
    </section>
    
    <?php include 'components/footer.php';?>

<script src="js/script.js"></script>
</body>
</html>
