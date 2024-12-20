<?php
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION)) {
    session_start();
}
$chave = md5(date("d/m/Y"));
if (isset($_SESSION['logado']) == $chave) {
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
        $afinacao = "afinacao_c_regra";
        $interpretacao = "interpretacao_c_regra";
        $ritmo = "ritmo_c_regra";
    } else {
        $regra = "nota_s_regra";
        $afinacao = "afinacao_s_regra";
        $interpretacao = "interpretacao_s_regra";
        $ritmo = "ritmo_s_regra";
    }

    if ($fase == "1") {

        $consultaInscrito = "SELECT 
    f_inscricao.id, 
    GROUP_CONCAT(DISTINCT f_inscricao.festival) AS festival,
    GROUP_CONCAT(DISTINCT f_inscricao.nome) AS nome,
    GROUP_CONCAT(DISTINCT f_inscricao.cidade) AS cidade,
    GROUP_CONCAT(DISTINCT f_inscricao.uf) AS uf,
    GROUP_CONCAT(DISTINCT f_inscricao.cancao) AS cancao,
    GROUP_CONCAT(DISTINCT f_inscricao.gravado_por) AS gravado_por,
    f_nota.fase, 
    f_nota.id_interprete, 

    AVG(f_nota.afinacao) AS afinacao_s_regra, 
    AVG(f_nota.interpretacao) AS interpretacao_s_regra, 
    AVG(f_nota.ritmo) AS ritmo_s_regra, 
    AVG(f_nota.nota) AS nota_s_regra, 

    (SUM(f_nota.afinacao) - (MIN(f_nota.afinacao) + MAX(f_nota.afinacao))) / (COUNT(f_nota.afinacao) - 2) AS afinacao_c_regra, 
    (SUM(f_nota.interpretacao) - (MIN(f_nota.interpretacao) + MAX(f_nota.interpretacao))) / (COUNT(f_nota.interpretacao) - 2) AS interpretacao_c_regra, 
    (SUM(f_nota.ritmo) - (MIN(f_nota.ritmo) + MAX(f_nota.ritmo))) / (COUNT(f_nota.ritmo) - 2) AS ritmo_c_regra, 

    (SUM(f_nota.afinacao) - (MIN(f_nota.afinacao) + MAX(f_nota.afinacao))) / (COUNT(f_nota.afinacao) - 2) / 3 +
    (SUM(f_nota.interpretacao) - (MIN(f_nota.interpretacao) + MAX(f_nota.interpretacao))) / (COUNT(f_nota.interpretacao) - 2) / 3 +
    (SUM(f_nota.ritmo) - (MIN(f_nota.ritmo) + MAX(f_nota.ritmo))) / (COUNT(f_nota.ritmo) - 2) / 3
    AS nota_c_regra

FROM 
    f_inscricao
INNER JOIN 
    f_nota ON f_inscricao.id = f_nota.id_interprete
WHERE 
    f_nota.fase = 1
    AND f_nota.genero LIKE '$nome_categoria'
    AND f_inscricao.festival LIKE '$idFestival'
GROUP BY 
    f_nota.id_interprete
ORDER BY 
    $regra DESC, 
    afinacao_s_regra DESC, 
    interpretacao_s_regra DESC, 
    ritmo_s_regra DESC
LIMIT 
    $qtd_class_seg_fase;
";


    } else if ($fase == "2") {
        $consultaInscrito = "SELECT 
    f_inscricao.id, 
    GROUP_CONCAT(DISTINCT f_inscricao.festival) AS festival, 
    GROUP_CONCAT(DISTINCT f_inscricao.nome) AS nome,
    GROUP_CONCAT(DISTINCT f_inscricao.cidade) AS cidade,
    GROUP_CONCAT(DISTINCT f_inscricao.uf) AS uf,
    GROUP_CONCAT(DISTINCT f_inscricao.cancao) AS cancao,
    GROUP_CONCAT(DISTINCT f_inscricao.gravado_por) AS gravado_por,
    f_nota.fase, 
    f_nota.id_interprete, 

    AVG(f_nota.afinacao) AS nota_afinacao, 
    AVG(f_nota.interpretacao) AS nota_interpretacao, 
    AVG(f_nota.ritmo) AS nota_ritmo, 
    AVG(f_nota.nota) AS nota_s_regra, 

    -- Calculo da nota de controle (sem os valores extremos)
    (SUM(f_nota.nota) - (MIN(f_nota.nota) + MAX(f_nota.nota))) / (COUNT(f_nota.nota) - 2) AS nota_c_regra,

    -- As menores e maiores notas
    MIN(f_nota.nota) AS menor_nota, 
    MAX(f_nota.nota) AS maior_nota

FROM 
    f_inscricao
INNER JOIN 
    f_nota ON f_inscricao.id = f_nota.id_interprete
WHERE 
    f_nota.fase = 2
    AND f_nota.genero LIKE '$nome_categoria'
    AND f_inscricao.festival LIKE '$idFestival'
GROUP BY 
    f_nota.id_interprete
ORDER BY 
    $regra DESC, 
    nota_afinacao DESC, 
    nota_interpretacao DESC, 
    nota_ritmo DESC
LIMIT 
    $qtd_class_final;
";

    }

    $date = date("Y-m-d");


    $ObjInscrito = new conectaMysql();

    $conInscrito = $ObjInscrito->selectDB($consultaInscrito);


    ?>
    <html>
        <head>
            <title>Resultado <?php echo $fase ?> fase <?php echo $_SESSION['nome_festival'] ?></title>
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
                    font-size:10px!important;
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
                    <legend>Listagem de classificação de interpretes e 
                        <?php
                        if ($fase == 1) {
                            echo 'notas fase classificatória';
                        } elseif ($fase == 2) {
                            echo 'notas fase eliminatória';
                        } else {
                            echo 'notas fase final';
                        }
                        ?> - Categoria: <span style="text-transform: capitalize;"><?php echo $nome_categoria ?></span>
                    </legend>
                    <table class="table table-striped" style="font-size:12px!important;">
                        <thead>
                            <tr>
                                <th>Colocação</th>
                                <th>Inscrição</th>
                                <th>Interprete</th>
                                <th>Cidade/UF</th>
                                <th>Canção</th>
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            function data($data)
                            {
                                return date("d/m/Y", strtotime($data));
                            }
                            $i = 1;
                            foreach ($conInscrito as $item) {
                                if ($_SESSION['exclusao_notas'] == 0) {
                                    $regraNota = $item->nota_c_regra;
                                    $regraAfinacao = $item->afinacao_c_regra;
                                    $regraInterpretacao = $item->interpretacao_c_regra;
                                    $regraRitmo = $item->ritmo_c_regra;
                                } else {
                                    $regraNota = $item->nota_s_regra;
                                    $regraAfinacao = $item->afinacao_s_regra;
                                    $regraInterpretacao = $item->interpretacao_s_regra;
                                    $regraRitmo = $item->ritmo_s_regra;
                                }

                                echo '<tr style="text-transform:capitalize; font-size: 15px;"><td style="text-align:center"><b>' . $i . '</b></td><td style="text-align:center"><b>' . $item->id . '</b></td><td><b>' . $item->nome . '</b></td><td><b>' . $item->cidade . '/' . $item->uf . '</b></td><td><b>' . $item->cancao . '</b></td><td style="text-align:right; font-size: 17px;"><b>' . number_format($regraNota, 3, '.', '') . '</b></td></tr>';
                                echo '<tr>';
                                echo '<td colspan="2" style="border:none; align:center">Afinação<br>' . number_format($regraAfinacao, 3, '.', '') . '</td>';
                                echo '<td colspan="2" style="border:none">Interpretação<br>' . number_format($regraInterpretacao, 3, '.', '') . '</td>';
                                echo '<td colspan="2" style="border:none">Ritmo<br>' . number_format($regraRitmo, 3, '.', '') . '</td>';
                                echo '</tr>';
                                $i++;
                            }
                            ?>
                        </tbody>
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