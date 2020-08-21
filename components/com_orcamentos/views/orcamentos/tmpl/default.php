<?php
defined('_JEXEC') or die('Restricted access');
?>
<script>
    function mascara_data(data) {
        var mydata = '';
        mydata = mydata + data;
        if (mydata.length == 2) {
            mydata = mydata + '/';
            document.forms[0].date_event.value = mydata;
        }
        if (mydata.length == 5) {
            mydata = mydata + '/';
            document.forms[0].date_event.value = mydata;
        }
        if (mydata.length == 10) {
            verifica_data();
        }
    }

    function verifica_data() {

        dia = (document.forms[0].date_event.value.substring(0, 2));
        mes = (document.forms[0].date_event.value.substring(3, 5));
        ano = (document.forms[0].date_event.value.substring(6, 10));

        situacao = "";
        // verifica o dia valido para cada mes 
        if ((dia < 01) || (dia < 01 || dia > 30) && (mes == 04 || mes == 06 || mes == 09 || mes == 11) || dia > 31) {
            situacao = "falsa";
        }

        // verifica se o mes e valido 
        if (mes < 01 || mes > 12) {
            situacao = "falsa";
        }

        // verifica se e ano bissexto 
        if (mes == 2 && (dia < 01 || dia > 29 || (dia > 28 && (parseInt(ano / 4) != ano / 4)))) {
            situacao = "falsa";
        }

        if (document.forms[0].date_event.value == "") {
            situacao = "falsa";
        }

        if (situacao == "falsa") {
            alert("Data inválida!");
            document.forms[0].date_event.focus();
        }
    }
    function numbersonly(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (unicode != 8) { //if the key isn't the backspace key (which we should allow)
            if (unicode < 48 || unicode > 57) //if not a number
                return false //disable key press
        }
    }
</script>

<script type="text/javascript">
    function checarEmail() {
        if (document.forms[0].email.value == ""
                || document.forms[0].email.value.indexOf('@') == -1
                || document.forms[0].email.value.indexOf('.') == -1)
        {
            alert("Por favor, informe um E-MAIL válido!");
            return false;
        }
    }
</script>


<script type="text/javascript">
    function validarCPF(cpf) {
        var filtro = /^\d{3}.\d{3}.\d{3}-\d{2}$/i;

        if (!filtro.test(cpf))
        {
            window.alert("CPF inválido. Tente novamente.");
            return false;
        }

        cpf = remove(cpf, ".");
        cpf = remove(cpf, "-");

        if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
                cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
                cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
                cpf == "88888888888" || cpf == "99999999999")
        {
            window.alert("CPF inválido. Tente novamente.");
            return false;
        }

        soma = 0;
        for (i = 0; i < 9; i++)
        {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }

        resto = 11 - (soma % 11);
        if (resto == 10 || resto == 11)
        {
            resto = 0;
        }
        if (resto != parseInt(cpf.charAt(9))) {
            window.alert("CPF inválido. Tente novamente.");
            return false;
        }

        soma = 0;
        for (i = 0; i < 10; i++)
        {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        if (resto == 10 || resto == 11)
        {
            resto = 0;
        }

        if (resto != parseInt(cpf.charAt(10))) {
            window.alert("CPF inválido. Tente novamente.");
            return false;
        }

        return true;
    }

    function remove(str, sub) {
        i = str.indexOf(sub);
        r = "";
        if (i == -1)
            return str;
        {
            r += str.substring(0, i) + remove(str.substring(i + sub.length), sub);
        }

        return r;
    }

    /**
     * MASCARA ( mascara(o,f) e execmascara() ) CRIADAS POR ELCIO LUIZ
     * elcio.com.br
     */
    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }

    function cpf_mask(v) {
        v = v.replace(/\D/g, "")                 //Remove tudo o que não é dígito
        v = v.replace(/(\d{3})(\d)/, "$1.$2")    //Coloca ponto entre o terceiro e o quarto dígitos
        v = v.replace(/(\d{3})(\d)/, "$1.$2")    //Coloca ponto entre o setimo e o oitava dígitos
        v = v.replace(/(\d{3})(\d)/, "$1-$2")   //Coloca ponto entre o decimoprimeiro e o decimosegundo dígitos
        return v
    }
</script>


<script type="text/javascript">
    /* Máscaras TELEFONE */
    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }
    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }
    function mtel(v) {
        v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
        return v;
    }
    function id(el) {
        return document.getElementById(el);
    }
    /*TELEFONE 1*/
    window.onload = function () {
        id('telefone').onkeyup = function () {
            mascara(this, mtel);
        }
        id('celular').onkeyup = function () {
            mascara(this, mtel);
        }
    }
</script>

<script type="text/javascript">
    document.getElementById("uploadBtn").onchange = function () {
        document.getElementById("uploadFile").value = this.value;
    };
</script>

<div class="orcamentos-form">
    <h1><?php echo utf8_encode('Solicite seu or�amento'); ?></h1>
    <form id="orcamento-form" action="<?php echo JRoute::_('index.php?option=com_orcamentos&view=orcamentos&layout=default'); ?>" method="post" class="form-vainsereformlidate form-horizontal" enctype="multipart/form-data">

        <div class="dados">
            <input type="text" name="nome" id="nome" required="true" placeholder="Nome"/>
            <input type="text" name="tel" id="telefone" maxlength="15" placeholder="Telefone"/>
            <input type="email" name="email" class="input" id="email" required="true" onblur="checarEmail();" placeholder="E-mail"/>
            <input type="text" name="edificio" id="edificio" placeholder="<?php echo utf8_encode('Nome do Edif�cio'); ?>"/>
            <input type="text" name="endereco" id="endereco" placeholder="<?php echo utf8_encode('Endere�o'); ?>"/>
            <input type="text" name="bairro" id="bairro" placeholder="Bairro"/>
            <input type="text" name="cidade" id="cidade" placeholder="Cidade"/>
            <input type="text" name="cep" id="cep" placeholder="CEP"/>
        </div>

        <div class="unidades">
            <div>
                <label>Qtd Apartamentos</label>
                <input type="number" name="aptos" id="aptos"/>
            </div>
            <div>
                <label>Qtd Salas</label>
                <input type="number" name="salas" id="salas"/>
            </div>
            <div>
                <label>Qtd Garagens</label>
                <input type="number" name="garagens" id="garagens"/>
            </div>
        </div>

        <div class="funcionarios">
            <h4>Zeladores</h4>
            <input type="number" name="qtdzeladores" id="qtdzeladores" placeholder="Quantidade"/>
            <input type="text" name="jornadazelador" id="jornadazelador" placeholder="Jornada de Trabalho"/>
            <h4>Porteiros</h4>
            <input type="number" name="qtdporteiros" id="qtdporteiros" placeholder="Quantidade"/>
            <input type="text" name="jornadaporteiros" id="jornadaporteiros" placeholder="Jornada de Trabalho"/>
            <h4>Faxineiras</h4>
            <input type="number" name="qtdfaxineiras" id="qtdfaxineiras" placeholder="Quantidade"/>
            <input type="text" name="jornadafaxineiras" id="jornadafaxineiras" placeholder="Jornada de Trabalho"/>
            <h4>Outros</h4>
            <input type="number" name="qtdoutros" id="qtdoutros" placeholder="Quantidade"/>
            <input type="text" name="jornadaoutros" id="jornadaoutros" placeholder="Jornada de Trabalho"/>
            <hr>
            <h4><?php echo utf8_encode('Funcion�rios contratados por Condom�nio ou Conservadora'); ?></h4>
            <input type="number" name="qtdfuncionarios" id="qtdfuncionarios" placeholder="Quantidade"/>
        </div>

        <input type="hidden" name="option" value="com_orcamentos" />
        <input type="hidden" name="task" value="orcamentos.enviarorcamento" />
        <input type="submit" value="<?php echo utf8_encode('Enviar Or�amento'); ?>" class="submitform"/>

    </form>
</div>




