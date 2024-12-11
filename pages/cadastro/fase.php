<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "fase";
}
include ("../conectaMysqlOO.php");

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
        $this->sql = "INSERT INTO f_fase (festival, fase, data, informacao)
            VALUES (:festival, :fase, :data, :informacao)";
        $params = array(
            ':festival' => $this->festival,
            ':fase' => $this->nome,
            ':data' => $this->data,
            ':informacao' => $this->informacao
        ); 

        $ObjConecta->insertDB($this->sql, "fase", $params, "A fase <b>".$this->nome."</b> foi inserida com sucesso!");
    }

}

$ObjFase = new fase();
