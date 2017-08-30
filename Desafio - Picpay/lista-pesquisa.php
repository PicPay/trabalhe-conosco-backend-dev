<?php 
require_once("cabecalho.php");
require_once("banco-usuarios.php");
require_once("routes/db.php");

$varPag=$_GET["pagina"];
$qtdPagina=15;

?>	
<div class="tabbs">
    <div align="center">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-10">
            <p><h4> Resultado da Pesquisa </h4><p>
            <p class ="text-success">Página:<?php echo $varPag?> </p>
            <table class="table table-striped table-bordered table-sm table-hover">
                <tr align="center" class="table table-success">
                    <td>Nome</td>
		            <td>Login</td>
		            <td>Prioridade</td>
                </tr>
	            <?php
	                $offset = ($varPag-1)*15;
                    $usuarios=pesquisaUsuario($_COOKIE['cookie_chave'], $offset);
		            foreach($usuarios as $usuario){
	            ?>
	            <tr align="center">
		            <td><?= $usuario['nome'] ?></td>
		            <td><?= $usuario['login'] ?></td>
		            <td><?= $usuario['prioridade']?></td>
		            </td>
	            </tr>
	            <?php } ?> 	
            </table>  
            <form action="lista-pesquisa.php" method="post">
            <nav aria-label="..." align="center">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="lista-pesquisa.php?pagina=1">Inicio</a>
                </li>
                <?php for($i = -2 ; $i <= 2 ;$i++ ){                
                $counter=$varPag+$i;
                if ($counter <= 0){
                    $counter='*';             
                }?>        
                <li class="page-item"><a class="page-link" href="lista-pesquisa.php?pagina=<?php echo $counter?>"><?php  echo $counter ?></a>
                </li><?php }?>
                <li class="page-item">
                  <a class="page-link" href="lista-pesquisa.php?pagina=<?php echo $counter-1?>">Próximo</a>
                </li>
              </ul>
            </nav>
        </div>
    </div>
</div>

    
<?php include("rodape.php"); ?>			

