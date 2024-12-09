<?php
error_reporting(0);
if (!isset($_SESSION)) {
    session_start();
}
include("../../conectaMysqlOO.php");


$consultaF = "select * from f_config ORDER BY id DESC LIMIT 1";

$ObjF = new conectaMysql();

$conF = $ObjF->selectDB($consultaF);

foreach ($conF as $item) {
    $festival = $item->festival_ativo;
}
$dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$cod_interprete = $dadosForm["cod_interprete"];

// Capturar inscrições do banco
$sql_code = "select * from f_inscricao where id = '" . $cod_interprete . "'";

$ObjI = new conectaMysql();

$con = $ObjI->selectDB($sql_code);


?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" media="screen" href="../../css/main.css" />

<meta charset="utf-8" />
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<script src="../../js/jqueryFest.js"></script>
<?php
include '../header.php';
?>
<div class="container-index" id="container">
    <fieldset style="width: 90%;">

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <legend>Informações complementares
            <span style="float: right; font-size: 16px;"><a href="#" onclick="goBack()"><img width="20"
                        src="../../img/back.png"> Voltar</a></span>
        </legend>

        <?php
        function data($data)
        {
            return date("d/m/Y", strtotime($data));
        }

        foreach ($con as $item) {
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5  class="card-title"> Informações do interprete</h5>';
            echo '<hr class="border opacity-50" />';

            echo '<div class="row-fluid">';
            echo '<div class="span6">';
            echo 'Código de inscrição <h5>' . $item->id . '</h5>';
            echo '</div>';
            echo '<div class="span6">';
            echo 'Nome do interprete <h5> ' . $item->nome . '</h5></div></div>';

            echo '<div class="row-fluid">';

            echo '<div class="span2">';
            echo 'Data de nascimento <h5> ' . data($item->nascimento) . ' </h5>';
            echo '</div>';
            echo '<div class="span1">';
            echo 'RG <h5> ' . $item->rg . ' </h5>';
            echo '</div>';
            echo '<div class="span2">';
            echo 'CPF <h5> ' . $item->cpf . ' </h5>';
            echo '</div>';
            echo '<div class="span2">';
            echo 'Telefone <h5>' . $item->telefone . ' </h5>';
            echo '</div>';
            echo '<div class="span2">';
            echo 'Celular <h5>' . $item->celular . ' </h5>';
            echo '</div>';
            echo '<div class="span3">';
            echo 'E-mail <h5> ' . $item->email . ' </h5>';
            echo '</div>';

            echo '</div>';

            echo '<p><div class="row-fluid">';
            echo '<div class="span2">';
            echo 'CEP <h5> ' . $item->cep . '</h5>';
            echo '</div>';
            echo '<div class="span1">';
            echo 'UF <h5> ' . $item->uf . '</h5>';
            echo '</div>';
            echo '<div class="span2">';
            echo 'Rua <h5> ' . $item->rua . '</h5>';
            echo '</div>';
            echo '<div class="span2">';
            echo 'Número <h5> ' . $item->numero . '</h5>';
            echo '</div>';
            echo '<div class="span2">';
            echo 'Bairro <h5> ' . $item->bairro . '</h5>';
            echo '</div>';
            echo '<div class="span3">';
            echo 'Cidade <h5> ' . $item->cidade . '</h5>';
            echo '</div>';
            echo '</div></p>';

            if ($item->informacoes_interprete != "") {
                echo '<p><div class="row-fluid">';
                echo '<div class="span12">';
                echo 'Observações do interprete <h5>' . $item->informacoes_interprete . '</h5>';
                echo '</div>';
                echo '</div></p>';
            }

            echo '</div>';
            echo '</div>';

            echo '<div class="card mt-3">';
            echo '<div class="card-body">';
            echo '<h5  class="card-title"> Informações da apresentação</h5>';
            echo '<hr class="border opacity-50" />';

            echo '<p><div class="row-fluid">';
            echo '<div class="span4">';
            echo 'Canção <h5> ' . $item->cancao . '</h5>';
            echo '</div>';
            echo '<div class="span4">';
            echo 'Compositor <h5> ' . $item->compositor . '</h5>';
            echo '</div>';
            echo '<div class="span4">';
            echo 'Gravado por <h5> ' . $item->gravado_por . '</h5>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            if ($item->informacao_cancao != "") {
                echo '<p><div class="row-fluid">';
                echo '<div class="span12">';
                echo 'Observações da apresentação <h5> ' . $item->informacao_cancao . '</h5>';
                echo '</div>';
                echo '</div></p>';
            }

            echo '</div>';

        }
        ?>

    </fieldset>
</div>
<?php
include '../footer.php';
?>