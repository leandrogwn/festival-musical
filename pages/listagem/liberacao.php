<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION)) {
    session_start();
}
include("../../conectaMysqlOO.php");

$consulta = "SELECT f_config.id, f_config.festival_ativo as festivalAtivo, f_festival.nome as nome
FROM f_config
INNER JOIN f_festival
ON f_config.festival_ativo = f_festival.id
ORDER BY f_config.id DESC LIMIT 1;";

$Objf = new conectaMysql();
$con = $Objf->selectDB($consulta);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Festival musical</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link href="../../css/main.css" rel="stylesheet">
    <script src="../../js/jqueryFest.js"></script>


    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">

</head>

<body>

    <?php include '../../pages/header.php'; ?>

    <div class="container-index" id="container">
        <form action="listaInterpretes.php" method="post" style="width: 90%;">
            <fieldset>
                <?php
                if (isset($_SESSION['msg_postergar'])) {
                    echo '<script>
                    swal(' + $_SESSION['msg_postergar'] + ', {
                        icon: "success",
                        buttons: false
                    });
                </script>';
                    unset($_SESSION['msg_postergar']);
                }
                ?>



                
                <legend>
                    <?php
                    foreach ($con as $item) {
                        $_SESSION['nome_festival'] = $item->nome;
                        echo 'Festival: '.$_SESSION['nome_festival'];
                    }
                    ?>
                </legend>
                <div style="border: 1px solid #dcddde; width: 100%; border-radius: 8px; padding: 8px;">
                    <div class="row row-cols-3">
                        <div class="col">
                            <label for="liberacao_fase" class="form-label">Fase</label>
                            <select id="liberacao_fase" name="liberacao_fase" class="form-select" style="width: 100%;">';
                                <option value="1">Fase 1 - Classificatória</option>
                                <option value="2">Fase 2 - Eliminatória</option>
                                <option value="3">Fase 3 - Final</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="liberacao_categoria" class="form-label">Categoria</label>
                            <select required id="liberacao_categoria" name="liberacao_categoria" class="form-select" style="width: 100%;">
                                <option value="gospel">Gospel</option>
    							<option value="gaucho">Gaucho</option>
    							<option value="infantil">Infantil</option>
    							<option value="juvenil">Infanto Juvenil</option>
    							<option value="mpb" >MPB</option>
    							<option value="pagode">Pagode</option>
    							<option value="pop">Pop</option>
    							<option value="popular">Popular</option>
    							<option value="rap">Rap</option>
    							<option value="reggae">Reggae</option>
    							<option value="rock">Rock</option>
                                <option value="sertanejo">Sertanejo</option>
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" style="width:100%; margin-top: 30px;"
                                id="botao-listar-interprete" type="submit"><i class="icon-filter icon-white" role="button"></i> Listar
                                Interprete</button>

                        </div>
                    </div>
                </div>
                
            </fieldset>
        </form>
        <script type="text/javascript">
            $(document).ready(function () {

            <?php
            if (isset($_SESSION[' f '])) {
                $f = $_SESSION[' f '];
                $c = $_SESSION[' c '];
                echo ' $("#liberacao_fase ").val(' .$f. ');
                    $("#liberacao_categoria ").val("' .$c. '");
                    $("#botao - listar - interprete ").click();';

                    unset($_SESSION[' f '], $_SESSION[' c ']);
            }
            ?>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    
    <?php
    if (isset($_SESSION['msg_postergar'])) {
        echo '
        ';
        unset($_SESSION['msg_postergar']);
    }
    ?>

</body>

</html>