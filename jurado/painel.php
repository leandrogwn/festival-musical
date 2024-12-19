<?php
if (!isset($_SESSION)) {
    session_start();
}
include("verificarLogin.php");

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
        $this->usuario = $this->dadosFormulario["login_digitado"];
        $this->senha = sha1($this->dadosFormulario["senha_digitada"]);
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
            ?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="utf-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>Festival musical</title>

                <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />

                <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">

                <!--Let browser know website is optimized for mobile-->
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">


                <script type="text/javascript" src="../js/jqueryFest.js"></script>
                <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">


            </head>

            <body>
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <?php

                if (isset($_SESSION['enviook'])) {
                    if ($_SESSION['enviook'] == 'sucess') {
                        echo '<script>
                Swal.fire({
                    title: \'Obrigado!\',
                    text: \'O voto foi salvo com sucesso.\',
                    icon: \'success\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
                        unset($_SESSION['enviook']);

                    } else {
                        echo '<script>
                Swal.fire({
                    title: \'Atenção!\',
                    text: \'O voto não foi salvo, verifique se inseriu a nota corretamente, tente novamente caso o erro persista solicite a presença do técnico do festival.\',
                    icon: \'error\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
                        unset($_SESSION['enviook']);
                    }
                }
                ?>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
                    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

                <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $_SESSION['domain']; ?>/css/main.css" />
                <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

                <nav class="navbar" style="background-color: #edf0f5;">
                    <div class="container-fluid" style="display: block;">
                        <div class="navbar-header">

                            <a class="navbar-brand ms-3" href="painel.php"><span class="fs-4">Festival Musical</span></a>
                        </div>
                        <div class="logout">
                            <i class="bi bi-calendar">&nbsp;</i>
                            <script language="JavaScript">
                                var dataHora, xHora, xDia, dia, mes, ano, txtSaudacao;
                                dataHora = new Date();
                                xHora = dataHora.getHours();
                                if (xHora >= 0 && xHora < 12) { txtSaudacao = " bom Dia! " }
                                if (xHora >= 12 && xHora < 18) { txtSaudacao = " boa Tarde! " }
                                if (xHora >= 18 && xHora <= 23) { txtSaudacao = " boa Noite! " }

                                xDia = dataHora.getDay();
                                diaSemana = new Array(7);
                                diaSemana[0] = "Domingo";
                                diaSemana[1] = "Segunda-feira";
                                diaSemana[2] = "Terça-feira";
                                diaSemana[3] = "Quarta-feira";
                                diaSemana[4] = "Quinta-Feira";
                                diaSemana[5] = "Sexta-Feira";
                                diaSemana[6] = "Sábado";
                                dia = dataHora.getDate();
                                mes = dataHora.getMonth();
                                mesDoAno = new Array(12);
                                mesDoAno[0] = "janeiro";
                                mesDoAno[1] = "fevereiro";
                                mesDoAno[2] = "março";
                                mesDoAno[3] = "abril";
                                mesDoAno[4] = "maio";
                                mesDoAno[5] = "junho";
                                mesDoAno[6] = "julho";
                                mesDoAno[7] = "agosto";
                                mesDoAno[8] = "setembro";
                                mesDoAno[9] = "outubro";
                                mesDoAno[10] = "novembro";
                                mesDoAno[11] = "dezembro";
                                ano = dataHora.getFullYear();
                                document.write(diaSemana[xDia] + ", " + dia + " de " + mesDoAno[mes] + " de " + ano);
                            </script>

                            <img src="<?php echo $_SESSION['domain']; ?>/img/ico_avatar.png" alt="" width="24" height="24"
                                class="rounded-circle ms-4 me-2">
                            <strong class="me-2">
                                <?php echo $_SESSION['nome']; ?>
                            </strong>

                        </div>
                    </div>

                </nav>


                <?php include 'voto/aguardando.php'; ?>

                <?php include '../pages/footer.php'; ?>


            </body>

            </html>
            <?php
        } else {
            $_SESSION['access'] = sha1(date("d/m/Y"));
            echo '<script>window.location.href = "index.php";</script>';
        }
    }

}

$newObjPainel = new painel();