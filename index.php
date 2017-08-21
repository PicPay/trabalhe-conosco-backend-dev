<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Teste Backend</title>
		<link rel="stylesheet" type="text/css" href="frontend/estilo.css">
        <meta charset="utf-8">
    </head>
	<body onload="UUID();">
		<script type="text/javascript" src="frontend/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<input id="uuid" type="hidden" value="">
		<div id="filtro">		
			<div>
				<p id="titulo" align="center">Teste Backend</p>
			</div>
			<div>
				<p>Pesquise pelo nome ou usuário: </p>
				<p>
					<input style="position:relative; width:99%;" id="nomePesquisa" maxlength="100" type="text" value="">
				</p>
				<p>
					<input type="button" onclick="pesquisar()" value="Pesquisar">
				</p>
			</div>
		</div>
		
		<div id="divControle">
			<p align="center">
				<input id="btAnterior" type="button" onclick="anterior()" value="< anterior">
				<input id="btProximo" type="button" onclick="proximo()" value="próximo >">
			</p>
		</div>
		<script type="text/javascript"> controlePagina(); </script>
		<table id="resultados" style="width:100%">
		</table>
	</body>
</html>
