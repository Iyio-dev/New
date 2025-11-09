<?php

$db_name = 'mysql:host=localhost;dbname=apex_tutors_db';
$db_user_name = 'root';
$db_user_pass = '';

$conn = new PDO($db_name, $db_user_name, $db_user_pass);

function create_unique_id()
{
    // $str = 'abcdefghijklmnopqrstuvwxyzABXDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    //$rand = array();
    //$length = strlen($str) - 1;
    //for($i = 0; $i < 20; $i++){
    $n = mt_rand(0, 2000000);
    //$rand = $str($n);

    //   }
    return $n;
}
