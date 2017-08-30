<?php 
require_once("cabecalho.php"); 		
require_once("banco-usuarios.php"); 
require_once("logica-usuario.php");

// Disponibiliza a página apenas se o usuários estiver devidamente logado no sistema.
verificaUsuario();

// Destroi o cookie para realizaçãod e uma nova pesquisa.
setcookie('cookie_chave', "", time() - 3600);
?>	



<?php if(usuarioEstaLogado()) {?>
    <div class="padding50">
        <div align="center"> 
            <img src="imagens/logo.png" alt="Logo PicPay" width="410" height="200">
			    <form action="setcookie.php" method="post">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-10">
		                <p><input class="form-control" type="text" name="busca"></p>
				        <p><button class="btn btn-success"><span class=" glyphicon glyphicon-search"></span> Procurar Usuários</button></p> 
			        </div>
                </form>                    
            </div>
		</div>    
<?php } 

include("rodape.php"); ?>			
