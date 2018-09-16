/*
* Variaveis globais da API
* (C) João Carlos Pandolfi Santana - 2016
*/

var ajax = {
    /*
    * Funcao de ajax com parametro default POST
    * @params url {String}
    * @params data {String} [DataToSend]
    * @params funcToCall {function} {func(result)}
    * @calls processReqChange
    */
    postAsyncTask: function (funcToCall,url,data) {
        this.localAsyncTask(funcToCall,url,'POST',data);
    },
    
    /*
    * Funcao de ajax Com parametro default GET
    * @params url {String}
    * @params funcToCall {function} {func(result)}
    * @calls processReqChange
    */
    asyncTask: function (funcToCall,url) {
        this.localAsyncTask(funcToCall,url,'GET',null);
    },
    
    /*
    * Funcao de ajax
    * @params url {String}
    * @params type {String} [GET or POST]
    * @params data {String} [DataToSend]
    * @params funcToCall {function} {func(result)}
    * @calls processReqChange
    */
    localAsyncTask: function (funcToCall,url,type,data) {
    //type = GET ou POST
        req = null;
        _funcToCall = funcToCall;
        // Procura por um objeto nativo (Mozilla/Safari)
        if (window.XMLHttpRequest) {
            req = new XMLHttpRequest();
    
        // Procura por uma versão ActiveX (IE)
        } else if (window.ActiveXObject) {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        req.onreadystatechange = this.processReqChange;
        req.funcToCall = funcToCall;
        req.open(type,url,true);
        if(type == "POST")
            req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        req.send(data);
    
    },
    
    /*
    * Função chamada pelo ajax após a execução
    * @calls _funcToCall(result{Json}) {function}
    * @depends _funcToCall
    */
    processReqChange : function () {
        // apenas quando o estado for "completado"
        if (req.readyState == 4) {
            // apenas se o servidor retornar "OK"
            if (req.status ==200){
              req.funcToCall(req.responseText);
                }else{
              req.funcToCall({result:"0",error:req.responseText});
              }
        }
    }
    }