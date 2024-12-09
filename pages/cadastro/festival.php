<?php

include ("../../conectaMysqlOO.php");

class festival {

    private $dadosForm;
    private $nome;
    private $periodo;
    private $informacao;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->nome = $this->dadosForm["nome_festival"];
        $this->periodo = $this->dadosForm["periodo_festival"];
        $this->informacao = $this->dadosForm["informacao_festival"];
    }

    private function gravaDados() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_festival (nome, periodo, informacao) VALUES ('$this->nome', '$this->periodo', '$this->informacao')";
        $ObjConecta->insertDB($this->sql, null, "festival", "O festival <b>".$this->nome."</b> foi inserido com sucesso!");
    }

}

$ObjFestival = new festival();
