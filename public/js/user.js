//resultado da pesquisa
users = null;

//tamanho da paginacao
pageSize = 15;
authToken = '';

//limita o numero de paginas para evitar problemas com uma paginacao muito grande
maxPages =  Math.floor(10000 / pageSize);

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
	{
		$("#searchError").text("Nenhum Usuário Encontrado.");
		$("#searchError").show(500);
	}

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
		$("#paginaAtual").text("Página " + (data.pageable.pageNumber + 1) + " de " + Math.min(data.totalPages, maxPages));
		firstIndex = data.pageable.offset + 1;
		lastIndex = firstIndex + data.pageable.pageSize - 1;
		$("#itensExibidos").text("" + firstIndex + "-" + lastIndex)
	}
	else
	{
		$("#paginaAtual").text("");
		$("#itensExibidos").text("");
	}
}

function getSearchURL(page)
{
	return "/api/users?size=" + pageSize + 
	"&" +  $("#searchBySelect").val() + "=" + encodeURIComponent($("#searchInput").val()) + 
	"&page=" + page;
}

function handleRequestError(jqXHR)
{
	console.log(jqXHR);
	
	
	if (jqXHR.status == 403)
	{
		$('#searchError').text("Consulta não autorizada. Favor faça login.");
		$('#searchError').show(500);
	}
	else
	{
		$('#searchError').text("Erro na consulta.");
		$('#searchError').show(500);
	}
}

$(document).ready(function() {

	$("#logoutButton").click(function(){
		authToken = "";

		$("#loginForm").show(100);
		$("#logoutButton").hide(100);
	});
	
	//se apertou enter
	$('#passwordInput').on('keypress', function (e) {
		if(e.which === 13){
			$("#loginButton").click();
		}
	});
	
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
				$("#logoutButton").show(100);
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

		},
		function(jqXHR, textStatus) {
			handleRequestError(jqXHR);
		})
		.always(function() {
			afterSearchAction();
		})
			}
	);


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
		},
		function(jqXHR, textStatus) {
			handleRequestError(jqXHR);
		}
		).always(function() {
			afterSearchAction();
		})

			}
	);

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
		}, function(jqXHR, textStatus)
		{
			handleRequestError(jqXHR);
		}).always(function() {
			afterSearchAction();
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
		}, function(jqXHR, textStatus)
		{
			handleRequestError(jqXHR);
		}).always(function() {
			afterSearchAction();
		})
			});


	$("#lastPage").click( function()
			{
		if (!users || users.last)
			return;

		beforeStartSearch();

		$.ajax({
			url: getSearchURL( Math.min(users.totalPages, maxPages) - 1),
			beforeSend: function(request) {
				request.setRequestHeader("authorization", authToken);
			}
		}).then(function(data) {
			handleReceivedData(data);
		}, function(jqXHR, textStatus)
		{
			handleRequestError(jqXHR);
		}).always(function() {
			afterSearchAction();
		})
			});
});
