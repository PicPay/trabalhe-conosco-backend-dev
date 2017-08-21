var pagina = 0;
var nomePesquisa = "";
var ultimapagina = true;
var uuid = "";

function UUID() 
{
	$.ajax(
	{
		url: 'backend/api.php/'+ $("#uuid").val(),
		method: 'PUT',
		data: "",
		success: function(data) 
		{
			objetos = JSON.parse(data);
			console.log(objetos[0].uuid);
			$("#uuid").val(objetos[0].uuid);
		}
	});
} 

setInterval( UUID, 5000);

function API()
{	
	$.ajax(
	{
		url: 'backend/api.php/'+nomePesquisa+'/'+pagina+'/'+uuid,
		method: 'GET',
		data: "",
		success: function(data) 
		{
			objetos = JSON.parse(data);
		
			html = "<tr><th>#</th><th>Nome</th><th>Usuário</th><th>Relevância</th></tr>";
			
			ultimapagina = true;
			var linha = 0;
			
			for (x in objetos) 
			{	
				linha = parseInt(x);
				
				if( objetos[x].erro )
				{
					alert(objetos[x].erro);
					return;
				}
				
				if( linha == 15 )
				{
					ultimapagina = false;
					break;
				}
				
				linha++;
				
				linha = linha + (pagina)*15;
				
				html += "<tr><td>" + linha + "</td><td>"
								   + objetos[x].nome + "</td><td>" 
								   + objetos[x].username + "</td><td>" 
								   + objetos[x].r1 + "</td></tr>";
			}
		
			controlePagina();
			$( "#resultados" ).empty().append( html );
		}
	});
}

function controlePagina()
{
	if( pagina == 0 )
	{
		$("#btAnterior").hide();
	}
	else
	{
		$("#btAnterior").show();
	}
	
	if( ultimapagina )
	{
		$("#btProximo").hide();
	}
	else
	{
		$("#btProximo").show();
	}
}

function pesquisar()
{
	pagina = 0;
	nomePesquisa = $("#nomePesquisa").val();
	uuid = $("#uuid").val();
	
	API();
}

function anterior()
{
	if ( pagina > 0 )
	{
		pagina--;
		API();
	}			
}

function proximo()
{
	pagina++;
	API();
}