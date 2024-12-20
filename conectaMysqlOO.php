<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once implode( DIRECTORY_SEPARATOR, [ __DIR__, 'vendor', 'autoload.php' ] );

if ( $_ENV[ 'APPSETTING_WEBSITE_SITE_NAME' ] !== 'festivalmusical' ) {

    $dotenv = Dotenv\Dotenv::createImmutable( __DIR__ );
    $dotenv->load();
}

class conectaMysql
 {
    private $pdo;

    public function connect()
 {
        try {
            $options = [];
            if ( $_ENV[ 'APPSETTING_WEBSITE_SITE_NAME' ] === 'festivalmusical' ) {
                $options = [
                    PDO::MYSQL_ATTR_SSL_CA => $_ENV[ 'AZURE_SSLCERT_PATH' ],
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                ];
            }

            $this->pdo = new PDO(
                'mysql:host=' . $_ENV[ 'AZURE_MYSQL_HOST' ] . ';port=' . $_ENV[ 'AZURE_MYSQL_PORT' ] . ';dbname=' . $_ENV[ 'AZURE_MYSQL_DBNAME' ],
                $_ENV[ 'AZURE_MYSQL_USERNAME' ],
                $_ENV[ 'AZURE_MYSQL_PASSWORD' ],
                $options
            );
            $this->pdo->exec( 'set names utf8' );
            return $this->pdo;
        } catch ( PDOException $e ) {
            throw new Exception( 'Erro de conexão: ' . $e->getMessage() );
        }
    }

    /* Desconectar do banco de dados */

    public function disconnect()
 {
        $this->pdo = null;
    }

    /* Método insert que insere valores no banco de dados e retorna o último id inserido */

    public function insertDB( $sql, $tela, $params, $caminho )
 {
        try {
            $conexao = $this->connect();
            $query = $conexao->prepare( $sql );
            $query->execute( $params );

            $_SESSION[ $tela ] = 'sucess';
            echo '<script>location.replace (\'' . $caminho . '\');</script>';

        } catch ( PDOException $exc ) {
            $_SESSION[ $tela ] = 'erro';
            echo '<script>location.replace (\'' . $caminho . '\');</script>';

        }
    }

    /* Método insert que insere notas no banco de dados e retorna o último id inserido */

    public function insertDBNota( $sql, $tela, $params, $caminho )
 {
        try {
            $conexao = $this->connect();
            var_dump( $conexao );

            $query = $conexao->prepare( $sql );
            $query->execute( $params );

            $_SESSION[ $tela ] = 'sucess';
            echo '<script>location.replace (\'' . $caminho . '\');</script>';

        } catch ( PDOException $exc ) {
            $_SESSION[ $tela ] = 'erro';
            echo '<script>location.replace (\'' . $caminho . '\');</script>';

        }
    }

    /* Método insert que insere valores no banco de dados e retorna o último id inserido */

    public function insertDBInscricao( $sql, $tela, $params, $caminho )
 {
        $conexao = $this->connect();
        $query = $conexao->prepare( $sql );
        $query->execute( $params );

        $_SESSION[ $tela ] = 'sucess';
        echo '<script>location.replace (\''.$caminho.'\');</script>';
    }

    /* Método update que altera valores do banco de dados e retorna o número de linhas afetadas */

    public function updateDB( $sql, $params )
 {

        $conexao = $this->connect();
        $query = $conexao->prepare( $sql );
        $query->execute( $params );

        $rs = $query->rowCount();

        return $rs;
    }

    /* Método update para a tabela f_liberacao */

    public function updateDBLiberacao( $sql, $tela, $params, $caminho )
 {
        try {
            $conexao = $this->connect();
            $query = $conexao->prepare( $sql );
            $query->execute( $params );

            $rs = $query->rowCount();

            $_SESSION[ $tela ] = 'update';
            echo '<script>location.replace (\''.$caminho.'\');</script>';

        } catch ( PDOException $exc ) {
            $_SESSION[ $tela ] = 'erro';
            echo '<script>location.replace (\''.$caminho.'\');</script>';

        }
        return $rs;
    }

    /* Método delete que excluí valores do banco de dados retorna o número de linhas afetadas */

    public function deleteDB( $sql, $tela, $params, $caminho )
 {

        $conexao = $this->connect();
        $query = $conexao->prepare( $sql );
        $query->execute( $params );

        $rs = $query->rowCount() or die( print_r( $query->errorInfo() ) );

        $_SESSION[ $tela ] = 'deleted';

        echo '<script>location.replace (\''.$caminho.'\');</script>';
        return $rs;
    }

    /* Método select que retorna um VO ou um array de objetos */

    public function selectDB( $sql, $class = null )
 {
        $conexao = $this->connect();
        $query = $conexao->prepare( $sql );
        $query->execute();

        if ( isset( $class ) ) {
            $rs = $query->fetchAll( PDO::FETCH_CLASS, $class );
        } else {
            $rs = $query->fetchAll( PDO::FETCH_OBJ );
        }
        return $rs;
    }
}