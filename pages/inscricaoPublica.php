<?php
if (!isset($_SESSION)) {
    session_start();
}
include ("../conect/conectaMysqlOO.php");

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

        <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css"/>


        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">


        <link rel="shortcut icon" href="../img/festIbemaFavicon.png" type="image/x-icon">

        <!-- Adicionando JQuery -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
        <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
        <script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
        <script type="text/javascript" src="../js/jquery.maskedinput-1.1.4.pack.js"/></script>

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

    <div class="hero-unit">
        <div class="row-fluid" style="width: 70; text-align: center">
            <div class="span6" style=" "><img src="../img/music-barras-256.png" style="height: 128px;"></div>
            <div class="span6">
                <h1>Inscrição</h1>
                <p style="margin-left: -140px;   ">Festival <?php
                    foreach ($con as $item) {
                        echo $item->nome;
                    }
                    ?></p>
            </div>
        </div>
    </div>
    <div class="container-index" id="container">
        <form action="cadastro/inscricaoFestival.php" method="post" style="width: 70%;" name="form">
            <input type="hidden" name="festival" id="festival" value="<?php
            foreach ($con as $item) {
                echo $item->festivalAtivo;
            }
            ?>"
                   <fieldset>
                       <?php
                       if (isset($_SESSION['msg'])) {
                           echo $_SESSION['msg'];
                           unset($_SESSION['msg']);
                       }
                       ?>
                       <p style="width:100%;text-align:center;">
                       <a class="btn btn-primary" target="_blank" href="https://www.pibema.pr.gov.br/festibema/pages/regulamento/regulamento%20Festival%20V%20Pinha%20da%20Cancao%20de%20Ibema.pdf"><i class="icon-circle-arrow-down icon-white"></i> Regulamento de Participação no Festival</a></p>
                <legend>Interprete</legend>
                <div class="row-fluid">
                    <div class="span12">
                        <label>Nome</label>
                        <input required type="text" id="nome" name="nome" style="width: 99%;" >
                        <div class="row-fluid">
                            <div class="span4">
                                <label>Data de nascimento</label>
                                <input required type="date" id="nascimento" name="nascimento" style="width: 95%;" >
                            </div>
                            <div class="span4">
                                <label>RG</label>
                                <input required type="text" id="rg" name="rg" style="width: 99%;" >
                            </div>
                            <div class="span4">
                                <label>CPF</label>
                                <input required type="text" id="cpf" name="cpf" style="width: 99%;" onBlur="ValidarCPF(form.cpf);" 
                                       onKeyPress="MascaraCPF(form.cpf);" maxlength="14">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span4">
                        <label>Telefone</label>
                        <input type="text" id="telefone" name="telefone" onkeyup="mascara(this, mtel);" maxlength="15" style="width: 95%;" >
                    </div>
                    <div class="span4">
                        <label>Celular</label>
                        <input required type="text" id="celular" name="celular" onkeyup="mascara(this, mtel);" maxlength="15" style="width: 99%;" >
                    </div>
                    <div class="span4">
                        <label>E-mail</label>
                        <input required type="email" id="email" name="email" style="width: 99%;" >
                    </div>
                </div>
                <label>Infomaçõs adicionais/Outros (Opcional)</label>
                <input type="text" id="informacao_interprete" name="informacao_interprete" style="width: 99%;">

                <div class="row-fluid">
                    <div class="span2">
                        <label>Cep</label>
                        <input required type="text" id="cep" name="cep" style="width: 98%;" >
                    </div>
                    <div class="span1">
                        <label>UF</label>
                        <input required name="uf" type="text" id="uf" style="width: 88%"/>
                    </div>
                    <div class="span7">
                        <label>Endereço</label>
                        <input required name="rua" type="text" id="rua" style="width: 98%"/>
                    </div>
                    <div class="span2">
                        <label>Número</label>
                        <input required name="numero" type="text" id="numero" style="width: 94%"/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <label>Bairro</label>
                        <input name="bairro" type="text" id="bairro" style="width: 98%"/>
                        <input required name="ibge" type="hidden" id="ibge"/>
                    </div>
                    <div class="span6">
                        <label>Cidade</label>
                        <input required name="cidade" type="text" id="cidade" style="width: 98%"/>
                    </div>
                </div>

            </fieldset>
            <br>
            <fieldset>
                <legend>Canção</legend>
                <div class="row-fluid">
                    <div class="span3">
                        <label>Categoria</label>
                        <select required id="categoria" name="categoria">
                            <option value="sertanejo"selected>Sertanejo</option>
							<option value="mpb" >MPB</option>
							<option value="crista">Cristã</option>
							<option value="pagode">Pagode</option>
							<option value="pop">Pop</option>
							<option value="rap">Rap</option>
							<option value="reggae">Reggae</option>
							<option value="rock">Rock</option>
							<option value="juvenil">Infanto Juvenil</option>
                        </select>
                    </div>
                    <div class="span3">
                        <label>Canção</label>
                        <input required name="cancao" type="text" id="cancao" style="width: 98%"/>
                    </div>
                    <div class="span3">
                        <label>Compositor</label>
                        <input required name="compositor" type="text" id="compositor" style="width: 98%"/>
                    </div>
                    <div class="span3">
                        <label>Gravado por</label>
                        <input required name="gravado_por" type="text" id="gravado_por" style="width: 95%"/>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <label>Link de vídeo ou audio com prévia de sua apresentação</label>
                        <input required name="link" type="text" id="link" style="width: 98%"/>
                    </div>
                    <div class="span6">
                        <label>Informações adicionais/Outros (Opcional)</label>
                        <input name="informacao_cancao" type="text" id="informacao_cancao" style="width: 98%"/>
                    </div>
                </div>
                <label>Letra da canção</label>
                <textarea  class="textarea" required rows="6" style="width: 99%;" name="letra" rows="5" cols="500"></textarea>
            </fieldset>
            <div class="modal-footer">
                <input class="btn btn-primary" id="botao-festival" type="submit" value="Enviar inscrição" >
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            CKEDITOR.replace("letra", {
                height: 260,
                contentsCss: ['http://cdn.ckeditor.com/4.5.2/standard-all/contents.css', 'assets/css/classic.css']
            });
           
            $(".close").click(function () {
                $(".alert").hide();
            });

            $("#cpf").mask("999.999.999-99");
            $("#cep").mask("99999-999");
        });
    </script>
</body>
</html>