<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "liberacao";
}
include ("../../conect/conectaMysqlOO.php");

class postergar_apresentacao {

    private $dadosForm;
    private $festival;
    private $interprete;
    private $fase;
    private $tela;
    private $categoria;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->executaQuery();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $this->festival = $this->dadosForm["festival"];
        $this->interprete = $this->dadosForm["interprete"];
        $this->fase = $this->dadosForm["fase"];
        $this->tela = $this->dadosForm["tela"];
        $this->categoria = $this->dadosForm["categoria"];
        $_SESSION['f'] = $this->dadosForm["fase"];
        $_SESSION['c'] = $this->dadosForm["categoria"];
    }

    private function executaQuery() {
        $ObjConecta = new conectaMysql();
        $this->sql = "DELETE FROM f_liberacao WHERE id_festival = $this->festival AND id_interprete = $this->interprete AND fase like '$this->fase'";
        $ObjConecta->deleteDB($this->sql, null, $this->tela, "../listagem/listaInterpretes.php?liberacao_fase=$this->fase&liberacao_categoria=$this->categoria");
    }
}
$ObjPostergarApresentacao = new postergar_apresentacao();
