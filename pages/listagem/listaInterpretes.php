<?php
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION)) {
    session_start();
}
include("../../conect/conectaMysqlOO.php");
include("../../conect/conectaMysql.php");

if (empty($_GET['liberacao_fase'])) {
    $dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
} else {
    $dadosForm = filter_input_array(INPUT_GET, FILTER_DEFAULT);
}


$fase = $dadosForm["liberacao_fase"];
$nome_categoria = $dadosForm["liberacao_categoria"];
$idFestival = $_SESSION['festival'];
$qtd_class_seg_fase = $_SESSION['qtd_class_seg_fase'];
$qtd_class_final = $_SESSION['qtd_class_final'];

if ($_SESSION['exclusao_notas'] == 0) {
    $regra = "nota_c_regra";
} else {
    $regra = "nota_s_regra";
}

if ($fase == "1") {
    $consultaInscrito = "select * from f_inscricao where id in(select id_interprete from f_primeira_fase where id_festival = $idFestival AND categoria like '$nome_categoria')";
} else if ($fase == "2") {
    $consultaInscrito = "select f_inscricao.*, f_nota.fase, f_nota.id_interprete, avg(f_nota.nota) as nota_s_regra, (sum(f_nota.nota)-(min(f_nota.nota)+max(f_nota.nota)))/(count(f_nota.nota)-2) as nota_c_regra, min(f_nota.nota) as menor_nota, max(f_nota.nota) as maior_nota
from f_inscricao
inner join f_nota
on f_inscricao.id = f_nota.id_interprete
and f_inscricao.festival = $idFestival 
and f_nota.fase = 1
and f_nota.genero like '$nome_categoria'
group by f_nota.id_interprete order by $regra desc, f_inscricao.id asc limit $qtd_class_seg_fase";
} else if ($fase == "3") {
    $consultaInscrito = "select f_inscricao.*, f_nota.fase, f_nota.id_interprete, avg(f_nota.nota) as nota_s_regra, (sum(f_nota.nota)-(min(f_nota.nota)+max(f_nota.nota)))/(count(f_nota.nota)-2) as nota_c_regra, min(f_nota.nota) as menor_nota, max(f_nota.nota) as maior_nota
from f_inscricao
inner join f_nota
on f_inscricao.id = f_nota.id_interprete
and f_inscricao.festival = $idFestival 
and f_nota.fase = 2
and f_nota.genero like '$nome_categoria'
group by f_nota.id_interprete order by $regra desc, f_inscricao.id asc limit $qtd_class_final";
}
$date = date("Y-m-d");


$ObjInscrito = new conectaMysql();

$conInscrito = $ObjInscrito->selectDB($consultaInscrito);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">

    <!--Let browser know website is optimized for mobile-->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


</head>

<body>
    <?php include '../../pages/header.php'; ?>
    <div class="container-index" id="container">
        <div style="width: 90%; margin-top: 16px;">
            <fieldset class="mb-3">
                <?php
                if (isset($_SESSION['lista_interprete_liberacao'])) {
                    if ($_SESSION['lista_interprete_liberacao'] == 'sucess') {
                        echo '<script>
                Swal.fire({
                    title: \'Sucesso!\',
                    text: \'O interprete foi liberado para apresentação\',
                    icon: \'success\',
                    showConfirmButton: false,
                    timer: 2500
                  })
        </script>';
                        unset($_SESSION['lista_interprete_liberacao']);

                    } else {
                        echo '<script>
                Swal.fire({
                    title: \'Erro!\',
                    text: \'Houve algum erro na liberação do interprete.\',
                    icon: \'error\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
                        unset($_SESSION['lista_interprete_liberacao']);
                    }
                }


                if (isset($_SESSION['lista_interprete_finalizar'])) {
                    if ($_SESSION['lista_interprete_finalizar'] == 'update') {
                        echo '<script>
                Swal.fire({
                    title: \'Sucesso!\',
                    text: \'A apresentação do interprete foi finalizada.\',
                    icon: \'success\',
                    showConfirmButton: false,
                    timer: 2500
                  })
        </script>';
                        unset($_SESSION['lista_interprete_finalizar']);

                    } else {
                        echo '<script>
                Swal.fire({
                    title: \'Erro!\',
                    text: \'Houve algum erro na finalização da apresentação do interprete.\',
                    icon: \'error\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
                        unset($_SESSION['lista_interprete_finalizar']);
                    }
                }


                if (isset($_SESSION['lista_interprete_postergar'])) {

                    echo '<script>
                Swal.fire({
                    title: \'Sucesso!\',
                    text: \'A apresentação do interprete foi adiada.\',
                    icon: \'success\',
                    showConfirmButton: false,
                    timer: 2500
                  })
        </script>';
                    unset($_SESSION['lista_interprete_postergar']);

                }


                error_reporting(0);
                $_SESSION['tela' . $tela] = "sucess";
                ?>

                <legend>Listagem de interpretes
                    <span style="float: right; padding: 10px;">
                        <a class="btn btn-outline-primary" target="_blank"
                            href="imprimir_completo.php?liberacao_fase=<?php echo $fase ?>&liberacao_categoria=<?php echo $nome_categoria ?>"><i
                                class="bi bi-printer"></i> Dados dos interpretes</a>
                        <a class="btn btn-outline-primary" target="_blank"
                            href="imprimir.php?liberacao_fase=<?php echo $fase ?>&liberacao_categoria=<?php echo $nome_categoria ?>"><i
                                class="bi bi-printer"></i> Resultado classificatório</a>
                        <a class="btn btn-outline-primary" target="_blank"
                            href="imprimir_nota.php?liberacao_fase=<?php echo $fase ?>&liberacao_categoria=<?php echo $nome_categoria ?>"><i
                                class="bi bi-printer"></i> Resultado Auditado</a>

                    </span>
                </legend>
                <div style="border: 1px solid #dcddde;  border-radius: 8px; padding: 8px;">
                    <table class="table table-striped" id="tableFestival">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Canção</th>
                                <th>Cantor</th>
                                <?php
                                if ($fase == 2) {
                                    echo '<th>Nota 1ª fase</th>';
                                } elseif ($fase == 3) {
                                    echo '<th>Nota 2ª fase</th>';
                                } else {
                                    echo '<th></th>';
                                }
                                ?>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($conInscrito as $item) {
                                if ($_SESSION['exclusao_notas'] == 0) {
                                    $regraNota = $item->nota_c_regra;
                                } else {
                                    $regraNota = $item->nota_s_regra;
                                }
                                //$VerificaLiberacao = "select * from f_liberacao where id_festival = $idFestival AND id_interprete = $item->id AND fase = $fase";
                                $VerificaLiberacao = "select * from f_liberacao where id_interprete = $item->id AND fase = $fase";
                                $conVerificaLiberacao = mysqli_query($conMysql, $VerificaLiberacao) or die("Não foi possivel antender o esperado. Consulta VerificaLiberacao. " . mysqli_error($conMysql));
                                echo '<tr style="text-transform:capitalize;"><td style="vertical-align: middle;">' . $item->nome . '</td><td style="vertical-align: middle;">' . $item->categoria . '</td><td style="vertical-align: middle;">' . $item->cancao . '</td><td style="vertical-align: middle;">' . $item->gravado_por . '</td><td style="vertical-align: middle;">' . number_format($regraNota, 2, '.', '') . '</td><td style="width:215px; vertical-align: middle;">';
                                $qtdReg = mysqli_num_rows($conVerificaLiberacao);

                                $resVerLib = mysqli_fetch_assoc($conVerificaLiberacao);

                                if ($qtdReg == 0) {
                                    echo '<a href="../cadastro/liberar_para_apresentar.php?festival=' . $idFestival . '&interprete=' . $item->id . '&fase=' . $fase . '&categoria=' . $nome_categoria . '&tela=lista_interprete_liberacao" class="btn btn-sm btn-primary" style="white-space: nowrap;" id="botao-listar-interprete" target="_top">Liberar para apresentar</a>';
                                    
                                } else if ($qtdReg > 0 && $resVerLib["status"] == 1) {
                                    echo '<a href="../../jurado/verificacaoNotas.php?festival=' . $idFestival . '&interprete=' . $item->id . '&fase=' . $fase . '&categoria=' . $nome_categoria . '&tela=lista_interprete_verificar_notas" target="_blank" class="btn btn-sm btn-secondary" id="botao-listar-interprete" title="Acompanhar votação em tempo real" target="_top"><i class="bi bi-eye"></i></a> &nbsp;';

                                    echo '<a href="../atualizar/apresentacao.php?festival=' . $idFestival . '&interprete=' . $item->id . '&fase=' . $fase . '&categoria=' . $nome_categoria . '&tela=lista_interprete_finalizar" class="btn btn-sm btn-success"  id="botao-listar-interprete" target="_top">Finalizar</a> <a href="../deleta/postergar_apresentacao.php?festival=' . $idFestival . '&interprete=' . $item->id . '&fase=' . $fase . '&tela=lista_interprete_postergar&categoria=' . $nome_categoria . '" target="_top">Postergar</a>';
                                } else if ($qtdReg > 0 && $resVerLib["status"] == 2) {
                                    echo '<span style="white-space:nowrap">Apresentação concluída</span>';
                                }

                                echo '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </fieldset>


        </div>
        <script>
            $(document).ready(function () {
                $('#tableFestival').DataTable({
                    paging: false,
                    language: {
                        url: '<?php echo $_SESSSION['domain']?>/json/dataTables.json'
                    }
                });

            });
        </script>
        <script language="Javascript" type="text/javascript">
            parent.document.getElementById("frame_lista_interprete").height = document.getElemyId("container-interno").scrollHeight;
        </script>


        <?php include '../../pages/footer.php'; ?>

</body>

</html>