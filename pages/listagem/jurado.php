<?php
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION)) {
    session_start();
}
include("../../conectaMysqlOO.php");
include("../../conectaMysql.php");

$idFestival = $_SESSION['festival'];

$consultaJurado = "select * from f_jurado where festival  = $idFestival";

$ObjJurado = new conectaMysql();

$conJurado = $ObjJurado->selectDB($consultaJurado);


?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" media="screen" href="../../css/main.css" />
<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
<link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">

<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="../../js/jquery-3.3.1.min.js" type="text/javascript"></script>

<?php include '../../pages/header.php'; ?>

<div class="container-index" id="container">
    <fieldset style="width: 90%;">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php

        if (isset($_SESSION['lista_jurado_delete'])) {
                echo '<script>
                Swal.fire({
                    title: \'Exclusão de jurado\',
                    text: \'Jurado excluído com sucesso!\',
                    icon: \'success\',
                    confirmButtonText: \'Ok\'
                  })
            </script>';
                unset($_SESSION['lista_jurado_delete']);

            }
        ?>

        <legend>Listagem de jurados
        </legend>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Informação</th>
                    <th>Login</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($conJurado as $item) {
                    echo '<tr style="text-transform:capitalize;"><td style="vertical-align: middle;">' . $item->nome . '</td><td style="vertical-align: middle;">' . $item->informacao . '</td><td style="vertical-align: middle;">' . $item->login . '</td><td class="col row"><a class="btn btn-sm btn-primary" href="../deleta/excluir_jurado.php?festival=' . $idFestival . '&id_jurado=' . $item->id . '&tela=lista_jurado_delete" target="_top">excluir</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </fieldset>
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

<?php include '../../pages/footer.php'; ?>