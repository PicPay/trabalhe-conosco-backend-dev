<?php

// Arquivo responsável por mostrar os alertas ao usuário, afim de melhorar a UX.

session_start();
function mostraAlerta($tipo) {
	 if(isset($_SESSION[$tipo])) {
?>
	<div align="center">
	    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
 	        <p class="alert alert-<?= $tipo ?>"><?= $_SESSION[$tipo]?></p>
 	    </div>
 	</div>
<?php
		unset($_SESSION[$tipo]);
	 }
}
