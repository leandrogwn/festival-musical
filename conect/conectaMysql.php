<?php

$sslCertPath = '/home/site/wwwroot/DigiCertGlobalRootCA.crt.pem'; 

// Parâmetros de conexão com o MySQL
$host = $_ENV["AZURE_MYSQL_HOST"];
$username = $_ENV["AZURE_MYSQL_USERNAME"];
$password = $_ENV["AZURE_MYSQL_PASSWORD"];
$dbname = $_ENV["AZURE_MYSQL_DBNAME"];

// Configurando a conexão MySQL com SSL
$conMysql = mysqli_init(); // Inicializando a conexão
mysqli_ssl_set($conMysql, NULL, NULL, $sslCertPath, NULL, NULL); 
mysqli_real_connect($conMysql, $host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    // Caso haja erro na conexão, exibe uma mensagem
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// Configurando o charset para utf8
mysqli_set_charset($conMysql, 'utf8');

// Agora você pode usar $conMysql para realizar consultas no banco de dados
echo "Conexão estabelecida com sucesso!";

?>
