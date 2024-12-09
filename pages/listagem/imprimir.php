<?php
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION)) {
    session_start();
}
include ("../../conectaMysqlOO.php");
include ("../../conectaMysql.php");

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
    $letra = "letra_c_regra";
} else {
    $regra = "nota_s_regra";
    $afinacao = "afinacao_s_regra";
    $interpretacao = "interpretacao_s_regra";
    $ritmo = "ritmo_s_regra";
    $letra = "letra_s_regra";
}

if ($fase == "1") {
    
    $consultaInscrito = "select 
    f_inscricao.id, 
    f_inscricao.festival,
    f_inscricao.nome, 
    f_inscricao.cidade, 
    f_inscricao.uf, 
    f_inscricao.cancao, 
    f_inscricao.gravado_por, 
    f_nota.fase, 
    f_nota.id_interprete, 

    avg(f_nota.afinacao) as afinacao_s_regra, 
    avg(f_nota.interpretacao) as interpretacao_s_regra, 
    avg(f_nota.ritmo) as ritmo_s_regra, 
    avg(f_nota.letra) as letra_s_regra, 
    
    avg(f_nota.nota) as nota_s_regra, 

    (sum(f_nota.afinacao)-(min(f_nota.afinacao)+max(f_nota.afinacao)))/(count(f_nota.afinacao)-2) as afinacao_c_regra, 
    (sum(f_nota.interpretacao)-(min(f_nota.interpretacao)+max(f_nota.interpretacao)))/(count(f_nota.interpretacao)-2) as interpretacao_c_regra, 
    (sum(f_nota.ritmo)-(min(f_nota.ritmo)+max(f_nota.ritmo)))/(count(f_nota.ritmo)-2) as ritmo_c_regra, 
    (sum(f_nota.letra)-(min(f_nota.letra)+max(f_nota.letra)))/(count(f_nota.letra)-2) as letra_c_regra, 

    (sum(f_nota.afinacao)-(min(f_nota.afinacao)+max(f_nota.afinacao)))/(count(f_nota.afinacao)-2)/4+
    (sum(f_nota.interpretacao)-(min(f_nota.interpretacao)+max(f_nota.interpretacao)))/(count(f_nota.interpretacao)-2)/4+
    (sum(f_nota.ritmo)-(min(f_nota.ritmo)+max(f_nota.ritmo)))/(count(f_nota.ritmo)-2)/4+
    (sum(f_nota.letra)-(min(f_nota.letra)+max(f_nota.letra)))/(count(f_nota.letra)-2)/4
    as nota_c_regra
    
    from f_inscricao
    inner join f_nota
    on f_inscricao.id = f_nota.id_interprete
    and f_nota.fase = 1
    and f_nota.genero like '$nome_categoria'
    and f_inscricao.festival like '$idFestival'
    group by 
    f_nota.id_interprete order by $regra desc, 
    $afinacao desc, 
    $interpretacao desc, 
    $ritmo desc,
    $letra desc limit $qtd_class_seg_fase";


} else if ($fase == "2") {
    $consultaInscrito = "select f_inscricao.id, f_inscricao.festival, f_inscricao.nome, f_inscricao.cidade, f_inscricao.uf, f_inscricao.cancao, f_inscricao.gravado_por, f_nota.fase, f_nota.id_interprete, avg(f_nota.afinacao) as nota_afinacao, avg(f_nota.interpretacao) as nota_interpretacao, avg(f_nota.ritmo) as nota_ritmo, avg(f_nota.letra) as nota_letra, avg(f_nota.nota) as nota_s_regra, (sum(f_nota.nota)-(min(f_nota.nota)+max(f_nota.nota)))/(count(f_nota.nota)-2) as nota_c_regra, min(f_nota.nota) as menor_nota, max(f_nota.nota) as maior_nota
from f_inscricao
inner join f_nota
on f_inscricao.id = f_nota.id_interprete
and f_nota.fase = 2
and f_nota.genero like '$nome_categoria'
and f_inscricao.festival like '$idFestival'
group by f_nota.id_interprete order by $regra desc, nota_afinacao desc, nota_interpretacao desc, nota_ritmo desc, nota_letra desc limit $qtd_class_final";
} else if ($fase == "3") {
    $consultaInscrito = "select f_inscricao.id, f_inscricao.festival, f_inscricao.nome, f_inscricao.cidade, f_inscricao.uf, f_inscricao.cancao, f_inscricao.gravado_por, f_nota.fase, f_nota.id_interprete, avg(f_nota.afinacao) as nota_afinacao, avg(f_nota.interpretacao) as nota_interpretacao, avg(f_nota.ritmo) as nota_ritmo, avg(f_nota.letra) as nota_letra, avg(f_nota.nota) as nota_s_regra, (sum(f_nota.nota)-(min(f_nota.nota)+max(f_nota.nota)))/(count(f_nota.nota)-2) as nota_c_regra, min(f_nota.nota) as menor_nota, max(f_nota.nota) as maior_nota
from f_inscricao
inner join f_nota
on f_inscricao.id = f_nota.id_interprete
and f_nota.fase = 3
and f_nota.genero like '$nome_categoria'
and f_inscricao.festival like '$idFestival'
group by f_nota.id_interprete order by $regra desc, nota_afinacao desc, nota_interpretacao desc, nota_ritmo desc, nota_letra desc";

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
                            <th>
                            Nota
                            <?php
                            /*if ($fase == 1) {
                                echo 'Nota 1ª fase';
                            } elseif ($fase == 2) {
                                echo 'Nota 2ª fase';
                            } else {
                                echo 'Nota final';
                            }*/
                            ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						 function data($data) {
                        return date("d/m/Y", strtotime($data));
                    }
						$i = 1;
                        foreach ($conInscrito as $item) {
                            if ($_SESSION['exclusao_notas'] == 0) {
                                $regraNota = $item->nota_c_regra;
                                $regraAfinacao = $item->afinacao_c_regra;
                                $regraInterpretacao = $item->interpretacao_c_regra;
                                $regraRitmo = $item->ritmo_c_regra;
                                $regraLetra = $item->letra_c_regra;
                            } else {
                                $regraNota = $item->nota_s_regra;
                                $regraAfinacao = $item->afinacao_s_regra;
                                $regraInterpretacao = $item->interpretacao_s_regra;
                                $regraRitmo = $item->ritmo_s_regra;
                                $regraLetra = $item->letra_s_regra;                                
                            }

                            echo '<tr style="text-transform:capitalize; font-size: 15px;"><td style="text-align:center"><b>' . $i . '</b></td><td style="text-align:center"><b>' . $item->id . '</b></td><td><b>' . $item->nome . '</b></td><td><b>' . $item->cidade . '/'. $item->uf .'</b></td><td><b>' . $item->cancao . '</b></td><td style="text-align:right; font-size: 17px;"><b>' . number_format($regraNota, 3, '.', '') . '</b></td></tr>';
                            echo '<tr>';
                            echo '<td colspan="2" style="border:none; align:center">Afinação<br>'. number_format($regraAfinacao, 3, '.', '' ) .'</td>';
                            echo '<td colspan="1" style="border:none">Interpretação<br>'. number_format($regraInterpretacao, 3, '.', '' ) .'</td>';
                            echo '<td colspan="1" style="border:none">Ritmo<br>'. number_format($regraRitmo, 3, '.', '' )  .'</td>';
                            echo '<td colspan="1" style="border:none">Letra<br>'. number_format($regraLetra, 3, '.', '' ) .'</td>';
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