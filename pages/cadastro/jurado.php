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
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_jurado (festival, nome, login, senha, informacao) 
                            VALUES ('$this->festival', '$this->nome', '$this->login','$this->senha', '$this->informacao')";
        $conexao = $ObjConecta->connect();
        $stmt = $conexao->prepare( $this->sql );

        $stmt->bindParam( ':festival', $this->festival, PDO::PARAM_INT );
        $stmt->bindParam( ':nome', $this->nome, PDO::PARAM_STR );
        $stmt->bindParam( ':login', $this->login, PDO::PARAM_STR );
        $stmt->bindParam( ':senha', $this->senha, PDO::PARAM_STR );
        $stmt->bindParam( ':informacao', $this->informacao, PDO::PARAM_STR );

        // Executar a consulta
        if ( $stmt->execute() ) {
            // Redirecionar ou enviar a resposta conforme necessário
            header( 'Location: ../tab/opcoes.php' );
            exit();
        } else {
            // Erro ao inserir
            die( 'Erro ao salvar as configurações.' );
        }
        $conexao->insertDB( $this->sql, null, $this->tela, '../tab/jurado.php' );
    }

}

$ObjJurado = new jurado();
