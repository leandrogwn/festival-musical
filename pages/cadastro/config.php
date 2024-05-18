<?php
session_start();
include ("../../conect/conectaMysqlOO.php");

class config {
    
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
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->id_user = $_SESSION['idUser'];
        $this->festival_ativo = $this->dadosForm["config_festival_ativo"];
        $this->registro_pagina = $this->dadosForm["config_registro_pagina"];
        $this->exclusao_notas = $this->dadosForm["exclusao_notas"];
        $this->qtd_class_seg_fase = $this->dadosForm["qtd_class_seg_fase"];
        $this->qtd_class_final = $this->dadosForm["qtd_class_final"];
        $this->domain = $this->dadosForm["domain"];
        $this->tela = $this->dadosForm["tela"];
    }

    private function atualizaConfig() {
        $ObjConecta = new conectaMysql();
        $this->sql = "INSERT INTO f_config (user, festival_ativo, registros_pagina, exclusao_notas, qtd_class_seg_fase, qtd_class_final, domain) VALUES ($this->id_user, $this->festival_ativo, $this->registro_pagina, $this->exclusao_notas, $this->qtd_class_seg_fase,  $this->qtd_class_final, \"$this->domain\")";
        $ObjConecta->insertDB($this->sql, null, $this->tela, "../tab/opcoes.php");
    }
}

$ObjConfig = new config();
