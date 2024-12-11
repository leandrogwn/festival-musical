<?php
if (!isset($_SESSION)) {
    session_start();
}

class verificarLogin
{

    private $usuario;
    private $senha;
    private $registro;
    private $registro_config;
    private $sessao;

    public function __construct()
    {

    }

    public function verifiLogin($usuario, $senha)
    {

        $this->usuario = $usuario;
        $this->senha = $senha;

        if ($this->usuario === "" || $this->senha === "") {

            echo "<br><br><center><h2>Os campos login e senha não podem ter valores nulos</2></center>";
            echo "<br><br><center><a href=\"index.html\">Clique aqui para tentar novamente</a></center>";
        } else {

            include '../conectaMysql.php';
            $festAtivo = mysqli_query($conMysql, "select festival_ativo from f_config order by id desc limit 1")
                or die("<br>Não foi possivel realizar a busca. Erros: " . mysqli_error($conMysql));

            while ($this->registro_config = mysqli_fetch_assoc($festAtivo)) {
                $festivalAtivo = $this->registro_config["festival_ativo"];
            }

            $validaLogin = mysqli_query($conMysql, "select * from f_jurado where festival like '$festivalAtivo' and login = '$this->usuario'")
                or die("<br>Não foi possivel realizar a busca. Erro: " . mysqli_error($conMysql));

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

    private function habilitarSessao()
    {
        $_SESSION['idUser'] = $this->registro["id"];
        $_SESSION['nome'] = $this->registro["nome"];
        $_SESSION['logado'] = md5(date("d/m/Y"));

        include '../conectaMysql.php';
        $config = mysqli_query($conMysql, "select * from f_config order by id desc limit 1")
            or die("<br>Não foi possivel realizar a busca. Erros: " . mysqli_error($conMysql));

        while ($this->registro_config = mysqli_fetch_assoc($config)) {
            $_SESSION['festival'] = $this->registro_config["festival_ativo"];
            $_SESSION['registro_pagina'] = $this->registro_config["registros_pagina"];
        }
    }

}
