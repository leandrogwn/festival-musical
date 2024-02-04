<?php
if (!isset($_SESSION)) {
    session_start();
}
include ("verificarLogin.php");

class painel {

    private $dadosFormulario;
    private $usuario;
    private $senha;
    private $instanciaVereficarLogin;
    private $chave;

    public function __construct() {
        $this->recebeDados();
        $this->recebeVerificacao();
        $this->validaVerificacao();
    }

    private function recebeDados() {
        $this->dadosFormulario = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->usuario = $this->dadosFormulario["login_digitado"];
        $this->senha = sha1($this->dadosFormulario["senha_digitada"]);
    }

    private function recebeVerificacao() {
        $this->instanciaVereficarLogin = new VerificarLogin();
        $this->instanciaVereficarLogin->verifiLogin($this->usuario, $this->senha);
    }

    private function validaVerificacao() {
        $this->chave = md5(date("d/m/Y"));
        if (isset($_SESSION['logado']) == $this->chave) {
            ?> 
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title>Festival musical</title>

                    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css"/>

                    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">

                    <!--Let browser know website is optimized for mobile-->
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">


                    <script type="text/javascript" src="../js/jqueryFest.js"></script>
                    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">

                </head>
                <body>
                    <?php
            include '../pages/header.php';
                    include 'voto/notasTempoReal.php'; ?>

<script>
            $(function () {
                var current_progress = 0;
                var interval = setInterval(function () {
                    current_progress += 1;
                    $("#dynamic")
                            .css("width", current_progress * 20 + "%")
                            .attr("aria-valuenow", current_progress * 20)
                            .text(6 - current_progress + " segundos para atualizar a página...");
                    if (current_progress >= 6) {
                        clearInterval(interval);
                        window.location.reload()
                    }
                }, 1000);
            });
        </script>
        <div align="center">
        <div class="progress progress-striped active" style="width: 70%;">
            <div id="dynamic"  class="bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                <span id="current-progress"></span>
            </div>
        </div>
        </div>
                    <script src="js/bootstrap.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $(".alert").fadeTo(6000, 500).slideUp(500, function () {
                                $(".alert").slideUp(500);
                            });
                            $(".close").click(function () {
                                $(".alert").hide();
                            });
                        });
                    </script>
                </body>
            </html>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                alert("Login ou Senha desconhecido, tente novamente!");
                window.open('index.html', '_top');
            </script>
            <?php
        }
    }

}

$newObjPainel = new painel();
