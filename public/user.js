users = null;
nextUuid = '';
prevUuids = [];
paging = 15;

//desabilita os botoes, esconde tela de erro
function beforeStartSearch()
{
	$('#searchInput').attr("disabled", "disabled");
	$('#searchUserButton').attr("disabled", "disabled");
	
	$('#nextPage').attr("disabled", "disabled");
	$('#prevPage').attr("disabled", "disabled");
	
	
	$('#loadingIndicator').show();
	$('#searchError').hide();
	
}

//habilita botoes
function afterSearchAction()
{
	$('#searchInput').removeAttr("disabled");
	$('#searchUserButton').removeAttr("disabled");
	
	$('#nextPage').removeAttr("disabled");
	$('#prevPage').removeAttr("disabled");
	
	$('#loadingIndicator').hide();
}

function removeAllUserTableRows()
{
	$("#foundUsers tbody tr").remove()
}

function fillUserTable(data)
{
	for (i = 0; i < Math.min(paging, data.length); i++)
	{
		$("#foundUsers tbody").append(
				"<tr><td>"+ data[i].username +"</td><td>"+ data[i].name +"</td></tr>"
		);
	}

}

function handleReceivedData(data)
{
	nextUuid = '';
	users = data;

	removeAllUserTableRows();
	fillUserTable(data);

	//exibe mensagem de erro
	if (data.length > 0)
		$("#searchError").hide(0);
	else
		$("#searchError").show(500);

	//desabilita/habilita botao anterior
	if (prevUuids.length > 0)
		$("#prevPage").removeClass("disabled");
	else
		$("#prevPage").addClass("disabled");

	//desabilita/habilita botao proximo
	if (data.length > 15)
	{
		nextUuid = data[15].uuid;
		$("#nextPage").removeClass("disabled");
	}
	else
		$("#nextPage").addClass("disabled");
	
	if (data.length > 0)
	{
		$("#paginaAtual").text("Página " + (prevUuids.length + 1));
		firstIndex = ((prevUuids.length + 1) * paging);
		lastIndex = firstIndex + Math.min(paging, data.length);
		$("#itensExibidos").text("" + firstIndex + "-" + lastIndex)
	}
	else
	{
		$("#paginaAtual").text("");
		$("#itensExibidos").text("");
	}
	
	
	//habilita novamente os botoes de pesquisa
	afterSearchAction();
}



$(document).ready(function() {

	$('#searchInput').on('keypress', function (e) {
		if(e.which === 13){
			$("#searchUserButton").click();
			//Disable textbox to prevent multiple submit
					


			//Do Stuff, submit, etc..

			//Enable the textbox again if needed.
			//$(this).removeAttr("disabled");
		}
	});

	$("#searchUserButton").click( function()
			{
		beforeStartSearch();
		$.ajax({
			url: "/users?paging=" + (paging + 1) + "&" +  $("#searchBySelect").val() + "=" + $("#searchInput").val()
		}).then(function(data) {

			nextUuid = '';
			firstUuid = '';
			prevUuids = [];

			handleReceivedData(data);

		});

			});

	$("#nextPage").click( function()
			{
		if (!users || nextUuid.length <= 0)
			return;
		
		beforeStartSearch();

		//adicionar o primeiro da lista atual em uma pilha de uuids
		//essa lista é utilizada para voltar a lista
		if (users && users.length > 0)
			prevUuids.push(users[0].uuid);

		$.ajax({
			url: "/users?paging=" + (paging + 1) + "&" +  $("#searchBySelect").val() + "=" + $("#searchInput").val() + "&startUUID=" + nextUuid
		}).then(function(data) {
			handleReceivedData(data);
		})

			});

	$("#prevPage").click( function()
			{
		//já voltou tudo que podia
		if (prevUuids.length <= 0)
			return;
		
		beforeStartSearch();

		$.ajax({
			url: "/users?paging=" + (paging + 1) + "&" +  $("#searchBySelect").val() + "=" + $("#searchInput").val() + "&startUUID=" + prevUuids[prevUuids.length - 1]
		}).then(function(data) {
			//remover da lista o ultimo elemento pois voltou com sucesso
			prevUuids.pop();

			handleReceivedData(data);
		})
			});
});
