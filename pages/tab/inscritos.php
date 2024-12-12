<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

error_reporting(0);
if (!isset($_SESSION)) {
    session_start();
}
include ($_SERVER['DOCUMENT_ROOT'] . '/conectaMysqlOO.php');

$consultaF = "select * from f_config ORDER BY id DESC LIMIT 1";

$ObjF = new conectaMysql();

$conF = $ObjF->selectDB($consultaF);

foreach ($conF as $item) {
    $festival = $item->festival_ativo;
}

// definir o numero de itens por pagina
$itens_por_pagina = $_SESSION['registro_pagina'];

// pegar a pagina atual

$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : "";

// puxar produtos do banco
$sql_code = "select * from f_inscricao where festival = '" . $festival . " ' order by categoria";

$ObjI = new conectaMysql();

$con = $ObjI->selectDB($sql_code);

// pega a quantidade total de objetos no banco de dados
$num_total = count($ObjI->selectDB("select * from f_inscricao where festival like '" . $festival . "'"));

// definir numero de páginas
$num_paginas = ceil($num_total / $itens_por_pagina);
?>


<!DOCTYPE html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="../../css/main.css" />
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
    
    <link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <title>Inscritos</title>
    
</head>

<body>
    <?php include '../../pages/header.php'; ?>
    <div class="container-index" id="container" >
        <fieldset style="width: 90%;">
            
            <legend class="d-flex"><span class="p-2 w-100">Listagem de inscritos</span><a class="btn mb-2 btn-primary flex-shrink-1" style='width:200px; height: 36px;' href="../inscricaoFestival.php"  role="button"><i class="bi bi-person-plus-fill me-3"></i>Novo inscrito</a></legend>
            <table class="table table-striped" id="tableInscrito">
                <thead>
                    <tr>
                        
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Canção com link da apresentação</th>
                        <th>Cantor</th>
                        <th style="text-align: center;">+ Info</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                foreach ($con as $item) {
                    include ($_SERVER['DOCUMENT_ROOT'] . '/conectaMysql.php');
                    $sqlQtd = mysqli_query($conMysql, "select * from f_primeira_fase where id_festival = $item->festival AND id_interprete = $item->id")
                        or die("<br>Não foi possivel realizar a busca. Erro: " . mysqli_error($conMysql));
                    $qtdReg = mysqli_num_rows($sqlQtd);

                    if ($qtdReg > 0) {
                        echo '<tr class="success" style="text-transform:capitalize;"><td>' . $item->nome . '</td><td style="text-transform: capitalize;">' . $item->categoria . '</td><td><a href="' . $item->link . '" target="_blank">' . $item->cancao . '</a></td><td>' . $item->gravado_por . '</td><td><a href="mais_info.php?cod_interprete= ' . $item->id . '"><div style="text-align: center;"><img src="../../img/plus20.png"></div></a></td><td>';
                        echo 'Liberado (<a href="../deleta/selecionado.php?festival=' . $festival . '&interprete=' . $item->id . '&tela=inscrito" target="_top">desfazer</a>)';
                    } else {
                        echo '<tr style="text-transform:capitalize;"><td>' . $item->nome . '</td><td style="text-transform: capitalize;">' . $item->categoria . '</td><td><a href="' . $item->link . '" target="_blank">' . $item->cancao . '</a></td><td>' . $item->gravado_por . '</td><td><a href="mais_info.php?cod_interprete= ' . $item->id . '"><div style="text-align: center;"><img src="../../img/plus20.png"></div></a></td><td class="text-center">';
                        echo '<a href="../editar/inscricaoFestival.php?codInterprete=' . $item->id .'" class="btn btn-sm ms-1 btn-secondary" id="botao-editar-interprete" title="Editar interprete"><i class="bi bi-pencil-square"></i> Editar</a> &nbsp;';
                        echo '<a href="../cadastro/liberacao_inscrito.php?festival=' . $festival . '&inscrito=' . $item->id . '&categoria=' . $item->categoria . '&tela=inscrito" target="_top">Liberar 1ª fase</a></td></tr>';
                    }
                }
                ?>
                </tbody>
            </table>

            

        </fieldset>
    </div>

     <script>
            $(document).ready(function () {
                $('#tableInscrito').DataTable({
                    language: {
                        url: '<?php echo $_SESSSION['domain']?>/json/dataTables.json'
                    }
                });

            });
        </script>
    
    <?php include '../../pages/footer.php'; ?>
</body>

</html>