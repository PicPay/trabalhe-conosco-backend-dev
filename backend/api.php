<?php
	
	include "conexaobd.php";
	include "consulta.php";
	include "autenticacao.php";
	
	$metodo     = $_SERVER['REQUEST_METHOD'];	
	$parametros = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	
	switch ($metodo) 
	{
		case 'GET':
		{
			if( $parametros[0] && $parametros[2] )
			{
				pesquisar(intval($parametros[1]), $parametros[0], $conexao, $parametros[2]); 
			}	
			break;
		}
		
		case 'PUT':
		{
			atualizar_autenticacao( $parametros[0], $conexao );
		}
		break;
		
		case 'POST': //insert
		break;
		
		case 'DELETE': //delete
		break;
	}
	
?>