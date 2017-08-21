/*
* Author: Gustavo Grimaldi Campello.
*/


var page = 0;
var key = '';

/*
* Insere uma linha abaixo da ultima na tabela com os dados informados.
*/
function insertValueTable(id, name, username) {

    var table = document.getElementById("tabela");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    cell1.innerHTML = id;
    cell2.innerHTML = name;
    cell3.innerHTML = username;
}

/*
* Faz requisição dos dados paginados anteriores à ultima requisição.
*/
function previousData() {
    page = page - 1;
    send(key, page);
    if (page == 0) {
        document.getElementById("previous-btn").classList.add('disabled');
    } 
}

/*
* Faz requisição dos próximos dados paginados.
*/
function nextData() {
    if(page == 0){
        document.getElementById("previous-btn").classList.remove('disabled');
    }
    page = page + 1;
    send(key, page);
}

/*
* Faz a pesquisa do texto digitado.
*/
function searchText() {
    key = document.getElementById("input-search").value;
    document.getElementById("previous-btn").classList.add('disabled');
    page = 0;
    send(key, page);
}

/*
* Envia a solicitação e trata o retorno inserindo na tabela.
*/
function send(key, page) {
    document.getElementById("loader").classList.add('loader');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == XMLHttpRequest.DONE) {
            document.getElementById("loader").classList.remove('loader');
            var arr = JSON.parse(xhttp.responseText).map((user) => { return {
                id: user.id,
                name: user.name,
                username: user.username
            };});
            if (arr.length == 15){
                document.getElementById("next-btn").classList.remove('disabled');
            }else{
                document.getElementById("next-btn").classList.add('disabled');
            }
            clearTable()
            arr.forEach( element =>{
                insertValueTable(element.id, element.name, element.username);
            });

        }   
    }
    xhttp.open("GET", "/users?page="+ page +"&key="+ key, true);
    xhttp.send();
}

/*
* Limpa a tabela para inserir novos dados ao fazer uma nova requisição.
*/
function clearTable(){
    var table = document.getElementById("tabela");
    table.innerHTML = table.rows[0].innerHTML;
}

