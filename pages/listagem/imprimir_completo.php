<?php
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['festival'])) {
    include("../../conectaMysqlOO.php");
    include("../../conectaMysql.php");

    $dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $fase = $dadosForm["liberacao_fase"];
    $nome_categoria = $dadosForm["liberacao_categoria"];
    $idFestival = $_SESSION['festival'];
    $qtd_class_seg_fase = $_SESSION['qtd_class_seg_fase'];
    $qtd_class_final = $_SESSION['qtd_class_final'];

    if ($_SESSION['exclusao_notas'] == 0) {
        $regra = "nota_c_regra";
    } else {
        $regra = "nota_s_regra";
    }

    if ($fase == "1") {
        $consultaInscrito = "select f_inscricao.*, f_primeira_fase.id_interprete, f_primeira_fase.categoria
from f_inscricao
inner join f_primeira_fase
on f_inscricao.festival like '$idFestival'
and f_inscricao.id = f_primeira_fase.id_interprete
and f_primeira_fase.categoria like '$nome_categoria'";
    } else if ($fase == "2") {
        $consultaInscrito = "select f_inscricao.*, f_nota.fase, f_nota.id_interprete, avg(f_nota.nota) as nota_s_regra, (sum(f_nota.nota)-(min(f_nota.nota)+max(f_nota.nota)))/(count(f_nota.nota)-2) as nota_c_regra, min(f_nota.nota) as menor_nota, max(f_nota.nota) as maior_nota
from f_inscricao
inner join f_nota
on f_inscricao.festival like '$idFestival'
and f_inscricao.id = f_nota.id_interprete
and f_nota.fase = 2
and f_nota.genero like '$nome_categoria'
group by f_nota.id_interprete order by $regra desc limit $qtd_class_final";
    } else if ($fase == "3") {
        $consultaInscrito = "select f_inscricao.*, f_nota.fase, f_nota.id_interprete, avg(f_nota.nota) as nota_s_regra, (sum(f_nota.nota)-(min(f_nota.nota)+max(f_nota.nota)))/(count(f_nota.nota)-2) as nota_c_regra, min(f_nota.nota) as menor_nota, max(f_nota.nota) as maior_nota
from f_inscricao
inner join f_nota
on f_inscricao.festival like '$idFestival'
and f_inscricao.id = f_nota.id_interprete
and f_nota.fase = 3
and f_nota.genero like '$nome_categoria'
group by f_nota.id_interprete order by $regra desc";
    }
    $date = date("Y-m-d");


    $ObjInscrito = new conectaMysql();

    $conInscrito = $ObjInscrito->selectDB($consultaInscrito);
    ?>
    <html>
        <head>
            <title>Listagem <?php echo $fase ?> fase <?php echo $_SESSION['nome_festival'] ?></title>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" media="screen" href="../../css/main.css"/>
            <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">

            <!--Let browser know website is optimized for mobile-->
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
            <script src="../../js/jquery-3.3.1.min.js" type="text/javascript"></script>

            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <link rel="shortcut icon" href="../../img/festIbemaFavicon.png" type="image/x-icon">
            <style>
                /*
                 * General styles
                 */
                body, html {
                    height: 100%;
                }

                .card-container.card {
                    max-width: 350px;
                    padding: 40px 40px;
                }

                .btn {
                    font-weight: 700;
                    height: 36px;
                    -moz-user-select: none;
                    -webkit-user-select: none;
                    user-select: none;
                    cursor: default;
                }

                /*
                 * Card component
                 */
                .card {
                    background-color: #F7F7F7;
                    /* just in case there no content*/
                    padding: 20px 25px 30px;
                    margin: 0 auto 25px;
                    margin-top: 50px;
                    /* shadows and rounded borders */
                    -moz-border-radius: 2px;
                    -webkit-border-radius: 2px;
                    border-radius: 2px;
                    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                }

                .profile-img-card {
                    width: 96px;
                    height: 96px;
                    margin: 0 auto 10px;
                    display: block;

                }

                /*
                 * Form styles
                 */
                .profile-name-card {
                    font-size: 16px;
                    font-weight: bold;
                    text-align: center;
                    margin: 10px 0 0;
                    min-height: 1em;
                }

                .reauth-email {
                    display: block;
                    color: #404040;
                    line-height: 2;
                    margin-bottom: 10px;
                    font-size: 14px;
                    text-align: center;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    -moz-box-sizing: border-box;
                    -webkit-box-sizing: border-box;
                    box-sizing: border-box;
                }

                .form-signin #inputEmail,
                .form-signin #inputPassword {
                    direction: ltr;
                    height: 44px;
                    font-size: 16px;
                }

                .form-signin input[type=email],
                .form-signin input[type=password],
                .form-signin input[type=text],
                .form-signin button {
                    width: 100%;
                    display: block;
                    margin-bottom: 10px;
                    z-index: 1;
                    position: relative;
                    -moz-box-sizing: border-box;
                    -webkit-box-sizing: border-box;
                    box-sizing: border-box;
                }

                .form-signin .form-control:focus {
                    border-color: rgb(104, 145, 162);
                    outline: 0;
                    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
                    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
                }

                .btn.btn-signin {
                    /*background-color: #4d90fe; */
                    background-color: rgb(104, 145, 162);
                    /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
                    padding: 0px;
                    font-weight: 700;
                    font-size: 14px;
                    height: 36px;
                    -moz-border-radius: 3px;
                    -webkit-border-radius: 3px;
                    border-radius: 3px;
                    border: none;
                    -o-transition: all 0.218s;
                    -moz-transition: all 0.218s;
                    -webkit-transition: all 0.218s;
                    transition: all 0.218s;
                }

                .btn.btn-signin:hover,
                .btn.btn-signin:active,
                .btn.btn-signin:focus {
                    background-color: rgb(12, 97, 33);
                }

                .forgot-password {
                    color: rgb(104, 145, 162);
                }

                .forgot-password:hover,
                .forgot-password:active,
                .forgot-password:focus{
                    color: rgb(12, 97, 33);
                }
                .card{
                    margin-top: 15%;
                }

            </style>
        </head>
        <body>

            <div class="container-index" id="container">
                <h2> <?php
                echo $_SESSION['nome_festival'];
                ?></h2>
                <fieldset>
                    <legend>Listagem completa dos dados dos interpretes da 
                        <?php
                        if ($fase == 1) {
                            echo 'fase classificatória';
                        } elseif ($fase == 2) {
                            echo 'fase eliminatória';
                        } else {
                            echo 'fase final';
                        }
                        ?> - Categoria: <span style="text-transform: capitalize;"><?php echo $nome_categoria ?></span>
                    </legend>
                    <table class="table table-striped">
                        <?php

                        function data($data)
                        {
                            return date("d/m/Y", strtotime($data));
                        }

                        foreach ($conInscrito as $item) {
                            echo '<tr style="text-transform:capitalize;">'
                                . '<td><b> Código de inscrição:</b> ' . $item->id
                                . '<br><b> Nome do interprete:</b> ' . $item->nome
                                . '<br><b> Data de nascimento:</b> ' . data($item->nascimento) . ' <b> RG:</b> ' . $item->rg . ' <b> CPF:</b> ' . $item->cpf . ' <b> Telefone: </b>' . $item->telefone . ' <b> Celular: </b>' . $item->celular
                                . '<br><b> E-mail:</b> ' . $item->email
                                . '<br><b> Observações do interprete:</b> ' . $item->informacoes_interprete
                                . '<br><b> CEP:</b> ' . $item->cep . '<b> UF:</b> ' . $item->uf . '<b> Rua:</b> ' . $item->rua . '<b> Número:</b> ' . $item->numero
                                . '<br><b> Bairro:</b> ' . $item->bairro . '<b> Cidade:</b> ' . $item->cidade
                                . '<br><b> Informações da apresentação</b>'
                                . '<br><b> Canção:</b> ' . $item->cancao . '<b> Compositor:</b> ' . $item->compositor . '<b> Gravado por:</b> ' . $item->gravado_por
                                . '<br><b> Observações da apresentação:</b> ' . $item->informacao_cancao;
                            echo '</td></tr>';
                        }
                        ?>
                    </table>

                </fieldset>
                <script type="text/javascript">
                    $(document).ready(function () {
                        print();
                    });
                </script>
            </div>
        </body>
    </html>
    <?php
} else {
    $_SESSION['access'] = sha1(date("d/m/Y"));
    echo '<script>window.location.href = "../../index.php";</script>';
}
?>