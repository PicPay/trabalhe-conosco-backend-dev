<?php 

// Página responsável por fazer a busca no banco e realizar o login.

require_once ("banco-usuarios.php");
require_once ("logica-usuario.php");
require_once("routes/db.php");


$email = $_POST["email"];
$usuario = buscaAdmin($email, $_POST["senha"]);
if($usuario == null) {
	$_SESSION["danger"] = "Usuário ou senha inválido.";
	header("Location: index.php");
} else {
	$_SESSION["success"] = "Usuário logado com sucesso.";
	logaUsuario($email);
	header("Location: index.php");
}
die();
