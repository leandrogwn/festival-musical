<?php
if (!isset($_SESSION)) {
    session_start();
}

include("../../conectaMysqlOO.php");

$consulta = "select * from f_festival";

$Objf = new conectaMysql();

$con = $Objf->selectDB($consulta);

?>
<style>
    body {
        overflow: hidden;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link href="../../css/main.css" rel="stylesheet">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<script src="../../js/jqueryFest.js"></script>
<link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include '../../pages/header.php';

    if (isset($_SESSION['cadastro_jurado'])) {
        if ($_SESSION['cadastro_jurado'] == 'sucess') {
            echo '<script>
                Swal.fire({
                    title: \'Sucesso!\',
                    text: \'Jurado salvo com sucesso!\',
                    icon: \'success\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
            unset($_SESSION['cadastro_jurado']);

        } else {
            echo '<script>
                Swal.fire({
                    title: \'Erro!\',
                    text: \'Houve algum erro na inclusão do usuário.\',
                    icon: \'error\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
            unset($_SESSION['cadastro_jurado']);
        }
    }
    ?>
<div class="container-index" id="container">
    <form action="../cadastro/jurado.php" method="post" target="_parent" style="width: 90%;">
        <fieldset>
            <?php
                if (isset($_SESSION['msg_jurado'])) {
                    echo $_SESSION['msg_jurado'];
                    unset($_SESSION['msg_jurado']);
                }
                ?>
            <legend>Cadastro de jurado</legend>
            <input type="hidden" name="festival_jurado" id="festival_jurado"
                value="<?php echo $_SESSION['festival']; ?>">
            <input type="hidden" name="tela" id="tela" value="cadastro_jurado">

            <div class="row-fluid">
                <div class="span12">
                    <label>Nome do jurado</label>
                    <input type="text" id="nome_jurado" name="nome_jurado" style="width: 100%;" required>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <label>Login do jurado</label>

                    <input type="text" id="login_jurado" name="login_jurado" style="width: 100%;" required>
                </div>

                <div class="span6">
                    <label>Senha do jurado</label>

                    <input type="text" id="senha_jurado" name="senha_jurado" style="width: 100%;" required>
                </div>
            </div>

            <label>Infomaçõs adicionais/Outros</label>
            <input type="text" id="informacao_jurado" name="informacao_jurado" style="width: 100%;">
        </fieldset>
        <div class="modal-footer">
            <a href="../listagem/jurado.php">listar jurados</a> &nbsp;
            <input class="btn btn-primary" id="botao-insere-jurado" type="submit" value="Incluir jurado">
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

<?php include '../../pages/footer.php'; ?>