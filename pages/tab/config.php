<?php

if (!isset($_SESSION)) {
    session_start();
}

$consulta = "select * from f_festival";


$Objf = new conectaMysql();

$con = $Objf->selectDB($consulta);

include '../header.php';

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" media="screen" href="../../../css/main.css" />
<link href="../../../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">

<div class="container-index" id="container">
    <form action="pages/cadastro/config.php" method="post" style="width: 90%;">
        <fieldset>
            <?php
            if (isset($_SESSION['msg_config'])) {
                echo $_SESSION['msg_config'];
                unset($_SESSION['msg_config']);
            }
            ?>
            <legend>Configurações</legend>
            <label>Festival ativo</label>
            <select id="config_festival_ativo" name="config_festival_ativo" style="width: 100%;" required>';
                <?php
                foreach ($con as $item) {
                    echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                }
                ?>
            </select>
            <label>Quant. de registro por página</label>
            <input type="text" id="config_registro_pagina" name="config_registro_pagina" style="width: 10%;" required>

            <label>Regra de classificação: utilizar maior e menor nota?</label>
            <select id="exclusao_notas" name="exclusao_notas" style="width: 100%;" required>
                <option value="0">Sim</option>
                <option value="1">Não</option>

            </select>

        </fieldset>
        <div class="modal-footer">
            <input class="btn btn-primary" id="botao-insere-jurado" type="submit" value="Atualizar configurações">
        </div>
    </form>
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
</div>
<?php
include '../footer.php';
?>