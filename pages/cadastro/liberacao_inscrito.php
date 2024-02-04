<?php

if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "inscrito";
}
include ("../../conect/conectaMysqlOO.php");

class liberacao_inscrito {

    private $dadosForm;
    private $festival;
    private $inscrito;
    private $categoria;
    private $tela;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $this->festival = $this->dadosForm["festival"];
        $this->inscrito = $this->dadosForm["inscrito"];
        $this->categoria = $this->dadosForm["categoria"];
        $this->tela = $this->dadosForm["tela"];
    }

    private function gravaDados() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_primeira_fase (id_festival, id_interprete, categoria) VALUES ('$this->festival', '$this->inscrito', '$this->categoria')";
        $ObjConecta->insertDB($this->sql, null, $this->tela, "../tab/inscritos.php");
    }

}

$ObjLiberacaoInscrito = new liberacao_inscrito();
