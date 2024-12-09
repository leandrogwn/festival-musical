<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "nota";
}
include ("../../conectaMysqlOO.php");

class nota {

    private $dadosForm;
    private $fase;
    private $id_interprete;
    private $tela;
    private $id_jurado;
    private $nota;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->fase = $this->dadosForm["fase"];
        $this->id_interprete = $this->dadosForm["id_interprete"];
        $this->id_jurado = $this->dadosForm["id_jurado"];
        $this->nota = $this->dadosForm["nota"];
        $this->tela = $this->dadosForm["tela"];
    }

    private function gravaDados() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_nota (fase, id_interprete, id_jurado, nota) VALUES ('$this->fase', '$this->id_interprete', '$this->id_jurado', '$this->nota')";
        $ObjConecta->insertDB($this->sql, null, $this->tela, "../voto/aguardando.php");
    }

}

$ObjNota = new nota();
