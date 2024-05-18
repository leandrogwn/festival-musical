<?php

$conMysql = mysqli_connect('localhost','ibtech31_music_user', 'music_pass_festival','ibtech31_music_festival');
if (!$conMysql) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}



mysqli_set_charset($conMysql, 'utf8');