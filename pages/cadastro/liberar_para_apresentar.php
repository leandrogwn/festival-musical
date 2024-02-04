<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "liberacao";
}
include ("../../conect/conectaMysqlOO.php");

class liberar_para_apresentar {

    private $dadosForm;
    private $festival;
    private $interprete;
    private $fase;
    private $categoria;
    private $status;
    private $tela;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->concluirApresentacaoAtiva();
        $this->iniciarNovaApresentacao();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $this->festival = $this->dadosForm["festival"];
        $this->interprete = $this->dadosForm["interprete"];
        $this->fase = $this->dadosForm["fase"];
        $this->categoria = $this->dadosForm["categoria"];
        $_SESSION['f'] = $this->dadosForm["fase"];
        $_SESSION['c'] = $this->dadosForm["categoria"];
        $this->status = 1;
        $this->tela = $this->dadosForm["tela"];
    }
    
    private function concluirApresentacaoAtiva() {
        $ObjConecta = new conectaMysql();
        $this->sql = "UPDATE f_liberacao SET status = 2 where id_festival = $this->festival AND fase = $this->fase AND status = 1";
        $ObjConecta->updateDB($this->sql);
    }

    private function iniciarNovaApresentacao() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_liberacao (id_festival, id_interprete, fase, status) VALUES ('$this->festival', '$this->interprete', '$this->fase', ' $this->status')";
        $ObjConecta->insertDB($this->sql, null, $this->tela, "../listagem/listaInterpretes.php?liberacao_fase=$this->fase&liberacao_categoria=$this->categoria");
    }
}
$ObjLiberarParaApresentar = new liberar_para_apresentar();
