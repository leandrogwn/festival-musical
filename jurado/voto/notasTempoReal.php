<?php
if (!isset($_SESSION)) {
    session_start();
}
include ("../../conectaMysqlOO.php");
include ("../../conectaMysql.php");

$dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$fase = $dadosForm["fase"];
$nome_categoria = $dadosForm["categoria"];
$idFestival = $_SESSION['festival'];
$interprete = $dadosForm['interprete'];
$qtd_class_final = $_SESSION['qtd_class_final'];


$date = date("Y-m-d");

$ObjInscrito = new conectaMysql();


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
<div class="container-index" id="container"  style="width: 100%;">
    <form action="voto/nota.php" method="post" style="width: 70%;">
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
                echo '<input type="hidden" name="id_interprete" id="id_interprete" value="' . $item->id . '">';
                echo '<input type="hidden" name="id_jurado" id="id_jurado" value="' . $id_jurado . '">';
                echo '<div class="row-fluid">';
                echo '<div class="span12">';
                echo '<label>Interprete</label>';
                echo '<span><h4>' . $item->nome . ' </h4></span></br>';
               

                echo '</div>';
                
            }
            ?>

        </fieldset>
        <fieldset>
            <legend>Votação</legend>
            <label>Jurados</label>
            <?php
			 function data($data) {
                        return date("d/m/Y", strtotime($data));
                    }
			$ObjInscrito = new conectaMysql();
							
							$consultaNota = "select nota, id_jurado, id_interprete, nome
							from f_nota as fn
							inner join
							f_jurado as fj
							on
							fn.id_jurado = fj.id
							WHERE id_interprete = $interprete and fase = $fase";
							
							$conNotas = $ObjInscrito->selectDB($consultaNota);
							?>
                            
							<table class="table table-striped">
							<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome jurado</th>
      <th scope="col">Nota</th>

    </tr>
  </thead>
  <tbody>
  <?php
  $i = 1;
							foreach($conNotas as $itemNota){
								echo '<tr style="width:100%">
								 <th scope="row">'; echo $i;
								  echo '</th>
								 <td >';
								echo  $itemNota->nome .'</td><td> '.$itemNota->nota. '</td>';
								echo '</tr>';
								$i++;
							}
								echo '</tbody></table>';
						
			?>

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