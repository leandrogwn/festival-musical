<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "fase";
}
include ("../conect/conectaMysqlOO.php");

class fase {

    private $dadosForm;
    private $festival;
    private $nome;
    private $data;
    private $informacao;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->festival = $this->dadosForm["festival_fase"];
        $this->nome = $this->dadosForm["nome_fase"];
        $this->data = $this->dadosForm["data_fase"];
        $this->informacao = $this->dadosForm["informacao_fase"];
    }

    private function gravaDados() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_fase (festival, fase, data, informacao) VALUES ('$this->festival', '$this->nome', '$this->data', '$this->informacao')";
        $ObjConecta->insertDB($this->sql, null, "fase", "A fase <b>".$this->nome."</b> foi inserida com sucesso!");
    }

}

$ObjFase = new fase();
