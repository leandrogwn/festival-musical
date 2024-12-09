<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
session_start();
include ( '../../conectaMysqlOO.php' );

class Config {

    private $dadosForm;
    private $id_user;
    private $festival_ativo;
    private $registro_pagina;
    private $exclusao_notas;
    private $qtd_class_seg_fase;
    private $qtd_class_final;
    private $domain;
    private $tela;
    private $sql;

    public function __construct() {
        $this->recebeDados();
        $this->atualizaConfig();
    }

    private function recebeDados() {
        // Filtrando os dados recebidos do formulário para evitar injeção de código
        $this->dadosForm = filter_input_array( INPUT_POST, FILTER_DEFAULT );

        // Verificar se os dados existem antes de atribuir
        $this->id_user = isset( $_SESSION[ 'idUser' ] ) ? $_SESSION[ 'idUser' ] : null;
        $this->festival_ativo = isset( $this->dadosForm[ 'config_festival_ativo' ] ) ? $this->dadosForm[ 'config_festival_ativo' ] : null;
        $this->registro_pagina = isset( $this->dadosForm[ 'config_registro_pagina' ] ) ? $this->dadosForm[ 'config_registro_pagina' ] : null;
        $this->exclusao_notas = isset( $this->dadosForm[ 'exclusao_notas' ] ) ? $this->dadosForm[ 'exclusao_notas' ] : null;
        $this->qtd_class_seg_fase = isset( $this->dadosForm[ 'qtd_class_seg_fase' ] ) ? $this->dadosForm[ 'qtd_class_seg_fase' ] : null;
        $this->qtd_class_final = isset( $this->dadosForm[ 'qtd_class_final' ] ) ? $this->dadosForm[ 'qtd_class_final' ] : null;
        $this->domain = isset( $this->dadosForm[ 'domain' ] ) ? $this->dadosForm[ 'domain' ] : null;
        $this->tela = isset( $this->dadosForm[ 'tela' ] ) ? $this->dadosForm[ 'tela' ] : null;

        // Validar os campos, se necessário, antes de continuar
        if ( !$this->id_user || !$this->festival_ativo || !$this->registro_pagina ) {
            die( 'Campos obrigatórios não fornecidos.' );
        }
    }

    private function atualizaConfig() {
        $ObjConecta = new conectaMysql();

        // Usando prepared statements para evitar injeção de SQL
        $this->sql = "INSERT INTO f_config (user, festival_ativo, registros_pagina, exclusao_notas, qtd_class_seg_fase, qtd_class_final, domain) 
                      VALUES (:user, :festival_ativo, :registros_pagina, :exclusao_notas, :qtd_class_seg_fase, :qtd_class_final, :domain)";

        // Preparar a consulta com MySQLi
        $stmt = mysqli_prepare( $ObjConecta->conMysql, $this->sql );

        // Associar os parâmetros
        $stmt->bindParam( ':user', $this->id_user, PDO::PARAM_INT );
        $stmt->bindParam( ':festival_ativo', $this->festival_ativo, PDO::PARAM_INT );
        $stmt->bindParam( ':registros_pagina', $this->registro_pagina, PDO::PARAM_INT );
        $stmt->bindParam( ':exclusao_notas', $this->exclusao_notas, PDO::PARAM_INT );
        $stmt->bindParam( ':qtd_class_seg_fase', $this->qtd_class_seg_fase, PDO::PARAM_INT );
        $stmt->bindParam( ':qtd_class_final', $this->qtd_class_final, PDO::PARAM_INT );
        $stmt->bindParam( ':domain', $this->domain, PDO::PARAM_STR );

        // Executar a consulta
        if ( $stmt->execute() ) {
            // Redirecionar ou enviar a resposta conforme necessário
            header( 'Location: ../tab/opcoes.php' );
            exit();
        } else {
            // Erro ao inserir
            die( 'Erro ao salvar as configurações.' );
        }
    }
}

// Criar o objeto de configuração e executar a lógica
$ObjConfig = new Config();
