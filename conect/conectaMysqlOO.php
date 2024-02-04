<?php

if (!isset($_SESSION)) {
    session_start();
}
class conectaMysql
{
    /* Evita que a classe seja clonada */

    private function __clone()
    {

    }

    /* Método que destroi a conexão com banco de dados e remove da memória todas as variáveis setadas */

    public function __destruct()
    {
        $this->disconnect();
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    //Servidor remoto
    /*private static $dbtype = "mysql";
    private static $host = "mysql.pibema.pr.gov.br";
    private static $port = "3306";
    private static $user = "pibemaprgovbr";
    private static $password = "info0016";
    private static $db = "pibemaprgovbr";
    */
    //Servidor local
    private static $dbtype = "mysql";
    private static $host = "localhost";
    private static $port = "3306";
    private static $user = "root";
    private static $password = "root";
    private static $db = "music-festival";


    /* Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada */

    private function getDBType()
    {
        return self::$dbtype;
    }

    private function getHost()
    {
        return self::$host;
    }

    private function getPort()
    {
        return self::$port;
    }

    private function getUser()
    {
        return self::$user;
    }

    private function getPassword()
    {
        return self::$password;
    }

    private function getDB()
    {
        return self::$db;
    }

    private function connect()
    {
        try {
            $this->conexao = new PDO($this->getDBType() . ":host=" . $this->getHost() . ";port=" . $this->getPort() . ";charset=utf8;dbname=" . $this->getDB(), $this->getUser(), $this->getPassword());
        } catch (PDOException $i) {
            //se houver exceção, exibe
            die("Erro: <code>" . $i->getMessage() . "</code>");
        }
        return ($this->conexao);

    }

    private function disconnect()
    {
        $this->conexao = null;
    }

    /* Método insert que insere valores no banco de dados e retorna o último id inserido */

    public function insertDB($sql, $params = null, $tela, $caminho)
    {
        try {
            $conexao = $this->connect();
            $query = $conexao->prepare($sql);
            $_SESSION[$tela] = "sucess";
            $query->execute($params);

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
        $rs = $query->rowCount() or die(print_r($query->errorInfo()));
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