<?php
define('DB_CHARSET', 'utf8');

$conMysql = mysqli_connect('127.0.0.1','root', 'root','music-festival');
if (!$conMysql) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


// para a conexão com o MySQL
mysqli_set_charset($conMysql, 'utf8');