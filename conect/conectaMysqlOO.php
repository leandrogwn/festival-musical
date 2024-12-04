<?php

class conectaMysql
{
    private static $host = 'mydemoserver.mysql.database.azure.com';
    private static $port = 3306;
    private static $dbname = 'databasename';
    private static $user = 'myadmin';
    private static $password = 'yourpassword';
    private static $sslCertPath = '/home/site/wwwroot/DigiCertGlobalRootCA.crt.pem';  

    private $pdo;

    /* Conectar ao MySQL com PDO e SSL */
    public function connect()
    {
        try {
            // Configurações de SSL
            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => self::$sslCertPath,  
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, 
            );

            // Criando a conexão PDO com SSL
            $this->pdo = new PDO(
                'mysql:host=' . self::$host . ';port=' . self::$port . ';dbname=' . self::$dbname,
                self::$user,
                self::$password,
                $options
            );

            // Definir o charset
            $this->pdo->exec("set names utf8");

        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }

        return $this->pdo;
    }

    /* Desconectar do banco de dados */
    public function disconnect()
    {
        $this->pdo = null;
    }
}

    /* Método insert que insere valores no banco de dados e retorna o último id inserido */

    public function insertDB($sql, $params = null, $tela, $caminho)
    {
        try {
            $conexao = $this->connect();
            $query = $conexao->prepare($sql);
            $query->execute($params);

            $_SESSION[$tela] = "sucess";
            echo "<script>location.replace (\"$caminho\");</script>";

        } catch (PDOException $exc) {
            $_SESSION[$tela] = "erro";
            echo "<script>location.replace (\"$caminho\");</script>";

        }
        self::__destruct();
    }

    /* Método insert que insere notas no banco de dados e retorna o último id inserido */

    public function insertDBNota($sql, $params = null, $tela, $caminho)
    {
        try {
            $conexao = $this->connect();
            $query = $conexao->prepare($sql);
            $query->execute($params);
            $_SESSION[$tela] = "sucess";
            echo "<script>location.replace (\"$caminho\");</script>";

        } catch (PDOException $exc) {
            $_SESSION[$tela] = "erro";
            echo "<script>location.replace (\"$caminho\");</script>";

        }
        self::__destruct();
    }

    /* Método insert que insere valores no banco de dados e retorna o último id inserido */

    public function insertDBInscricao($sql, $params = null, $tela, $caminho)
    {
            $conexao = $this->connect();
            $query = $conexao->prepare($sql);
            $query->execute($params);
            $_SESSION[$tela] = "sucess";
        echo "<script>location.replace (\"$caminho\");</script>";

        self::__destruct();
    }
    
    /* Método update que altera valores do banco de dados e retorna o número de linhas afetadas */

    public function updateDB($sql, $params = null)
    {
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $rs = $query->rowCount();
        self::__destruct();
        return $rs;
    }

    /* Método update para a tabela f_liberacao */

    public function updateDBLiberacao($sql, $params = null, $tela, $caminho)
    {
        try {
            $query = $this->connect()->prepare($sql);
            $query->execute($params);
            $rs = $query->rowCount();
            $_SESSION[$tela] = "update";
            echo "<script>location.replace (\"$caminho\");</script>";
            
        } catch (PDOException $exc) {
            $_SESSION[$tela] = "erro";
            echo "<script>location.replace (\"$caminho\");</script>";

        }
        self::__destruct();
        return $rs;
    }

    /* Método delete que excluí valores do banco de dados retorna o número de linhas afetadas */

    public function deleteDB($sql, $params = null, $tela, $caminho)
    {
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        $rs = $query->rowCount() or die(print_r($query->errorInfo() ));
        $_SESSION[$tela] = "deleted";
        echo "<script>location.replace (\"$caminho\");</script>";
        self::__destruct();
        return $rs;
    }

    /* Método select que retorna um VO ou um array de objetos */

    public function selectDB($sql, $params = null, $class = null)
    {
        $query = $this->connect()->prepare($sql);
        $query->execute($params);
        if (isset($class)) {
            $rs = $query->fetchAll(PDO::FETCH_CLASS, $class);
        } else {
            $rs = $query->fetchAll(PDO::FETCH_OBJ);
        }
        self::__destruct();
        return $rs;
    }

}