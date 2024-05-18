<?php
if (!isset($_SESSION)) {
    session_start();
}

class verificarLogin {
    private $usuario;
    private $senha;
    private $registro;
    private $registro_config;
    private $sessao;
    
    public function __construct() {
        
    }
    
    public function verifiLogin($usuario, $senha) {
        
        $this->usuario = $usuario;
        $this->senha = $senha;
        
        if ($this->usuario === "" || $this->senha === "") {
            
            echo "<br><br><center><h2>Os campos login e senha nao podem ter valores nulos</2></center>";
            echo "<br><br><center><a href=\"index.html\">Clique aqui para tentar novamente</a></center>";
        } else {
            
            include '../conect/conectaMysql.php';
            
            $validaLogin = mysqli_query($conMysql, "select * from f_login where login = '$this->usuario'")
            or die("<br>Nao foi possivel realizar a busca. Erro: " . mysqli_error($conMysql));
            
            while ($this->registro = mysqli_fetch_assoc($validaLogin)) {

                $login_db = $this->registro["login"];
                $senha_db = $this->registro["senha"];
                $this->sessao = md5(date("d/m/Y"));
				
                if ($login_db === $this->usuario && $senha_db === $this->senha || $_SESSION['logado'] === $this->sessao) {

                    $this->habilitarSessao();
                }
            }
        }
    }

    private function habilitarSessao() {
        $_SESSION['idUser'] = $this->registro["id_login"];
        $_SESSION['perfil'] = $this->registro["perfil"];
        $_SESSION['nome'] = $this->registro["nome"];
        $_SESSION['logado'] = md5(date("d/m/Y"));
        
        include '../conect/conectaMysql.php';
        $config = mysqli_query($conMysql, "select * from f_config order by id desc limit 1")
                or die("<br>Nao foi possivel realizar a busca. Erros: " . mysqli_error($conMysql));

        while ($this->registro_config = mysqli_fetch_assoc($config)) {
           $_SESSION['festival'] = $this->registro_config["festival_ativo"];
            $_SESSION['registro_pagina'] = $this->registro_config["registros_pagina"];
            $_SESSION['exclusao_notas'] = $this->registro_config["exclusao_notas"];
            $_SESSION['qtd_class_seg_fase'] = $this->registro_config["qtd_class_seg_fase"];
            $_SESSION['qtd_class_final'] = $this->registro_config["qtd_class_final"];
            $_SESSION['domain'] = $this->registro_config["domain"];
        }
    }

}
