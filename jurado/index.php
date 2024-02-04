<?php
if (!isset($_SESSION)) {
    session_start();
}

include '../conect/conectaMysql.php';
$config = mysqli_query($conMysql, "select * from f_config order by id desc limit 1")
        or die("<br>Não foi possivel realizar a busca. Erros: " . mysqli_error($conMysql));

while ($registro_config = mysqli_fetch_assoc($config)) {
    $_SESSION['domain'] = $registro_config["domain"];
}

?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <title>Festival musical - Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo $_SESSION['domain']; ?>/css/csscdnbootstrap.css" rel="stylesheet" id="bootstrap-css">
    <link rel="shortcut icon" href="<?php echo $_SESSION['domain']; ?>/img/favicon.png" type="image/x-icon">
    <style>
        /*
             * General styles
             */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        html,
        body {
            height: 100%;
            font-size: 0.9rem;

        }

        .card-container.card {
            max-width: 350px;
            padding: 40px 40px;
            border-radius: 8px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        
        /*
             * Card component
             */
        .card {
            background-color: #F7F7F7;
            /* just in case there no content*/
            padding: 20px 25px 30px;
            margin: 0 auto 25px;
            /* shadows and rounded borders */
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        }

        .profile-img-card {
            margin: 0 auto 10px;
            display: block;

        }

        /*
             * Form styles
             */
        .profile-name-card {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0 0;
            min-height: 1em;
        }

        .reauth-email {
            display: block;
            color: #404040;
            line-height: 2;
            margin-bottom: 10px;
            font-size: 14px;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .form-signin #inputEmail,
        .form-signin #inputPassword {
            direction: ltr;
            height: 44px;
            font-size: 16px;
        }

        .form-signin input[type=email],
        .form-signin input[type=password],
        .form-signin input[type=text],
        .form-signin button {
            width: 100%;
            display: block;
            margin-bottom: 10px;
            position: relative;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .form-signin .form-control:focus {
            border-color: rgb(104, 145, 162);
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
        }

        .btn.btn-signin {
            /*background-color: #4d90fe; */
            
            /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
            padding: 0px;
            font-weight: 700;
            font-size: 14px;
            height: 36px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            border: none;
            -o-transition: all 0.218s;
            -moz-transition: all 0.218s;
            -webkit-transition: all 0.218s;
            transition: all 0.218s;
        }

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body style="background-color: #edf0f5;">
    <div class="container">
        <img id="profile-img" class="profile-img-card" src="<?php echo $_SESSION['domain']; ?>/img/logo.png" style="width: 300px;" />
        <div class="card card-container">
            <h4>Login</h4>
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" action="<?php echo $_SESSION['domain']; ?>/jurado/painel.php" method="post">

                <div class="form-floating mb-3">
                    <input type="text" name="login_digitado" id="login_digitado" class="form-control"
                        placeholder="Usuário" required>
                    <label for="login_digitado">Usuário</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="senha_digitada" id="senha_digitada" class="form-control"
                        placeholder="Senha" required>
                    <label for="floatingInput">Senha</label>
                </div>

                <button class="btn btn-primary" type="submit">Entrar</button>
            </form><!-- /form -->

        </div><!-- /card-container -->
        <div class="text-center mt-0 mb-4">
            <div class="align-text-bottom"><svg width="331" height="1" viewBox="0 0 331 1" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <line x1="4.37114e-08" y1="0.5" x2="331" y2="0.500029" stroke="#C5C2C2"></line>
                </svg>
            </div>
            Gurski Assessoria LTDA - CNPJ: 47.506.914/0001-92
        </div>
    </div><!-- /container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['access'])) {
       
        echo '<script>
                    Swal.fire({
                        title: \'Atenção!\',
                        text: \'Usuário ou senha incorreta, tente novamente!\',
                        icon: \'warning\',
                        confirmButtonText: \'Ok\'
                      })
            </script>';
        unset($_SESSION['access']);
    
    }
    ?>
</body>

</html>