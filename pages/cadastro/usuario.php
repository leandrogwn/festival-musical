<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

if ( !isset( $_SESSION ) ) {
    session_start();
    $_SESSION[ 'tab' ] = 'usuario';
}
include ( '../../conectaMysqlOO.php' );

class usuario {

    private $dadosForm;
    private $nome;
    private $login;
    private $senha;
    private $perfil;
    private $tela;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array( INPUT_POST, FILTER_DEFAULT );
        $this->nome = $this->dadosForm[ 'nome' ];
        $this->login = $this->dadosForm[ 'login' ];
        $this->senha = sha1( $this->dadosForm[ 'senha' ] );
        $this->perfil = $this->dadosForm[ 'perfil' ];
        $this->tela = $this->dadosForm[ 'tela' ];
    }

    private function gravaDados() {
        $ObjConecta = new conectaMysql();
        $this->sql = 'INSERT INTO f_login (nome, login, senha, perfil) VALUES (:nome, :login, :senha, :perfil)';
        $params = array(
            ':nome' => $this->nome,
            ':login' => $this->login,
            ':senha' => $this->senha,
            ':perfil' => $this->perfil
        );
        $ObjConecta->insertDB( $this->sql,  $this->tela, $params, '../tab/usuario.php' );
    }

}

$ObjUsuario = new usuario();
