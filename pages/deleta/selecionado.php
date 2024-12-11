<?php
if ( !isset( $_SESSION ) ) {
    session_start();
    $_SESSION[ 'tab' ] = 'inscrito';
}
include ( '../../conectaMysqlOO.php' );

class selecionado {

    private $dadosForm;
    private $interprete;
    private $festival;
    private $tela;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->executaQuery();
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array( INPUT_GET, FILTER_DEFAULT );
        $this->festival = $this->dadosForm[ 'festival' ];
        $this->interprete = $this->dadosForm[ 'interprete' ];
        $this->tela = $this->dadosForm[ 'tela' ];
    }

    private function executaQuery() {
        $ObjConecta = new conectaMysql();
        $this->sql = 'DELETE FROM f_primeira_fase WHERE id_festival = :festival AND id_interprete = :interprete';
        $params = array(
            ':festival' => $this->festival,
            ':interprete' => $this->interprete
        );
        $ObjConecta->deleteDB( $this->sql, $this->tela, $params, '../tab/inscritos.php' );
    }
}

$ObjSelecionado = new selecionado();
