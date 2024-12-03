<?php

$conMysql = mysqli_connect($_ENV["AZURE_MYSQL_HOST"],$_ENV["AZURE_MYSQL_USERNAME"], $_ENV["AZURE_MYSQL_PASSWORD"],$_ENV["AZURE_MYSQL_DBNAME"]);
if (!$conMysql) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}



mysqli_set_charset($conMysql, 'utf8');