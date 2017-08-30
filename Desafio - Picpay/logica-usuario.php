<?php

// Funções que dizem respeito ao usuário

session_start();

function usuarioEstaLogado() {
	return isset($_SESSION["usuario_logado"]);
}

function verificaUsuario() {
  if(!usuarioEstaLogado()) {
  	$_SESSION["danger"] = "É preciso estar logado para acessar essa funcionalidade.";
 	header("Location: index.php");
 	die();
  }
}

function usuarioLogado() {
	return $_SESSION["usuario_logado"];
}

function logaUsuario($email) {
	$_SESSION["usuario_logado"] = $email;
}

function logout() {
	session_destroy();
	session_start();
}
