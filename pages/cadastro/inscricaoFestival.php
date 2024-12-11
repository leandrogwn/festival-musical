<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
if ( !isset( $_SESSION ) ) {
    session_start();
    $_SESSION[ 'tab' ] = 'inscrito';
}
include ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/conectaMysqlOO.php' );

class inscricaoFestival {

    private $dadosForm;
    private $festival;
    private $nome;
    private $nascimento;
    private $rg;
    private $cpf;
    private $telefone;
    private $celular;
    private $email;
    private $informacoes_interprete;
    private $cep;
    private $uf;
    private $rua;
    private $numero;
    private $bairro;
    private $cidade;
    private $categoria;
    private $cancao;
    private $compositor;
    private $gravado_por;
    private $link;
    private $informacao_cancao;
    private $letra;
    private $sql;
    private $tela;

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array( INPUT_POST, FILTER_DEFAULT );
        $this->festival = $this->dadosForm[ 'festival' ];
        $this->nome = $this->dadosForm[ 'nome' ];
        $this->nascimento = $this->dadosForm[ 'nascimento' ];
        $this->rg = $this->dadosForm[ 'rg' ];
        $this->cpf = $this->dadosForm[ 'cpf' ];
        $this->telefone = $this->dadosForm[ 'telefone' ];
        $this->celular = $this->dadosForm[ 'celular' ];
        $this->email = $this->dadosForm[ 'email' ];
        $this->informacoes_interprete = $this->dadosForm[ 'informacao_interprete' ];
        $this->cep = $this->dadosForm[ 'cep' ];
        $this->uf = $this->dadosForm[ 'uf' ];
        $this->rua = $this->dadosForm[ 'rua' ];
        $this->numero = $this->dadosForm[ 'numero' ];
        $this->bairro = $this->dadosForm[ 'bairro' ];
        $this->cidade = $this->dadosForm[ 'cidade' ];
        $this->categoria = $this->dadosForm[ 'categoria' ];
        $this->cancao = $this->dadosForm[ 'cancao' ];
        $this->compositor = $this->dadosForm[ 'compositor' ];
        $this->gravado_por = $this->dadosForm[ 'gravado_por' ];
        $this->link = $this->dadosForm[ 'link' ];
        $this->informacao_cancao = $this->dadosForm[ 'informacao_cancao' ];
        $this->letra = $this->dadosForm[ 'letra' ];
        $this->tela = $this->dadosForm[ 'tela' ];
    }

    private function gravaDados() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_inscricao (festival, nome, nascimento, rg, cpf, telefone, celular, email, informacoes_interprete, cep, uf, rua, numero, bairro, cidade, categoria, cancao, compositor, gravado_por, link, informacao_cancao, letra) 
            VALUES (:festival, :nome, :nascimento, :rg, :cpf, :telefone, :celular, :email, :informacoes_interprete, :cep, :uf, :rua, :numero, :bairro, :cidade, :categoria, :cancao, :compositor, : gravado_por, :link, :informacao_cancao, :letra)";
        $params = array(
            ':festival' => $this->festival,
            ':nome' => $this->nome,
            ':nascimento' => $this->nascimento,
            ':rg' => $this->rg,
            ':cpf' => $this->cpf,
            ':telefone' => $this->telefone,
            ':celular' => $this->celular,
            ':email' => $this->email,
            ':informacoes_interprete' => $this->informacoes_interprete,
            ':cep' => $this->cep,
            ':uf' => $this->uf,
            ':rua' => $this->rua,
            ':numero' => $this->numero,
            ':bairro' => $this->bairro,
            ':cidade' => $this->cidade,
            ':categoria' => $this->categoria,
            ':cancao' => $this->cancao,
            ':compositor' => $this->compositor,
            ':gravado_por' => $this->gravado_por,
            ':link' => $this->link,
            ':informacao_cancao' => $this->informacao_cancao,
            ':letra' => $this->letra
        );
        $ObjConecta->insertDB( $this->sql, $this->tela, $params, '../tab/inscricao.php' );

    }

}

$ObjInscricaoFestival = new inscricaoFestival();
