<?php

	function pesquisar($pPagina, $pNome, $conexao, $pUUID)
	{		
		$pagina = 0;
		if( $pPagina )
		{
			$pagina = $pPagina*15;
		}

		if( $pUUID )
		{
			//deleta todos os registros superiores a 5 minutos
			$sql = "DELETE FROM autenticacao WHERE (data+100) < NOW();";
			
			if( !mysqli_query($conexao, $sql) )
			{
				echo '[{"erro":"Erro de autenticação. 1"}]';
			}
			
			$sql = "SELECT * FROM autenticacao WHERE uuid = '$pUUID'";
			
			//executa a consulta no banco
			$resultado = mysqli_query($conexao, $sql);
			
			if(!$resultado )
			{
				echo '[{"erro":"Erro de autenticação. 2"}]';
				mysqli_close($conexao);
				return;
			}
			
			if( mysqli_num_rows($resultado) > 0 ) 
			{
				$linha = mysqli_fetch_row($resultado);
				
				if( $pUUID != $linha[0] )
				{
					echo '[{"erro":"Erro de autenticação. 3"}]';
					mysqli_close($conexao);
					return;
				}
			}
			else
			{
				echo '[{"erro":"Erro de autenticação. 3"}]';
				mysqli_close($conexao);
				return;
			}
		}
		
		$pNome = str_replace(" ", " +", "$pNome");	
		
		//consulta
		$sql = "
		   SELECT usu.nome nome,
				  usu.username username,
				  IF(r1.uuid IS NULL,\"0\", \"2\") + IF(r2.uuid IS NULL,\"0\", \"1\") r1
			 FROM usuarios usu 
		LEFT JOIN relevancia1 r1
			   ON r1.uuid = usu.uuid
		LEFT JOIN relevancia2 r2
			   ON r2.uuid = usu.uuid
			WHERE MATCH(usu.nome, usu.username) AGAINST('+$pNome' IN BOOLEAN MODE)
		 ORDER BY `r1` DESC
			LIMIT $pagina, 16
			   ";

		//executa a consulta no banco
		$resultado = mysqli_query($conexao, $sql);
		 
		//verifica se deu algum problema
		if (!$resultado) 
		{
			echo '[{"erro":"Erro ao consultar no banco."}]';
			mysqli_close($conexao);
			return;
		}
		 
		//monta a resposta no formato json
		echo '[';
		for ($i=0;$i<mysqli_num_rows($resultado);$i++) 
		{
			echo ($i>0?',':'').json_encode( mysqli_fetch_object($resultado) );
		}
		echo ']';
		 
		//fecha a conexao
		mysqli_close($conexao);
	}
?>