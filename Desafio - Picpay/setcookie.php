<?php
// Seta o cookie que será utilizado na pesquisa.

	if(!isset($_COOKIE['cookie_chave'])){
       setcookie('cookie_chave',$_POST['busca']);
    }
    header("Location: lista-pesquisa.php?pagina=1");
            
?>
