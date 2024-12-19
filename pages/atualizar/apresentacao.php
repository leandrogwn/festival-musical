<?php
if ( !isset( $_SESSION ) ) {
    session_start();
    $_SESSION[ 'tab' ] = 'liberacao';
}
include ( '../../conectaMysqlOO.php' );

class apresentacao {

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
    }

    private function recebeDados() {
        $this->dadosForm = filter_input_array( INPUT_GET, FILTER_DEFAULT );
        $this->festival = $this->dadosForm[ 'festival' ];
        $this->interprete = $this->dadosForm[ 'interprete' ];
        $this->fase = $this->dadosForm[ 'fase' ];
        $this->categoria = $this->dadosForm[ 'categoria' ];
        $_SESSION[ 'f' ] = $this->dadosForm[ 'fase' ];
        $_SESSION[ 'c' ] = $this->dadosForm[ 'categoria' ];
        $this->status = 1;
        $this->tela = $this->dadosForm[ 'tela' ];
    }

    private function concluirApresentacaoAtiva() {
        $ObjConecta = new conectaMysql();
        $this->sql = 'UPDATE f_liberacao SET status = :status where id_festival = :festival AND fase = :fase AND status = :status_atual';
    
        $params = array(
            ':status' => 2,
            ':festival' => $this->festival,
            ':fase' => $this->fase,
            ':status_atual' => 1
        );
    
        $ObjConecta->updateDBLiberacao( $this->sql, $this->tela, $params, "../listagem/listaInterpretes.php?liberacao_fase=$this->fase&liberacao_categoria=$this->categoria" );
    }

}
$ObjApresentacao = new apresentacao();
