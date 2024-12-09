<?php
if (!isset($_SESSION)) {
    session_start();
}
include ("../../conectaMysqlOO.php");
$consulta = "select * from f_festival";

$Objf = new conectaMysql();

$con = $Objf->selectDB($consulta);
?>
<div class="container-index" id="container">
    <form action="pages/cadastro/fase.php" method="post" style="width: 70%;">
        <fieldset>
            <?php
            if (isset($_SESSION['msg_fase'])) {
                echo $_SESSION['msg_fase'];
                unset($_SESSION['msg_fase']);
            }
            ?>
            <legend>Cadastro de fases</legend>
            <label>Festival</label>
            <select id="festival_fase" name="festival_fase" style="width: 100%;">';
                <?php
                foreach ($con as $item) {
                    echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                }
                ?>
            </select>
            <label>Nome da fase</label>

            <input type="text" id="" name="nome_fase" style="width: 170px;" >

            <label>Data da fase</label>
            <input type="date" id="data_fase" name="data_fase" style="width: 170px;">
            <label>Infomaçõs adicionais/Outros</label>
            <input type="text" id="informacao_fase" name="informacao_fase" style="width: 100%;">
        </fieldset>
        <div class="modal-footer">
            <a href="#">listar fases</a>
            <input class="btn btn-primary" id="botao-submit" type="submit" value="Incluir fase" >
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