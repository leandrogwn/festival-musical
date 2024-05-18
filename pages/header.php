<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $_SESSION['domain']; ?>/css/main.css" />
<link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<nav class="navbar" style="background-color: #edf0f5;">
    <div class="container-fluid" style="display: block;">
        <div class="navbar-header">
            <i style="font-size: 1.5rem;" class="bi bi-list" data-bs-toggle="offcanvas" href="#offcanvasExample"
                role="button" aria-controls="offcanvasExample"></i>
            <a class="navbar-brand ms-3" href="#"><span class="fs-4">Festival Musical</span></a>
        </div>
        <div class="logout">
            <i class="bi bi-person">&nbsp;</i>
            <script language="JavaScript">
                var dataHora, xHora, xDia, dia, mes, ano, txtSaudacao;
                dataHora = new Date();
                xHora = dataHora.getHours();
                if (xHora >= 0 && xHora < 12) { txtSaudacao = " bom Dia! " }
                if (xHora >= 12 && xHora < 18) { txtSaudacao = " boa Tarde! " }
                if (xHora >= 18 && xHora <= 23) { txtSaudacao = " boa Noite! " }

                xDia = dataHora.getDay();
                diaSemana = new Array(7);
                diaSemana[0] = "Domingo";
                diaSemana[1] = "Segunda-feira";
                diaSemana[2] = "Terça-feira";
                diaSemana[3] = "Quarta-feira";
                diaSemana[4] = "Quinta-Feira";
                diaSemana[5] = "Sexta-Feira";
                diaSemana[6] = "Sábado";
                dia = dataHora.getDate();
                mes = dataHora.getMonth();
                mesDoAno = new Array(12);
                mesDoAno[0] = "janeiro";
                mesDoAno[1] = "fevereiro";
                mesDoAno[2] = "março";
                mesDoAno[3] = "abril";
                mesDoAno[4] = "maio";
                mesDoAno[5] = "junho";
                mesDoAno[6] = "julho";
                mesDoAno[7] = "agosto";
                mesDoAno[8] = "setembro";
                mesDoAno[9] = "outubro";
                mesDoAno[10] = "novembro";
                mesDoAno[11] = "dezembro";
                ano = dataHora.getFullYear();
                document.write(diaSemana[xDia] + ", " + dia + " de " + mesDoAno[mes] + " de " + ano);
            </script>
        </div>
    </div>

</nav>


<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 bg-light" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel" style="width: 280px;">


    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4">Festival Musical</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?php echo $_SESSION['domain']; ?>/pages/painel.php"
                class="nav-link active" aria-current="page">
                <i class="bi bi-house me-3"></i>
                Início
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $_SESSION['domain']; ?>/pages/listagem/liberacao.php"
                class="nav-link link-dark" aria-current="page">
                <i class="bi bi-mic me-3"></i>
                Liberação
            </a>
        </li>

        <li>
            <a href="<?php echo $_SESSION['domain']; ?>/pages/tab/inscritos.php"
                class="nav-link link-dark">
                <i class="bi bi-people-fill me-3"></i>
                Inscritos
            </a>
        </li>
        <li>
            <a href="<?php echo $_SESSION['domain']; ?>/pages/tab/jurado.php"
                class="nav-link link-dark">
                <i class="bi bi-person-workspace me-3"></i>
                Jurados
            </a>
        </li>


    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo $_SESSION['domain']; ?>/img/ico_avatar.png" alt="" width="32" height="32"
                class="rounded-circle me-2">
            <strong>
                <?php echo $_SESSION['nome']; ?>
            </strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="<?php echo $_SESSION['domain']; ?>/pages/tab/opcoes.php"><i
                        class="bi bi-gear me-3"></i>Configurações</a>
            </li>
            <?php
            if ($_SESSION['perfil'] == 1) {
            ?>
            <li><a class="dropdown-item" href="<?php echo $_SESSION['domain']; ?>/pages/tab/usuario.php"><i
                        class="bi bi-person-plus me-3"></i>Cadastro de usuário</a></li>
            <?php } ?>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?php echo $_SESSION['domain']; ?>/logout.php"><i
                        class="bi bi-box-arrow-left me-3"></i> Sair</a></li>
        </ul>
    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>