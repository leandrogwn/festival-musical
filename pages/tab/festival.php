<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<script src="./js/jqueryFest.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/datepicker.css">
<script type="text/javascript"
    src="https://rawgithub.com/dangrossman/bootstrap-daterangepicker/master/daterangepicker.js"></script>
<div class="container-index" id="container">
    <form action="pages/cadastro/festival.php" method="post" style="width: 90%;">
        <fieldset>
            <?php
            if (isset($_SESSION['msg_festival'])) {
                echo $_SESSION['msg_festival'];
                unset($_SESSION['msg_festival']);
            }
            ?>
            <legend>Cadastro de festival</legend>
            <div class="row-fluid">
                <div class="span7">

                    <label>Nome do festival</label>
                    <input type="text" id="nome_festival" name="nome_festival" style="width: 100%;" required>
                </div>
                <div class="span5">

                    <label>Data de início e fim</label>

                    <input type="text" id="periodo_festival" name="periodo_festival" value="01/01/2015 - 21/12/2015"
                    style="width: 100%;">
                </div>
            </div>
            <label>Infomaçõs adicionais</label>
            <input type="text" id="informacao_festival" name="informacao_festival" style="width: 100%;">
        </fieldset>
        <div class="modal-footer">
            <input class="btn btn-primary" id="botao-festival" type="submit" value="Inserir festival">
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".alert").fadeTo(6000, 500).slideUp(500, function () {
            $(".alert").slideUp(500);
        });
        $(".close").click(function () {
            $(".alert").hide();
            location.reload();
        });
    });

    $('input[name="periodo_festival"]').daterangepicker({
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "De",
            "toLabel": "Até",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sáb"
            ],
            "monthNames": [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ],
            "firstDay": 0
        }
    });
</script>