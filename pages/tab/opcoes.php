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

<?php
include('../../conect/conectaMysqlOO.php');
$consulta = "select * from f_festival";

$Objf = new conectaMysql();

$con = $Objf->selectDB($consulta);
?>
<div class="container-index" id="container">
    <form action="../cadastro/config.php" method="post" style="width: 90%;">
    <input type="hidden" name="tela" id="tela" value="cadastro_config">
        <fieldset>
            <?php
            if (isset($_SESSION['msg_config'])) {
                echo $_SESSION['msg_config'];
                unset($_SESSION['msg_config']);
            }
            ?>
            <legend>Configurações</legend>
            <div class="row-fluid">
                <div class="span12">
                    <label>Festival ativo</label>
                    <select id="config_festival_ativo" name="config_festival_ativo" style="width: 100%;">';
                        <?php
                        foreach ($con as $item) {
                            if ($item->id == $_SESSION['festival']) {
                                echo '<option value="' . $item->id . '" selected>' . $item->nome . '</option>';
                            } else {
                                echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <label>Registro por página</label>
                    <input type="number" id="config_registro_pagina" class="txtConfig" name="config_registro_pagina"
                        value="<?php echo $_SESSION['registro_pagina'] ?>" required>
                </div>
                <div class="span2">
                    <label>Excluir maior/menor nota?</label>
                    <select id="exclusao_notas" name="exclusao_notas" class="txtConfig" required>
                        <?php
                        if ($_SESSION['exclusao_notas'] == 0) {
                            echo '<option value="0" selected>Sim</option>';
                            echo '<option value="1">Não</option>';
                        } else {
                            echo '<option value="0">Sim</option>';
                            echo '<option value="1" selected>Não</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="span2">
                    <label>Qtd. classificados 2ª fase</label>
                    <input type="text" id="qtd_class_seg_fase" class="txtConfig" name="qtd_class_seg_fase"
                        value="<?php echo $_SESSION['qtd_class_seg_fase'] ?>" required>
                </div>
                <div class="span2">
                    <label>Qtd. classificados final</label>
                    <input type="text" class="txtConfig" id="qtd_class_final" name="qtd_class_final"
                        value="<?php echo $_SESSION['qtd_class_final'] ?>" required>
                </div>
                <div class="span4">
                    <label>Domínio</label>
                    <input type="text" class="txtConfig" id="domain" name="domain"
                        value="<?php echo $_SESSION['domain'] ?>" required>
                </div>
                
            </div>
        </fieldset>
        <div class="modal-footer mt-4">
            <input class="btn btn-primary" id="botao-atualiza-config" type="submit" value="Atualizar configurações">
        </div>
    </form>

</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

if (isset($_SESSION['cadastro_config'])) {

    echo '<script>
                Swal.fire({
                    title: \'Atenção!\',
                    text: \'LOGAR NOVAMENTE PARA APLICAR ALTERAÇÕES. Configuções atualizadas com sucesso!\',
                    icon: \'success\',
                    confirmButtonText: \'Ok\'
                  })
        </script>';
    unset($_SESSION['cadastro_config']);

}

include '../footer.php';
?>