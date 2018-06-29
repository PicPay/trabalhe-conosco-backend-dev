// JavaScript Document

var date = new Date();
var d = date.getDate();
var m = date.getMonth() + 1;
var y = date.getFullYear();
var n = date.toISOString();
var tam = n.length - 5;
var agora = n.substring(0, tam);

//sequencia de comandos necessária para estrair a pasta raiz do endereço,
//ou seja, qual módulo está sendo utilizado (ex: salao, odonto, etc)
app = window.location.pathname;
app = app.substring(1);
pos = app.indexOf('/');
app = app.substring(0, pos);

//Captura a data do dia e carrega no campo correspondente
var currentDate = moment();

/*
 * Função utilizada geralmente para formulários que contenham dois campos de data
 * em sequência, ao digitar o primeiro campo ele pula automaticamente para o
 * campo data seguinte, agilizando o preenchimento.
 *
 * @param {date} valor
 * @param {string} campo
 * @returns {null}
 */
function calculaImc(peso, altura, imc) {
    //busca os valores
    var peso = $("#"+peso).val();
    var altura = $("#"+altura).val();

    //c = Math.pow(altura.replace(".","").replace(",","."), 2);

    var val = (peso.replace(".","").replace(",",".") / Math.pow(altura.replace(".","").replace(",","."), 2)) * 10000;
    //console.log("OI >>> "+peso+" % "+altura+" % "+val+" % ");

    //o clearance é escrito no seu campo no formulário
    if (peso && altura)
        $('#'+imc).val(mascaraValorReal(val));

}

/*
 * Função responsável por aplicar a máscara de valor real com separação de
 * decimais e milhares.
 *
 * @param {float} value
 * @returns {decimal}
 */
function mascaraValorReal(value) {

    var r;
    r = value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    r = r.replace(/[,.]/g, function (m) {
        // m is the match found in the string
        // If `,` is matched return `.`, if `.` matched return `,`
        return m === ',' ? '.' : ',';
    });
    return r;

}

/*
 * Função utilizada geralmente para formulários que contenham dois campos de data
 * em sequência, ao digitar o primeiro campo ele pula automaticamente para o
 * campo data seguinte, agilizando o preenchimento.
 *
 * @param {date} valor
 * @param {string} campo
 * @returns {null}
 */
function autotab(valor, prox) {

    regex = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    //console.log("OI >>> "+prox+" % "+regex.test(valor));
    if (regex.test(valor))
        $('#'+prox).focus();

}


/*
 * Função destinada aos inputs do tipo radio, exibe ou não uma determianda div
 *
 * @param {obj} valor
 * @param {string} campo
 * @returns {null}
 */
function checkboxShowHide(valor, campo) {
    (valor.checked == true) ? $('#Div'+campo).show() : $('#Div'+campo).hide();
}

/*
 * Função destinada aos botões do tipo radio, em que intercalam, geralmente,
 * entre duas opções (aprovado, reprovado, por ex) e essas opções intercalam
 * entre duas cores (verde, vermelho, por ex).
 *
 * @param {string} campo
 * @param {string} opcoes
 * @param {string} valor
 * @param {string} cor0
 * @param {string} cor1
 * @returns {null}
 */
function botaoTrocaCor(campo, opcoes, valor, cor0, cor1) {

    var o = opcoes.split("|");
    var c = o.length;

    //console.log('oi ' + campo + ' ## ' + opcoes + ' $$ ' + valor);
    //console.log('oioioi ' + o[0] + ' ## ' + o[1] + ' && ' + c);

    for (i=0; i < c; i++) {

        if (o[i] == valor)
            $('#'+campo+o[i]).addClass('btn-'+cor0).removeClass('btn-secondary');
        else
            $('#'+campo+o[i]).addClass('btn-secondary').removeClass('btn-'+cor1);
    }


}

/*
 * Função destinada aos botões do tipo radio, exibe ou não uma determianda div
 *
 * @param {string} campo
 * @param {string} valor
 * @returns {null}
 */
function botaoShowHide(campo, valor) {
    (valor == 'show') ? $('#Div'+campo).show() : $('#Div'+campo).hide();
}

/*
 * Função responsável por calcular o produto e aplicar o resultado em um outro campo
 *
 * @param {string} value
 * @returns {decimal}
 */
//function showHideDiv(valor, campo, div, opcoes, autofocus) {
function showHideDiv(valor, campo, opcoes, autofocus) {

    if (opcoes == 0) {

        if (valor == 0)
            $('.' + campo).attr("style", "display:none;");
        else
            $('.' + campo).removeAttr("style");

    }
    else {
        var o = opcoes.split("|");
        //var autofocus = autofocus.split("|");

        //console.log('oi2 ' + campo + ' ## ' + opcoes + ' $$ ' + valor);
        //console.log('oioioi ' + o[0] + ' ## ' + o[1] + ' && ' + c);

        for (i=0; i < o.length; i++) {
            $('.' + campo + o[i]).attr("style", "display:none;");
            if( document.getElementById('#' + campo + valor) ) {
                //console.log('#' + autofocus + valor);
                $('.' + campo + valor).removeAttr("style");
                //$('#' + autofocus + valor).focus();
                //$('#DataInicioTratamentoD').focus();
            }

        }
    }

}

//As proximas funções de timeout servem para sumir com a mensagem de alerta
//no topo da página após executar alguma operação com controladores
setTimeout(function () {
    $('#hidediv').fadeOut('slow');
}, 3000); // <-- time in milliseconds

setTimeout(function () {
    $('#hidediverro').fadeOut('slow');
}, 10000); // <-- time in milliseconds


$(document).ready(function () {

    $(".Data").mask("99/99/9999");
    $(".Cpf").mask("999.999.999-99");
    $(".Cep").mask("99999-999");
    $(".TituloEleitor").mask("9999.9999.9999");

    $(".Telefone").mask("(99) 9999-9999");

    $(".Prontuario").mask("99.99.99");
    $(".CodigoExame").mask("***-*?*******");

    //$.mask.definitions['~'] = '([0-9] )?';
    $(".Celular").mask("(99) 9999?9-9999");

    $(".CelularVariavel").on("blur", function () {
        var last = $(this).val().substr($(this).val().indexOf("-") + 1);

        if (last.length == 3) {
            var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
            var lastfour = move + last;

            var first = $(this).val().substr(0, 9);

            $(this).val(first + '-' + lastfour);
        }
    });

    $(".Autotab").keyup(function () {
        if (this.value.length == this.maxLength) {
          $(this).next('.Autotab').focus();
        }
    });

    $(".clickable-row").click(function () {
        window.document.location = $(this).data("href");
    });

    setInterval(function() {

        if ($("#PiscaAlerta").attr("class") == 'bg-white') {
            $("#PiscaAlerta").attr("class", "bg-warning");
            //console.log('oi1 ' + $("#PiscaAlerta").attr("class"));
        }
        else {
            $("#PiscaAlerta").attr("class", "bg-white");
            //console.log('oi2');
        }
    }, 500);

    //$.mask.definitions['d']='/[0-9]+/';
    //$(".Inteiro").mask("999999999",{placeholder:" "});

    $(".Decimal").maskMoney({
        //prefix:'R$ ',
        allowNegative: false,
        thousands: '.',
        decimal: ',',
        affixesStay: false
    });

    $(".DecimalSemPonto").maskMoney({
        //prefix:'R$ ',
        allowNegative: false,
        //thousands: '.',
        decimal: ',',
        affixesStay: false
    });

    $('.Chosen').chosen({
        disable_search_threshold: 10,
        multiple_text: "Selecione uma ou mais opções",
        single_text: "Selecione uma opção",
        no_results_text: "Nenhum resultado para",
        width: "100%"
    });

    /*
     * As duas funções a seguir servem para exibir ou ocultar uma div em função
     * do seu nome
     */
    $("input[id$='hide']").click(function () {
        var n = $(this).attr("name");
        $("#" + n).hide();
    });
    $("input[id$='show']").click(function () {
        var n = $(this).attr("name");
        $("#" + n).show();
    });

    /*
     * Função específica para campos do tipo checkbox que exibe/oculta um bloco
     * de acordo com a opção marcada nos checkboxes que chamarem esta opção
     */
    $("input[id$='CheckboxShowHide']").click(function () {
        var n = $(this).attr("name");
        n = n.substring(0,n.indexOf("["));
        ($(this).is(":checked")) ? $("#" + n).show() : $("#" + n).hide();
    });

    /*
     * A função a seguir servem para exibir ou ocultar uma div em função do
     * valor selecionado no select/pulldown
     */
    $('#SelectShowHide').change(function () {
        $('.colors').hide();
        $('.div' + $(this).val()).show();
    });

    //$(".DivHide").hide();

    $('#SelectShowHideId').change(function () {
        var n = $(this).attr("name");
        //alert(n + $(this).val());
        //$('#' + n).hide();
        console.log(n + $(this).val());
        $('.' + n).hide();
        $('#' + n + $(this).val()).show();
    });

    $(".DatePicker").datetimepicker({
        tooltips: {
            today: 'Hoje',
            clear: 'Limpar seleção',
            close: 'Fechar este menu',
            selectMonth: 'Selecione um mês',
            prevMonth: 'Mês anterior',
            nextMonth: 'Próximo mês',
            selectYear: 'Selecione um ano',
            prevYear: 'Ano anterior',
            nextYear: 'Próximo ano',
            selectDecade: 'Selecione uma década',
            prevDecade: 'Década anterior',
            nextDecade: 'Próxima década',
            prevCentury: 'Centenário anterior',
            nextCentury: 'Próximo centenário',
            incrementHour: 'Aumentar hora',
            decrementHour: 'Diminuir hora',
            incrementMinute: 'Aumentar minutos',
            decrementMinute: 'Diminuir minutos',
            incrementSecond: 'Aumentar segundos',
            decrementSecond: 'Diminuir segundos'
        },
        showTodayButton: true,
        showClose: true,
        format: 'DD/MM/YYYY',
        locale: 'pt-br'
    });

});
