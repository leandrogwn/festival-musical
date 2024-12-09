<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "jurado";
}
include ("../../conectaMysqlOO.php");

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
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->festival = $this->dadosForm["festival_jurado"];
        $this->nome = $this->dadosForm["nome_jurado"];
        $this->login = $this->dadosForm["login_jurado"];
        $this->senha = sha1($this->dadosForm["senha_jurado"]);
        $this->informacao = $this->dadosForm["informacao_jurado"];
        $this->tela = $this->dadosForm["tela"];
    }

    private function gravaDados() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_jurado (festival, nome, login, senha, informacao) VALUES ('$this->festival', '$this->nome', '$this->login','$this->senha', '$this->informacao')";
        $ObjConecta->insertDB($this->sql, null, $this->tela, "../tab/jurado.php");
    }

}

$ObjJurado = new jurado();
