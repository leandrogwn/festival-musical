<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "jurado";
}
include ("../../conectaMysqlOO.php");

class excluir_jurado {

    private $dadosForm;
    private $festival;
    private $id_jurado;
    private $tela;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->executaQuery();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $this->festival = $this->dadosForm["festival"];
        $this->id_jurado = $this->dadosForm["id_jurado"];
        $this->tela = $this->dadosForm["tela"];
    }

    private function executaQuery() {
        $ObjConecta = new conectaMysql();
        $this->sql = "DELETE FROM f_jurado WHERE id = $this->id_jurado AND festival = $this->festival";
        $ObjConecta->deleteDB($this->sql, null, $this->tela, "../listagem/jurado.php");
    }
}
$ObjExcluiJurado = new excluir_jurado();
