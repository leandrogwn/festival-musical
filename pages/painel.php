<?php
include("../login/verificarLogin.php");
class painel
{
    private $dadosFormulario;
    private $usuario;
    private $senha;
    private $instanciaVereficarLogin;
    private $chave;

    public function __construct()
    {
        $this->recebeDados();
        $this->recebeVerificacao();
        $this->validaVerificacao();
    }

    private function recebeDados()
    {
        $this->dadosFormulario = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->usuario = isset($this->dadosFormulario["login_digitado"]) ? $this->dadosFormulario["login_digitado"] : "";
        $this->senha = isset($this->dadosFormulario["senha_digitada"]) ? sha1($this->dadosFormulario["senha_digitada"]) : "";
    }

    private function recebeVerificacao()
    {
        $this->instanciaVereficarLogin = new VerificarLogin();
        $this->instanciaVereficarLogin->verifiLogin($this->usuario, $this->senha);
    }

    private function validaVerificacao()
    {
        $this->chave = md5(date("d/m/Y"));
        if (isset($_SESSION['logado']) == $this->chave) {
            error_reporting(0);
            ?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="utf-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>Festival musical</title>


                <!--Let browser know website is optimized for mobile-->
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />

                <script type="text/javascript" src="./js/jqueryFest.js"></script>
                <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">

            </head>

            <body>
                <?php include 'header.php'; ?>

                <?php include 'listagem/dashboard.php'; ?>

                <?php include 'footer.php'; ?>
            </body>

            </html>
            <?php
        } else {
            $_SESSION['access'] = sha1(date("d/m/Y"));
            echo '<script>window.location.href = "../index.php";</script>';
        }
    }

}

$newObjPainel = new painel();