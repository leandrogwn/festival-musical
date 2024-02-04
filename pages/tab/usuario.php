<?php
error_reporting(0);

if (!isset($_SESSION)) {
    session_start();
}

include '../header.php';

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">

<!--Cadastro de usuarios-->
<?php
if ($_SESSION['perfil'] == 1) {
?>

<div class="body-opcoes">
    <?php
    //                                                include ("./conect/conectaMysql.php");
    //                                                $busca_config = mysql_query("select * from f_login where user = 1 order by data_hora desc limit 1;");
    //                                                $result_busca_config = mysql_fetch_assoc($busca_config);
    ?>
    <script>
        function validapass() {
            var nome = document.getElementById("nome").value;
            var login = document.getElementById("login").value;
            var pass = document.getElementById("senha").value;
            var retrPass = document.getElementById("conf-senha").value;

            if (pass !== retrPass) {
                document.getElementById("p-erro-senha").style.display = 'block';
                document.getElementById("botao-insere-usuario").disabled = true;
                document.getElementById("conf-senha").style.backgroundColor = "#C24349";
            } else {
                document.getElementById("botao-insere-usuario").disabled = false;
                document.getElementById("conf-senha").style.backgroundColor = "#4C884A";
                document.getElementById("conf-senha").style.Color = "#ffffff";
                document.getElementById("p-erro-senha").style.display = 'none';

            }
        }
    </script>
    <div class="container-index" id="container">
        <form action="../cadastro/usuario.php" method="post" style="width: 90%">
        <input type="hidden" id="tela" name="tela" value="cadastro_usuario">
            <fieldset>
                <legend>Cadastro de usuário</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <label>Nome usuário</label>
                        <input type="text" name="nome" id="nome" class="txtConfig" autofocus required>
                    </div>
                    <div class="span6">
                        <label>Perfil do usuário</label>
                        <select name="perfil" id="perfil" class="txtConfig" required>
                            <option value="1">Administrador</option>
                            <option value="2" selected>Operador</option>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label>Login</label>
                        <input type="text" name="login" id="login" class="txtConfig" required>
                    </div>
                    <div class="span4">
                        <label>Senha</label>
                        <input type="password" name="senha" id="senha" class="txtConfig" required>
                    </div>
                    <div class="span4">
                        <label>Confirmar senha</label>
                        <input type="password" name="conf-senha" id="conf-senha" class="txtConfig"
                            onkeyup="validapass()" required>
                        <p id="p-erro-senha">Senha não confere</p>
                    </div>
                </div>

            </fieldset>
            <div class="modal-footer">
                <input class="btn btn-primary" id="botao-insere-usuario" type="submit" value="Inserir usuário"
                    disabled="">
            </div>
        </form>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
}
if (isset($_SESSION['cadastro_usuario'])) {

    echo '<script>
                Swal.fire({
                    title: \'Sucesso!\',
                    text: \'Usuário cadastrado com sucesso!\',
                    icon: \'success\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
    unset($_SESSION['cadastro_usuario']);

}
?>

</div>

<?php
include '../footer.php';
?>