//! moment.js locale configuration
//! locale : brazilian portuguese (pt-br)
//! author : Caio Ribeiro Pereira : https://github.com/caio-ribeiro-pereira

;(function (global, factory) {
   typeof exports === 'object' && typeof module !== 'undefined'
       && typeof require === 'function' ? factory(require('../moment')) :
   typeof define === 'function' && define.amd ? define(['moment'], factory) :
   factory(global.moment)
}(this, function (moment) { 'use strict';


    var pt_br = moment.defineLocale('pt-br', {
        months : 'Janeiro_Fevereiro_Mar�o_Abril_Maio_Junho_Julho_Agosto_Setembro_Outubro_Novembro_Dezembro'.split('_'),
        monthsShort : 'Jan_Fev_Mar_Abr_Mai_Jun_Jul_Ago_Set_Out_Nov_Dez'.split('_'),
        weekdays : 'Domingo_Segunda-Feira_Ter�a-Feira_Quarta-Feira_Quinta-Feira_Sexta-Feira_S�bado'.split('_'),
        weekdaysShort : 'Dom_Seg_Ter_Qua_Qui_Sex_S�b'.split('_'),
        weekdaysMin : 'Dom_2�_3�_4�_5�_6�_S�b'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'HH:mm:ss',
            L : 'DD/MM/YYYY',
            LL : 'D [de] MMMM [de] YYYY',
            LLL : 'D [de] MMMM [de] YYYY [�s] HH:mm',
            LLLL : 'dddd, D [de] MMMM [de] YYYY [�s] HH:mm'
        },
        calendar : {
            sameDay: '[Hoje �s] LT',
            nextDay: '[Amanh� �s] LT',
            nextWeek: 'dddd [�s] LT',
            lastDay: '[Ontem �s] LT',
            lastWeek: function () {
                return (this.day() === 0 || this.day() === 6) ?
                    '[�ltimo] dddd [�s] LT' : // Saturday + Sunday
                    '[�ltima] dddd [�s] LT'; // Monday - Friday
            },
            sameElse: 'L'
        },
        relativeTime : {
            future : 'em %s',
            past : '%s atr�s',
            s : 'poucos segundos',
            m : 'um minuto',
            mm : '%d minutos',
            h : 'uma hora',
            hh : '%d horas',
            d : 'um dia',
            dd : '%d dias',
            M : 'um m�s',
            MM : '%d meses',
            y : 'um ano',
            yy : '%d anos'
        },
        ordinalParse: /\d{1,2}�/,
        ordinal : '%d�'
    });

    return pt_br;

}));