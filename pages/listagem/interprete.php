<?php
error_reporting(0);
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["festival"])) {

    $dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $nome_fase = $this->dadosForm["liberacao_fase"];
    $nome_categoria = $this->dadosForm["liberacao_categoria"];

    $consultaInscrito = "select * from f_fase";

    $ObjInscrito = new conectaMysql();

    $conInscrito = $ObjInscrito->selectDB($consultaInscrito);

    ?>
    <link rel="stylesheet" type="text/css" media="screen" href="../../css/main.css"/>
    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <div class="container-index" id="container">
        <fieldset>
    <?php
    if (isset($_SESSION['msg_inscrito'])) {
        echo $_SESSION['msg_inscrito'];
        unset($_SESSION['msg_inscrito']);
    }
    ?>
            <legend>Listagem de inscritos</legend>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Canção com link da apresentação</th>
                        <th>Cantor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    foreach ($conInscrito as $item) {
        echo '<tr><td>' . $item->id . '</td><td>' . $item->nome . '</td><td>' . $item->categoria . '</td><td><a href=\"url:' . $item->link . '\" target="_blank">' . $item->cancao . '</a></td><td>' . $item->gravado_por . '</td><td><a href=\"#\" target="_blank">Liberar 1ª fase</a> - <a href=\"#\" target="_blank">+ informações</a></td></tr>';
    }
    ?>
                </tbody>
            </table>

            <div class="pagination pagination-centered">
                <ul>
                    <li>
                        <a href="inscritos.php?pagina=0" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
    <?php
    for ($i = 0; $i < $num_paginas; $i++) {
        $estilo = "";
        if ($pagina == $i * $itens_por_pagina)
            $estilo = "class=\"active\"";
        ?>
                            <li <?php echo $estilo; ?> ><a href="inscritos.php?pagina=<?php echo $i * $itens_por_pagina; ?>" target="frame_inscritos"><?php echo $i + 1; ?></a></li>
                    <?php } ?>
                    <li>
                        <a href="inscritos.php?pagina=<?php echo $num_paginas - 1; ?>0" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>

        </fieldset>

    </div>
    <?php
} else {
    $_SESSION['access'] = sha1(date("d/m/Y"));
    echo '<script>window.location.href = "../../index.php";</script>';
}
?>