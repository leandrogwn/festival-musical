<?php

$sslCertPath = '/home/site/wwwroot/DigiCertGlobalRootCA.crt.pem'; 

// Parâmetros de conexão com o MySQL a partir das variáveis de ambiente
$host = $_ENV["AZURE_MYSQL_HOST"];
$username = $_ENV["AZURE_MYSQL_USERNAME"];
$password = $_ENV["AZURE_MYSQL_PASSWORD"];
$dbname = $_ENV["AZURE_MYSQL_DBNAME"];

// Verificando se as variáveis de ambiente estão configuradas corretamente
if (empty($host) || empty($username) || empty($password) || empty($dbname)) {
    die("Missing environment variables.");
}

// Inicializando a conexão MySQL
$conMysql = mysqli_init();

// Configurando o SSL
mysqli_ssl_set($conMysql, NULL, NULL, $sslCertPath, NULL, NULL);

// Tentando realizar a conexão
if (!mysqli_real_connect($conMysql, $host, $username, $password, $dbname)) {
    // Logando o erro em vez de exibir no navegador
    error_log("MySQL Connection Error: " . mysqli_connect_error());
    echo "Error: Unable to connect to the database." . PHP_EOL;
    exit;
}

// Configurando o charset para UTF-8
mysqli_set_charset($conMysql, 'utf8');

?>