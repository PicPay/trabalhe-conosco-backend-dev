//resultado da pesquisa
users = null;

//tamanho da paginacao
pageSize = 15;
authToken = '';

//desabilita os botoes, esconde tela de erro
function beforeStartSearch()
{
	$('.userSearchControl').attr("disabled", "disabled");

	$('#loadingIndicator').show();
	$('#searchError').hide();

}

//habilita botoes
function afterSearchAction()
{
	$('.userSearchControl').removeAttr("disabled");

	$('#loadingIndicator').hide();
}

function removeAllUserTableRows()
{
	$("#foundUsers tbody tr").remove()
}

function fillUserTable(data)
{
	for (i = 0; i < data.content.length; i++)
	{
		$("#foundUsers tbody").append(
				"<tr><td>"+ data.content[i].login +"</td><td>"+ data.content[i].name +"</td></tr>"
		);
	}

}

function handleReceivedData(data)
{
	users = data;

	removeAllUserTableRows();
	fillUserTable(data);

	//exibe mensagem de erro caso nao retornou nada
	if (!data.empty)
		$("#searchError").hide(0);
	else
		$("#searchError").show(500);

	//desabilita/habilita botao anterior e primeira pagina
	if (!data.first)
	{
		$("#prevPage").removeClass("disabled");

		$("#firstPage").removeClass("disabled");
	}
	else
	{
		$("#prevPage").addClass("disabled");

		$("#firstPage").addClass("disabled");
	}

	//desabilita/habilita botao proximo e ultima pagina
	if (!data.last)
	{
		$("#nextPage").removeClass("disabled");

		$("#lastPage").removeClass("disabled");
	}
	else
	{
		$("#nextPage").addClass("disabled");

		$("#lastPage").addClass("disabled");
	}

	if (!data.empty)
	{
		$("#paginaAtual").text("Página " + (data.pageable.pageNumber + 1) + " de " + data.totalPages);
		firstIndex = data.pageable.offset + 1;
		lastIndex = firstIndex + data.pageable.pageSize;
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

function getSearchURL(page)
{
	return "/api/users?size=" + pageSize + 
	"&" +  $("#searchBySelect").val() + "=" + encodeURIComponent($("#searchInput").val()) + 
	"&page=" + page;
}


$(document).ready(function() {

	$("#loginButton").click(function(){

		jsonInput = {};
		jsonInput.username = $("#usernameInput").val();
		jsonInput.password = $("#passwordInput").val();

		console.log(JSON.stringify(jsonInput));
		// send ajax
		$.ajax({
			url: '/login', // url where to submit the request
			type : "POST", // type of action POST || GET
			// dataType: 'json',
			contentType: 'application/json',
			data : JSON.stringify(jsonInput), // post data || get data
			success : function(data, textStatus, request) {
				console.log("success: " + request.getResponseHeader('authorization'));
				authToken = request.getResponseHeader('authorization');
				
				$("#loginForm").hide(100);
			},
			error: function(xhr, resp, text) {
				alert('Usuário ou senha inválido!');
				console.log(xhr, resp, text);
			}
		})
	});


	//se apertou enter
	$('#searchInput').on('keypress', function (e) {
		if(e.which === 13){
			$("#searchUserButton").click();
		}
	});

	$("#searchUserButton").click( function()
			{
		beforeStartSearch();
		$.ajax({
			url: getSearchURL(0),
			beforeSend: function(request) {
				request.setRequestHeader("authorization", authToken);
			}
		}).then(function(data) {
			handleReceivedData(data);

		});

			});

	$("#nextPage").click( function()
			{
		if (!users || users.last)
			return;

		beforeStartSearch();

		$.ajax({
			url: getSearchURL(users.pageable.pageNumber + 1),
			beforeSend: function(request) {
				request.setRequestHeader("authorization", authToken);
			}

		}).then(function(data) {
			handleReceivedData(data);
		})

			});

	$("#prevPage").click( function()
			{
		//já voltou tudo que podia
		if (!users || users.first)
			return;


		beforeStartSearch();

		$.ajax({
			url: getSearchURL(users.pageable.pageNumber - 1),
			beforeSend: function(request) {
				request.setRequestHeader("authorization", authToken);
			}
		}).then(function(data) {
			handleReceivedData(data);
		})
			});

	$("#firstPage").click( function()
			{
		if (!users || users.first)
			return;


		beforeStartSearch();

		$.ajax({
			url: getSearchURL(0),
			beforeSend: function(request) {
				request.setRequestHeader("authorization", authToken);
			}
		}).then(function(data) {
			handleReceivedData(data);
		})
			});


	$("#lastPage").click( function()
			{
		if (!users || users.last)
			return;

		beforeStartSearch();

		$.ajax({
			url: getSearchURL(users.totalPages - 1),
			beforeSend: function(request) {
				request.setRequestHeader("authorization", authToken);
			}
		}).then(function(data) {
			handleReceivedData(data);
		})
			});
});
