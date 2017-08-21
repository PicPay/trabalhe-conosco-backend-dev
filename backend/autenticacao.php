<?php
	
	function atualizar_autenticacao($pUUID, $conexao)
	{		
		if( !empty($pUUID) )
		{
			//deleta todos os registros superiores a 5 minutos
			$sql = "UPDATE autenticacao SET data = NOW() WHERE uuid = '$pUUID';";
			
			if( !mysqli_query($conexao, $sql) )
			{
				echo '[{"erro":"Erro de autenticação."}]';
			}
			else
			{
				echo "[{\"uuid\":\"$pUUID\"}]";
			}
			
			//fecha a conexao
			mysqli_close($conexao);
		}
		else
		{
			//executa a consulta no banco
			$resultado = mysqli_query($conexao, "SELECT UUID();");
			
			if (!$resultado) 
			{
				mysqli_close($conexao);
				return;
			}
			
			//monta a resposta no formato json
			if( mysqli_num_rows($resultado) > 0 ) 
			{	
				$linha = mysqli_fetch_row($resultado);
				
				$sql = "INSERT INTO `autenticacao`(`uuid`) VALUES ('$linha[0]')";
				$resultado = mysqli_query($conexao, $sql);
				
				if( $resultado )
				{
					echo "[{\"uuid\":\"$linha[0]\"}]";
				}
				else
				{
					echo '[{"erro":"Erro de autenticação. 0"}]';
				}
				
				mysqli_close($conexao);
			}
		}
	}
?>