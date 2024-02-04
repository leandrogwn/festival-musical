<?php
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['tab'] = "nota";
}
include("../../conect/conectaMysqlOO.php");

class nota
{

    private $dadosForm;
    private $fase;
    private $id_interprete;
    private $id_jurado;
    private $afinacao;
    private $ritmo;
    private $interpretacao;
    private $letra;
    private $nota;
    private $categoria;
    private $genero;
    private $tela;
    private $sql;

    public function __construct()
    {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados()
    {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->fase = $this->dadosForm["fase"];
        $this->id_interprete = $this->dadosForm["id_interprete"];
        $this->id_jurado = $this->dadosForm["id_jurado"];
        $this->afinacao = str_replace(",", ".", $this->dadosForm["afinacao"]);
        $this->ritmo = str_replace(",", ".", $this->dadosForm["ritmo"]);
        $this->interpretacao = str_replace(",", ".", $this->dadosForm["interpretacao"]);
        $this->letra = str_replace(",", ".", $this->dadosForm["nota_letra"]);
        $this->nota = str_replace(",", ".", $this->dadosForm["nota"]);
        $this->genero = $this->dadosForm["genero"];
        $this->tela = $this->dadosForm["tela"];
    }

    private function gravaDados()
    {

        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_nota (fase, id_interprete, id_jurado, afinacao, ritmo, interpretacao, letra, nota, genero) VALUES ('$this->fase', $this->id_interprete, $this->id_jurado, '$this->afinacao', '$this->ritmo','$this->interpretacao','$this->letra','$this->nota', '$this->genero')";
        
        $ObjConecta->insertDBNota($this->sql, null, $this->tela, "../painel.php");
    }

}

$ObjNota = new nota();