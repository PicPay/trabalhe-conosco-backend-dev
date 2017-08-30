<?php 
require_once("cabecalho.php");
require_once("logica-usuario.php");
?>			
			
        <div class="padding50">
			<?php if(usuarioEstaLogado()) {?>
			    
			    <div align="center">    
			        <p class="text-success">Bem vindo! <?= usuarioLogado() ?> </br> </h2>
			        <form action="logout.php" method="post">
				        <p><button class="btn btn-outline-success">Logout</button></p>
                    </form>
                    <div class="countainer">
				        </form> </br></br>
				        <form action="upload.php" method="post" enctype="multipart/form-data">
				            
				            <p class="text-info">Usuários com prioridade 1:</br>
                            <input type="file" name="Priority1"></br></br>         
                                              
                            <p class="text-info">Usuários com prioridade 2:</br>
                            <input type="file" name="Priority2" ></br></br>
                            
                            <input class ="btn btn-outline-info" type="submit" value="Enviar" name="submit">
                    </form>
                    </div>
                    
			
			<?php } else {?>
			<div align="center">
		        <img src="imagens/login.png" alt="login" class="img-rounded" width="117" height="128">
		        <h2>Login</h2>
		    </div>
            <form action="login.php" method="post">
                   <div align="center">
                       <div class="container">
                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                              <p>Endereço de e-mail: <input class="form-control" type="email" name="email"></p>
                              <p>Senha: <input class="form-control" type="password" name="senha"></p>
                              <p><button class="btn btn-success"><span class="glyphicon glyphicon-off"></span>Enviar</button></p>
                          </div>
                      </div>
                  </div>
            </form>
        </div>
			<?php } ?>

        
<?php include("rodape.php"); ?>			
