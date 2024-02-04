<?php
if (!isset($_SESSION)) {
    session_start();
}

$idFestival = $_SESSION['festival'];

$consulta = "SELECT f_inscricao.id, f_inscricao.festival, f_inscricao.nome, f_inscricao.cidade, f_inscricao.uf, f_inscricao.cancao, f_inscricao.informacoes_interprete, f_inscricao.informacao_cancao, f_inscricao.gravado_por, f_inscricao.letra, f_inscricao.categoria, f_liberacao.fase 
FROM f_inscricao 
INNER JOIN f_liberacao
ON f_inscricao.id = f_liberacao.id_interprete
AND f_liberacao.id_festival = $idFestival
AND f_liberacao.status = 1
";

$Objf = new conectaMysql();

$con = $Objf->selectDB($consulta);
?>
<div class="container-index" id="container" style="width: 100%;">
    <form action="voto/nota.php" id="form-nota" method="post" style="width: 90%;">
        <fieldset>
            <?php
            if (isset($_SESSION['msg_fase'])) {
                echo $_SESSION['msg_fase'];
                unset($_SESSION['msg_fase']);
            }
            foreach ($con as $item) {

                echo '<legend>Apresentações ';
                if ($item->fase == 1) {
                    echo '1ª Fase';
                } elseif ($item->fase == 2) {
                    echo '2ª Fase';
                } else {
                    echo 'Fase Final';
                }
                echo '</legend>';

                $id_jurado = $_SESSION['idUser'];
                echo '<input type="hidden" name="genero" id="genero" value="' . $item->categoria . '">';
                echo '<input type="hidden" name="fase" id="fase" value="' . $item->fase . '">';
                echo '<input type="hidden" name="tela" id="tela" value="enviook">';
                echo '<input type="hidden" name="id_interprete" id="id_interprete" value="' . $item->id . '">';
                echo '<input type="hidden" name="id_jurado" id="id_jurado" value="' . $id_jurado . '">';
                echo '<div class="row-fluid">';
                echo '<div class="span6">';
                echo '<label>Interprete</label>';
                echo '<span><h4>' . $item->nome . ' </h4></span>';
                echo '<label>Categoria</label>';
                echo '<span style="text-transform: capitalize;"><h4>' . $item->categoria . ' </h4></span>';
                echo '<label>Canção</label>';
                echo '<span><h4>' . $item->cancao . ' - ' . $item->gravado_por . ' </h4></span>';
                echo '<label>Cidade/UF</label>';
                echo '<span><h4>' . $item->cidade . ' - ' . $item->uf . '</h4></span>';
                echo '<label>Observações do interprete</label>';
                if ($item->informcoes_interprete != "") {
                    echo '<span><h4>' . $item->informacoes_interprete . ' </h4></span>';
                }

                if ($item->informacao_cancao != "") {
                    echo '<label>Observações da canção</label>';
                    echo '<span><h4>' . $item->informacao_cancao . ' </h4></span>';
                }
                echo '</div>';
                echo '<div class="span6">';
                echo '<label>Letra da canção</label>';
                echo '<span><h4>' . $item->letra . ' </h4></span>';
                echo '</div>';
            }
            ?>

        </fieldset>

        <fieldset class="row mt-4">
            <legend>Critérios de avaliação</legend>
            <div class="row">
                
                <div class="col">
                    <label for="afinacao">
                        <h4>Afinação</h4>
                    </label>
                    <input type="text" min="0" max="100" id="afinacao" name="afinacao"
                        style="width: 100%; height: 50px; font-size: 30px;" class="center"
                        placeholder="Notas de 0,01 a 10" required maxlength="4" pattern="^\d(\.\d{1,2}|,\d{1,2})?|10$"
                        onkeyup="mediaNota()" onchange="verificaCriterio('afinacao')">
                </div>
                
                <div class="col">
                    <label for="interpretacao">
                        <h4>Interpretação(Apresentação)</h4>
                    </label>
                    <input type="text" min="0" max="100" id="interpretacao" name="interpretacao"
                        style="width: 100%; height: 50px; font-size: 30px;" class="center"
                        placeholder="Notas de 0,01 a 10" required maxlength="4" pattern="^\d(\.\d{1,2}|,\d{1,2})?|10$"
                        onkeyup="mediaNota()" onchange="verificaCriterio('interpretacao')">
                </div>
                
                <div class="col">
                    <label for="ritmo">
                        <h4>Ritmo</h4>
                    </label>
                    <input type="text" min="0" max="100" id="ritmo" name="ritmo"
                        style="width: 100%; height: 50px; font-size: 30px;" class="center"
                        placeholder="Notas de 0,01 a 10" required maxlength="4" pattern="^\d(\.\d{1,2}|,\d{1,2})?|10$"
                        onkeyup="mediaNota()" onchange="verificaCriterio('ritmo')">
                </div>

                <div class="col">
                    <label for="letra">
                        <h4>Letra</h4>
                    </label>
                    <input type="text" min="0" max="100" id="nota_letra" name="nota_letra"
                        style="width: 100%; height: 50px; font-size: 30px;" class="center"
                        placeholder="Notas de 0,01 a 10" required maxlength="4" pattern="^\d(\.\d{1,2}|,\d{1,2})?|10$"
                        onkeyup="mediaNota()" onchange="verificaCriterio('nota_letra')">
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <label for="nota">
                        <h4>Média final</h4>
                    </label>
                    <input type="text" min="0" max="100" id="nota" name="nota"
                        style="width: 100%; height: 50px; font-size: 30px;" class="center"
                        placeholder="Informe as notas de afinação, interpretação, ritmo e letra para gerar a nota." readonly>

                </div>
            </div>

        </fieldset>
        <div class="d-flex justify-content-center mt-3">
            <input class="btn btn-primary" id="botao-submit" type="button" value="Enviar avaliação"
                onclick="verificaNota()">
        </div>

    </form>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function mediaNota() {

            var campoNota = document.getElementById('nota');
            var notaAfinacao = document.getElementById('afinacao');
            var notaRitmo = document.getElementById('ritmo');
            var notaApresentacao = document.getElementById('interpretacao');
            var notaLetra = document.getElementById('nota_letra');

            campoNota.value = ((Number(notaAfinacao.value.replace(",", ".")) + Number(notaRitmo.value.replace(",", ".")) + Number(notaApresentacao.value.replace(",", ".")) + Number(notaLetra.value.replace(",", "."))) / 4).toFixed(3);
        }

        function isNumber(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }

        function verificaCriterio(campo) {
            var getNota = document.getElementById(campo).value;
            var notaPonto = getNota.replace(",", ".");
            if (isNumber(notaPonto)) {
                if (notaPonto > 10 || notaPonto <= 0) {
                    notaErrada(getNota, campo);
                    campoNota.value = "";
                }
            } else {
                notaErrada(getNota, campo);
            }
        }

        function verificaNota() {
            var afina1 = "";
            var ritmo1 = "";
            var interp1 = "";
            var nota_letra1 = "";
            afina1 = document.getElementById("afinacao").value;
            ritmo1 = document.getElementById("ritmo").value;
            interp1 = document.getElementById("interpretacao").value;
            nota_letra1 = document.getElementById("nota_letra").value;
            var getNota = document.getElementById("nota").value;
            var notaPonto = getNota.replace(",", ".");

            if (afina1 == "") {
                notaErrada(afina1, "afinacao");
            } else if (ritmo1 == "") {
                notaErrada(ritmo1, "ritmo");
            } else if (interp1 == "") {
                notaErrada(interp1, "interpretacao");
            } else if (nota_letra1 == "") {
                notaErrada(nota_letra1, "nota_letra");
            } else if (isNumber(notaPonto)) {
                if (notaPonto > 10 || notaPonto <= 0) {
                    notaErrada(getNota, "campo");
                } else {
                    sweetalert();
                }
            } else {
                notaErrada(getNota, "campo");
            }
        }

        function notaErrada(n, x) {
            document.getElementById(x).value = "";
            document.getElementById(x).focus();
            Swal.fire({
                title: 'Atenção!',
                html: "A nota informada <br><b>" + n + "</b><br>não segue o padrão de votação.<br> Escolha uma nota entre <b>0,01 e 10</b> com até duas casas decimais. <br><br><b>Exemplos válidos</b><br> 8 <br>7.5<br> 9,74",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            })
        }


        function sweetalert() {
            var afn = document.getElementById('afinacao').value;
            var rit = document.getElementById('ritmo').value;
            var interp = document.getElementById('interpretacao').value;
            var notaLetra = document.getElementById('nota_letra').value;
            var nota = document.getElementById('nota').value;
            Swal.fire({
                title: 'Atenção!',
                html: "Confirma as notas para o interprete <?php echo $item->nome ?>?<br><br>Afinação: <b>" + afn + "</b><br>Ritmo: <b>" + rit + "</b><br> Iterpretação: <b>" + interp + "</b><br> Letra: <b>" + notaLetra + "</b><br> <br>Nota final: <b>" + nota + "</b><br>",
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