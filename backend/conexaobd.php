<?php
	
	include "configbd.php";
	
	//conectar no banco de dados
	$conexao = mysqli_connect($host, $usuario, $senha, $banco);
	
	if( !$conexao )
	{
		echo '[{"erro":"Erro ao conectar no banco."}]';
		mysqli_close($conexao);
		return;
	}
	
	mysqli_set_charset($conexao,'utf8');

?>