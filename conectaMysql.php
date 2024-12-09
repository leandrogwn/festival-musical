<?php
class conectaMysql {
    private $con;

    public function __construct() {
        // Parâmetros de conexão com o banco de dados
        $host = $_ENV['AZURE_MYSQL_HOST'];
        $username = $_ENV['AZURE_MYSQL_USERNAME'];
        $password = $_ENV['AZURE_MYSQL_PASSWORD'];
        $dbname = $_ENV['AZURE_MYSQL_DBNAME'];
        $port = $_ENV['AZURE_MYSQL_PORT'];

        // Configurando a conexão PDO
        $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8";
        try {
            $this->con = new PDO($dsn, $username, $password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }

    // Método para preparar e retornar a consulta
    public function prepare($sql) {
        return $this->con->prepare($sql);
    }

    // Método para fechar a conexão
    public function close() {
        $this->con = null;
    }
}

?>