<?php
if (!isset($_SESSION)) {
    session_start();
}

$idFestival = $_SESSION['festival'];

include("../../../conectaMysqlOO.php");

$idJurado = $_SESSION['idUser'];

$consultaInicial = "SELECT * FROM f_liberacao WHERE status = 1 AND id_festival = $idFestival";

$consultaQtd = "SELECT * FROM f_nota
WHERE id_interprete in(
    SELECT id_interprete FROM f_liberacao 
    WHERE status = 1) AND fase IN(
    	SELECT fase FROM f_liberacao 
    	WHERE status = 1) AND id_jurado = $idJurado;";



$Objf = new conectaMysql();

$qtdLib = $Objf->selectDB($consultaInicial);

$con = $Objf->selectDB($consultaQtd);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">


<link rel="stylesheet" href="../css/main.css">

<div class="container-index" id="container">
    <?php
    if (count($con) != 0 || count($qtdLib) == 0) {
    ?>
    <h1 style="margin-top: 100px;">Aguardando interprete...</h1>
    <script>
        $(function () {
            var current_progress = 0;
            var interval = setInterval(function () {
                current_progress += 1;
                $("#dynamic")
                    .css("width", current_progress * 10 + "%")
                    .attr("aria-valuenow", current_progress * 10)
                    .text(10 - current_progress + " segundos para atualizar a página...");
                if (current_progress >= 10) {
                    clearInterval(interval);
                    window.location.reload()
                }
            }, 1000);
        });
    </script>
    <div class="progress progress-striped active" style="width: 70%;">
        <div id="dynamic" class="bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
            style="width: 0%">
            <span id="current-progress"></span>
        </div>
    </div>
    <?php
    } else {
        include 'voto.php';
    }
        ?>

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