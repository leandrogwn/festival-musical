<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
if ( !isset( $_SESSION ) ) {
    session_start();
    $_SESSION[ 'tab' ] = 'jurado';
}
include ( '../../conectaMysqlOO.php' );

class jurado {

    private $dadosForm;
    private $festival;
    private $nome;
    private $tela;
    private $login;
    private $senha;
    private $informacao;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array( INPUT_POST, FILTER_DEFAULT );
        $this->festival = $this->dadosForm[ 'festival_jurado' ];
        $this->nome = $this->dadosForm[ 'nome_jurado' ];
        $this->login = $this->dadosForm[ 'login_jurado' ];
        $this->senha = sha1( $this->dadosForm[ 'senha_jurado' ] );
        $this->informacao = $this->dadosForm[ 'informacao_jurado' ];
        $this->tela = $this->dadosForm[ 'tela' ];
    }

    private function gravaDados() {
        $conexao  = new conectaMysql();
        $this->sql = "INSERT INTO f_jurado (festival, nome, login, senha, informacao) 
                            VALUES ( :festival, :nome, :login, :senha, :informacao )";
        $params = array(
            ':festival' => $this->festival,
            ':nome' => $this->nome,
            ':login' => $this->login,
            ':senha' => $this->senha,
            ':informacao' => $this->informacao
        );

        $conexao->insertDB( $this->sql, $this->tela, $params, '../tab/jurado.php' );
    }

}

$ObjJurado = new jurado();
