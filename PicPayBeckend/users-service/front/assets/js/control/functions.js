var itensList = [];
function insertValueTable() {
    var cod = document.getElementById("cod").value;
    var desc = document.getElementById("desc").value;
    var marcas = document.getElementById("marca").value;
    var quantidade = document.getElementById("qtd").value;
    if (!(cod == "" || desc == "" || marcas == "" || quantidade == "")) {


        document.getElementById("cod").value = "";
        document.getElementById("desc").value = "";
        document.getElementById("marca").value = "";
        document.getElementById("qtd").value = "";

        var table = document.getElementById("tabela");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell1.innerHTML = cod;
        cell2.innerHTML = desc;
        cell3.innerHTML = marcas;
        cell4.innerHTML = quantidade;
        var item = {
            codigo: cod,
            descricao: desc,
            marca: marcas,
            qtd: quantidade
        };
        itensList.push(item);
    }else{
        window.alert("Todos os campos devem ser preenchidos.")
    }
}

function send(){
     var nro = document.getElementById("nropedido").value;
    var client = document.getElementById("cliente").value;
    var Pedido = {
        nroPedido: nro,
        cliente: client,
        itens : itensList
    }
    var send_object = JSON.stringify(Pedido);
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost:8080/Pedidocotacao2/pedidos", true);
    xhttp.send(send_object);
     window.alert("Ein viado com sucesso!")
}


