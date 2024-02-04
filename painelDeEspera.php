<?php
if (!isset($_SESSION)) {
    session_start();
}
include ("./login/verificarLogin.php");

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

                    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css"/>

                    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">

                    <!--Let browser know website is optimized for mobile-->
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">


                    <script type="text/javascript" src="js/jqueryFest.js"></script>
                    <link rel="shortcut icon" href="img/festIbemaFavicon.png" type="image/x-icon">


                </head>
                <body>
                    <nav class="navbar" >
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <a class="navbar-brand linx" href="#"><img id="logo-nav" src="img/logo.png"/></a>
                            </div>
                            <div class="logout">
                                <?php echo $_SESSION['nome']; ?><a href="logout.php"><img src="img/logout.png" class="img-logout"></a>
                            </div>
                        </div>
                    </nav>
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li <?php
                            if (!isset($_SESSION['tab'])) {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#festival" data-toggle="tab">Festival</a>
                            </li>
                            <?php /*<li <?php
                            if ($_SESSION['tab'] == "fase") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#fase" data-toggle="tab">Fase</a>
                            </li>*/ ?>
                            <li <?php
                            if ($_SESSION['tab'] == "jurado") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#jurado" data-toggle="tab">Jurado</a>
                            </li>
                            <li <?php
                            if ($_SESSION['tab'] == "inscrito") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#inscritos" data-toggle="tab">Inscritos</a>
                            </li>
                            <li <?php
                            if ($_SESSION['tab'] == "liberacao") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#liberacao" data-toggle="tab">Liberação</a>
                            </li>
                             <?php /*<li <?php
                            if ($_SESSION['tab'] == "classificacao") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#classificacao" data-toggle="tab">Classificação</a>
                            </li>*/?>
                            <li <?php
                            if ($_SESSION['tab'] == "relatorio") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#relatorio" data-toggle="tab">Relatório</a>
                            </li>
                            
                            <li <?php
                            if ($_SESSION['tab'] == "voto") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#voto" data-toggle="tab">Voto</a>
                            </li>
                            
                            <li <?php
                            if ($_SESSION['tab'] == "opcoes") {
                                echo "class=\"active\"";
                            }
                            ?>>
                                <a href="#opcoes" data-toggle="tab">Opções</a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <!-- Tab festival-->
                            <div class="tab-pane <?php
                            if (!isset($_SESSION['tab'])) {
                                echo "active";
                            }
                            ?>" id="festival">
                                 <?php  include './pages/tab/festival.php'; ?>
                            </div>

                            <!-- Tab fase-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "fase") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="fase">
                                 <?php  include './pages/tab/fase.php'; ?>
                            </div>

                            <!-- Tab jurado-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "jurado") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="jurado">
                                 <?php  include './pages/tab/jurado.php'; ?>
                            </div>

                            <!-- Tab inscritos-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "inscrito") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="inscritos" align="center">
                               <iframe  id="frame_inscritos" name="frame_inscritos" src="pages/tab/inscritos.php" frameborder="0"  style="width: 75%; height: 600px;"></iframe>
                            </div>

                            <!-- Tab liberacao-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "liberacao") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="liberacao">
                                 <?php  include './pages/listagem/liberacao.php'; ?>
                            </div>

                            <!-- Tab classificacao-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "classificacao") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="classificacao">
                                 <?php // include './pages/consultaPersonalizada.php';      ?>
                            </div>

                            <!-- Tab relatorio-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "relatorio") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="relatorio">
                                 <?php //  include './pages/consultaPersonalizada.php';      ?>
                            </div>
                            
                            <!-- Tab voto-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "voto") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="voto">
                                 <?php include './pages/voto/voto.php';      ?>
                            </div>

                            <!-- Tab config e usuários-->
                            <div class="tab-pane <?php
                            if ($_SESSION['tab'] == "config") {
                                echo "active";
                                unset($_SESSION['tab']);
                            }
                            ?>" id="opcoes">

                                <?php  include './pages/tab/opcoes.php'; ?>
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
