<?php
header("Content-Type: text/html; charset=utf-8", true);
header('Cache-Control: no-cache');
header('Pragma: no-cache');
if (!isset($_SESSION)) {
    session_start();
}

$consulta = "SELECT f_inscricao.id, f_inscricao.festival, f_inscricao.nome, f_inscricao.cancao, f_inscricao.gravado_por, f_inscricao.letra, f_liberacao.fase 
FROM f_inscricao 
INNER JOIN f_liberacao
ON f_inscricao.id = f_liberacao.id_interprete
AND f_liberacao.status = 1
";

$Objf = new conectaMysql();

$con = $Objf->selectDB($consulta);
?>
<div class="container-index" id="container" style="width: 100%;">
    <form action="pages/cadastro/nota.php" id="form-nota" method="post" style="width: 90%;">
        <fieldset>
            <?php
            if (isset($_SESSION['msg_fase'])) {
                echo $_SESSION['msg_fase'];
                unset($_SESSION['msg_fase']);
            }
            ?>
            <legend>Apresentação</legend>
            <hr>
            <?php
            foreach ($con as $item) {
                $id_jurado = $_SESSION['idUser'];
                echo '<input type = "hidden" name = "fase" id = "fase" value="' . $item->fase . '">';
                echo '<input type = "hidden" name="tela" id="tela" value="voto-ok">';
                echo '<input type = "hidden" name = "id_interprete" id = "id_interprete" value="' . $item->id . '">';
                echo '<input type = "hidden" name = "id_jurado" id = "id_jurado" value="' . $id_jurado . '">';
                echo '<div class = "row-fluid">';
                echo '<div class = "span6">';
                echo '<label>Interprete</label>';
                echo '<span><h4>' . $item->nome . ' </h4></span>';
                echo '<label>Canção</label>';
                echo '<span><h4>' . $item->cancao . ' - ' . $item->gravado_por . ' </h4></span>';

                if ($item->informacoes_interprete != "") {
                    echo '<label>Observações do interprete</label>';
                    echo '<span><h4>' . $item->informacoes_interprete . ' </h4></span>';
                }

                if ($item->informacao_cancao != "") {
                    echo '<label>Observações da canção</label>';
                    echo '<span><h4>' . $item->informacao_cancao . ' </h4></span>';
                }
                
                echo '</div>';
                
                echo '<div class = "span6">';
                echo '<label>Letras da canção</label>';
                echo '<span><h4>' . $item->letra . ' </h4></span>';
                echo '</div>';
                
            ?>

        </fieldset>
        <fieldset class="mt-4">
            <legend>Avaliação</legend>
            <hr>
            <label>
                <h4>Nota</h4>
            </label>
            <input type="text" id="nota" name="nota" style="width: 100%; height: 50px; font-size: 30px;" class="center"
                placeholder="Nota do interprete. Ex: 5.55" pattern="^\d(\.\d{1,2}|,\d{1,2})?|10$?">
        </fieldset>
        <div class="modal-footer">
            <input class="btn btn-primary" id="botao-submit" value="Enviar avaliação" onclick="sweetalert()">
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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function sweetalert() {
            var nota = document.getElementById('nota').value;
            Swal.fire({
                title: 'Atenção!',
                html: "Confirma a nota <br><b>" + nota + "</b><br>para o interprete <?php echo $item->nome ?>? ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Confirmar',

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("form-nota").submit();

                }
            })
        }
    </script>
</div>