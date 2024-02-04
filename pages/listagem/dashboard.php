<?php

if (!isset($_SESSION)) {
    session_start();
}

include("../conect/conectaMysqlOO.php");
$idFestival = $_SESSION['festival'];

$ObjConecta = new conectaMysql();

//festival
$consultaFestival = "select nome from f_festival where id = $idFestival ORDER BY id DESC LIMIT 1";

$consultaNome = $ObjConecta->selectDB($consultaFestival);

//jurado
$consultaJurado = "select count(*) as contJurado from f_jurado where festival  = $idFestival";

$countJurado = $ObjConecta->selectDB($consultaJurado);

//inscritos
$consultaInscrito = "select count(*) as contInscrito from f_inscricao where festival  = $idFestival";

$countInscrito = $ObjConecta->selectDB($consultaInscrito);

?>
<div class="container-index" id="container">
    <div class="row row-cols-3 " style="width: 90%;">
        <div class="col">
            <div class="col card">
                <div class="card-body" style="height: 154px;">
                    <h5 class="card-title">Festival ativo</h5>
                    <p class="card-text">
                    <?php
                    echo $consultaNome['nome'];
                        foreach ($consultaNome as $item) {
                            echo $item->nome;
                        } ?>
                    </p>
                    <a href="<?php echo $_SESSION['domain']; ?>/pages/listagem/liberacao.php"
                        class="btn btn-primary">Liberar para apresentação</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="col card">
                <div class="card-body">
                    <div class="text-center mt-3">
                        <h3>
                            <?php
                        foreach ($countJurado as $item) {
                            echo $item->contJurado;
                        } ?>
                        </h3>
                        <h5 class="card-title ">jurados</h5>
                    </div>
                </div>
                <small class="card-footer text-muted text-align-end">
                    <a href="<?php echo $_SESSION['domain']; ?>/pages/tab/jurado.php"><i
                            class="bi bi-person-workspace me-3"></i>Adicionar jurado</a>
                </small>
            </div>
        </div>
        <div class="col">
            <div class="col card">
                <div class="card-body">
                    <div class="text-center mt-3">
                        <h3>
                            <?php
                        foreach ($countInscrito as $item) {
                            echo $item->contInscrito;
                        } ?>
                        </h3>
                        <h5 class="card-title">inscritos</h5>
                    </div>
                </div>
                <small class="card-footer text-muted">
                    <a href="<?php echo $_SESSION['domain']; ?>/pages/tab/inscritos.php">
                        <i class="bi bi-people-fill me-3"></i>
                        Listar Inscritos
                    </a>
                </small>
            </div>
        </div>
        
    </div>
    
</div>