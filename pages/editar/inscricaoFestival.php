<?php
if (!isset($_SESSION)) {
    session_start();
}
include ("../../conectaMysqlOO.php");

$consulta = "SELECT f_config.id, f_config.festival_ativo as festivalAtivo, f_festival.nome as nome
FROM f_config
INNER JOIN f_festival
ON f_config.festival_ativo = f_festival.id
ORDER BY f_config.id DESC LIMIT 1;";

$codInterprete = $_GET['codInterprete'];

$consultaInterprete = "SELECT * FROM f_inscricao WHERE id = $codInterprete";

$Objf = new conectaMysql();

$con = $Objf->selectDB($consulta);

$interprete = $Objf->selectDB($consultaInterprete);


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Festival musical</title>



        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


        <link rel="shortcut icon" href="../../img/favicon.png" type="image/x-icon">

        <!-- Adicionando JQuery -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
        <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
        <script type="text/javascript" src="../../js/jquery.maskedinput-1.1.4.pack.js"/></script>

    <!-- Adicionando Javascript -->
    <script type="text/javascript" >

        $(document).ready(function () {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function () {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
        //adiciona mascara ao CPF
        function MascaraCPF(cpf) {
            if (mascaraInteiro(cpf) == false) {
                event.returnValue = false;
            }
            return formataCampo(cpf, '000.000.000-00', event);
        }
        //valida o CPF digitado
        function ValidarCPF(Objcpf) {
            var cpf = Objcpf.value;
            exp = /\.|\-/g
            cpf = cpf.toString().replace(exp, "");
            var digitoDigitado = eval(cpf.charAt(9) + cpf.charAt(10));
            var soma1 = 0, soma2 = 0;
            var vlr = 11;

            for (i = 0; i < 9; i++) {
                soma1 += eval(cpf.charAt(i) * (vlr - 1));
                soma2 += eval(cpf.charAt(i) * vlr);
                vlr--;
            }
            soma1 = (((soma1 * 10) % 11) == 10 ? 0 : ((soma1 * 10) % 11));
            soma2 = (((soma2 + (2 * soma1)) * 10) % 11);

            var digitoGerado = (soma1 * 10) + soma2;
            if (digitoGerado != digitoDigitado)
                alert('CPF Invalido!');
        }

        //valida numero inteiro com mascara
        function mascaraInteiro() {
            if (event.keyCode < 48 || event.keyCode > 57) {
                event.returnValue = false;
                return false;
            }
            return true;
        }

        /* Máscaras ER */
        function mascara(o, f) {
            v_obj = o
            v_fun = f
            setTimeout("execmascara()", 1)
        }
        function execmascara() {
            v_obj.value = v_fun(v_obj.value)
        }
        function mtel(v) {
            v = v.replace(/\D/g, "");             //Remove tudo o que não é dígito
            v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
            v = v.replace(/(\d)(\d{4})$/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
            return v;
        }
    </script>

</head>
<body>
<?php include '../header.php'; ?>
   
        <div class="row-fluid" style="width: 70; text-align: center">
            
            <div class="text-center" >
                <h1>Inscrição
                Festival <?php
                    foreach ($con as $item) {
                        echo $item->nome;
                    }
                    ?></h1>
            </div>
        </div>
    
    <div class="container-index mt-5" id="container">
        <?php
        foreach($interprete as $inscrito){
        ?>

        <form action="../cadastro/editarInscricao.php" method="post" style="width: 70%;" name="form">
            <input type="hidden" name="festival" id="festival" value="<?php echo $inscrito->festival;
            ?>">
            
            <input type="hidden" name="id" id="id" value="<?php echo $inscrito->id; ?>">

                   <fieldset>
                      
                       <p style="width:100%;text-align:center;">
                       <a class="btn btn-primary" target="_blank" href="https://www.pibema.pr.gov.br/festibema/pages/regulamento/regulamento%20Festival%20V%20Pinha%20da%20Cancao%20de%20Ibema.pdf"><i class="icon-circle-arrow-down icon-white"></i> Regulamento de Participação no Festival</a></p>
                <legend>Edição de interprete</legend>
                <div class="row-fluid">
                    <div class="span12">
                        <label>Nome</label>
                        <input type="text" id="nome" name="nome" style="width: 99%;" value="<?php echo $inscrito->nome; ?>"  >
                        <div class="row-fluid">
                            <div class="span4">
                                <label>Data de nascimento</label>
                                <input type="date" id="nascimento" name="nascimento" style="width: 95%;" value="<?php echo $inscrito->nascimento; ?>" >
                            </div>
                            <div class="span4">
                                <label>RG</label>
                                <input type="text" id="rg" name="rg" style="width: 99%;" value="<?php echo $inscrito->rg; ?>" >
                            </div>
                            <div class="span4">
                                <label>CPF</label>
                                <input type="text" id="cpf" name="cpf" style="width: 99%;" onBlur="ValidarCPF(form.cpf);" 
                                       onKeyPress="MascaraCPF(form.cpf);" maxlength="14"  value="<?php echo $inscrito->cpf; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <label>Telefone</label>
                        <input type="text" id="telefone" name="telefone" onkeyup="mascara(this, mtel);" maxlength="15" style="width: 95%;"  value="<?php echo $inscrito->telefone; ?>">
                    </div>
                    <div class="span4">
                        <label>Celular</label>
                        <input type="text" id="celular" name="celular" onkeyup="mascara(this, mtel);" maxlength="15" style="width: 99%;"  value="<?php echo $inscrito->celular; ?>">
                    </div>
                    <div class="span4">
                        <label>E-mail</label>
                        <input type="email" id="email" name="email" style="width: 99%;"  value="<?php echo $inscrito->email; ?>">
                    </div>
                </div>
                <label>Infomaçõs adicionais/Outros (Opcional)</label>
                <input type="text" id="informacao_interprete" name="informacao_interprete" style="width: 99%;"  value="<?php echo $inscrito->informacoes_interprete; ?>">

                <div class="row-fluid">
                    <div class="span2">
                        <label>Cep</label>
                        <input type="text" id="cep" name="cep" style="width: 98%;"  value="<?php echo $inscrito->cep; ?>">
                    </div>
                    <div class="span1">
                        <label>UF</label>
                        <input name="uf" type="text" id="uf" style="width: 88%"  value="<?php echo $inscrito->uf; ?>"/>
                    </div>
                    <div class="span7">
                        <label>Endereço</label>
                        <input name="rua" type="text" id="rua" style="width: 98%"  value="<?php echo $inscrito->rua; ?>"/>
                    </div>
                    <div class="span2">
                        <label>Número</label>
                        <input name="numero" type="text" id="numero" style="width: 94%"  value="<?php echo $inscrito->numero; ?>"/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <label>Bairro</label>
                        <input name="bairro" type="text" id="bairro" style="width: 98%"  value="<?php echo $inscrito->bairro; ?>"/>
                        <input name="ibge" type="hidden" id="ibge"/>
                    </div>
                    <div class="span6">
                        <label>Cidade</label>
                        <input name="cidade" type="text" id="cidade" style="width: 98%"  value="<?php echo $inscrito->cidade; ?>"/>
                    </div>
                </div>

            </fieldset>
            <br>
            <fieldset>
                <legend>Canção</legend><br>
                <div class="row-fluid">
                    <div class="span3">
                        <label>Categoria</label>
                        <?php $cat = $inscrito->categoria;?>
                        <select id="categoria" name="categoria"  style="width: 98%">
							<option value="gospel" <?php echo ($cat == "gospel")?"selected":""; ?>>Gospel</option>
							<option value="gaucho" <?php echo ($cat == "gaucho")?"selected":""; ?>>Gaucho</option>
							<option value="infantil" <?php echo ($cat == "infantil")?"selected":""; ?>>Infantil</option>
							<option value="juvenil" <?php echo ($cat == "juvenil")?"selected":""; ?>>Infanto Juvenil</option>
							<option value="mpb" <?php echo ($cat == "mpb")?"selected":""; ?>>MPB</option>
							<option value="nativista" <?php echo ($cat == "nativista")?"selected":""; ?>>Nativista</option>
							<option value="pagode" <?php echo ($cat == "pagode")?"selected":""; ?>>Pagode</option>
							<option value="pop" <?php echo ($cat == "pop")?"selected":""; ?>>Pop</option>
							<option value="popular" <?php echo ($cat == "popular")?"selected":""; ?>>Popular</option>
							<option value="rap" <?php echo ($cat == "rap")?"selected":""; ?>>Rap</option>
                            <option value="sertanejo" <?php echo ($cat == "sertanejo")?"selected":""; ?>>Sertanejo</option>
                        </select>
                    </div>
                    <div class="span3">
                        <label>Canção</label>
                        <input name="cancao" type="text" id="cancao" style="width: 98%" value="<?php echo $inscrito->cancao; ?>"/>
                    </div>
                    <div class="span3">
                        <label>Compositor</label>
                        <input name="compositor" type="text" id="compositor" style="width: 98%" value="<?php echo $inscrito->compositor; ?>"/>
                    </div>
                    <div class="span3">
                        <label>Gravado por</label>
                        <input name="gravado_por" type="text" id="gravado_por" style="width: 95%" value="<?php echo $inscrito->gravado_por; ?>"/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <label>Link de vídeo ou audio com prévia de sua apresentação</label>
                        <input name="link" type="text" id="link" style="width: 98%" value="<?php echo $inscrito->link; ?>"/>
                    </div>
                    <div class="span6">
                        <label>Informações adicionais/Outros (Opcional)</label>
                        <input name="informacao_cancao" type="text" id="informacao_cancao" style="width: 98%" value="<?php echo $inscrito->informacao_cancao; ?>"/>
                    </div>
                </div>
                <label>Letra da canção</label>
                <textarea  class="textarea" rows="6" style="width: 99%;" name="letra" rows="5" cols="500"><?php echo $inscrito->letra; ?></textarea>
                <input type="hidden" id="tela" name="tela" value="edicao_inscricao">
            </fieldset>
            <div class="modal-footer mt-4">
                <input class="btn btn-primary" id="botao-festival" type="submit" value="Atualizar inscrição" >
            </div>
        </form>
        <?php } ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            CKEDITOR.replace("letra", {
                height: 260,
                contentsCss: ['http://cdn.ckeditor.com/4.5.2/standard-all/contents.css', 'assets/css/classic.css']
            });

            $("#cpf").mask("999.999.999-99");
            $("#cep").mask("99999-999");
        });
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['inscricao_festival'])) {

        echo '<script>
                    Swal.fire({
                        title: \'Sucesso!\',
                        text: \'Inscrição realizada com sucesso!\',
                        icon: \'success\',
                        confirmButtonText: \'Ok\'
                      })
            </script>';
        unset($_SESSION['inscricao_festival']);
    
    }
    ?>
    <?php include '../footer.php'; ?>
</body>
</html>