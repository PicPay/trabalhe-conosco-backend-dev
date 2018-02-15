<div id="header">
  <style>
  #header {
      border-top:7px solid #fff;
      margin:0 auto;
      background: #eee;
      height: 170px;
      font: 12px arial, sans-serif;
  }

  #header h1 {
      margin-left: 30px;
      float: left;
      width: 287px;
      height: 140px;
      background: url(https://mueros.net/upload/imagens/00fb6afc8b.png) no-repeat 0 0;
      text-indent: -9999px;
  }
  </style>
  <h1>Logoff realizado com sucesso</h1>
  <head>


<?php
session_start();
$_SESSION['logged_in'] = false;
  echo "<a class=\"submit\" href=\"http://desafio.picpay/api/busca\" target=\"_self\"><button type=\"button\">Retornar a pagina principal</button></a>";
?>
