<?php
if ( !isset( $_SESSION ) ) {
    session_start();
    $_SESSION[ 'tab' ] = 'nota';
}
include( '../../conectaMysqlOO.php' );

class nota {

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

    public function __construct() {
        $this->recebeDados();
        $this->gravaDados();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array( INPUT_POST, FILTER_DEFAULT );
        $this->fase = $this->dadosForm[ 'fase' ];
        $this->id_interprete = $this->dadosForm[ 'id_interprete' ];
        $this->id_jurado = $this->dadosForm[ 'id_jurado' ];
        $this->afinacao = str_replace( ',', '.', $this->dadosForm[ 'afinacao' ] );
        $this->ritmo = str_replace( ',', '.', $this->dadosForm[ 'ritmo' ] );
        $this->interpretacao = str_replace( ',', '.', $this->dadosForm[ 'interpretacao' ] );
        $this->letra = 0;
        $this->nota = str_replace( ',', '.', $this->dadosForm[ 'nota' ] );
        $this->genero = $this->dadosForm[ 'genero' ];
        $this->tela = $this->dadosForm[ 'tela' ];
    }

    private function gravaDados() {

        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_nota (fase, id_interprete, id_jurado, afinacao, ritmo, letra, interpretacao, nota, genero) 
        VALUES (:fase, :id_interprete, :id_jurado, :afinacao, :ritmo, :letra, :interpretacao, :nota, :genero)";

        $params = array(
            ':fase' => $this->fase,
            ':id_interprete' => $this->id_interprete,
            ':id_jurado' => $this->id_jurado,
            ':afinacao' => $this->afinacao,
            ':ritmo' => $this->ritmo,
            ':letra' => $this->letra,
            ':interpretacao' => $this->interpretacao,
            ':nota' => $this->nota,
            ':genero' => $this->genero
        );

        $ObjConecta->insertDBNota( $this->sql, $this->tela, $params, '../painel.php' );
    }

}

$ObjNota = new nota();