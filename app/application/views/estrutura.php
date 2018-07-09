<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>.::Test Picpay::.</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css');?>"  >

    <link rel="stylesheet" href="<?= base_url();?>assets/font-awesome-4.7.0/css/font-awesome.min.css">
    
    <script src="<?= base_url('assets/js/jquery-3.3.1.min.js');?>" ></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js');?>"  ></script>

    <meta charset="utf-8">
  </head>
  <body class="container-fluid">

  <div id="carregando" class="text-center">
    <div id="load"></div>

    <style>
        #carregando{
            width: 100%;
            position: fixed;
            height: 100%;
            background: #eee !important;
            z-index: 99999 !important;
        }
        #load {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 200px;
            height: 200px;
            margin: -75px 0 0 -75px;
            border: 16px solid white;
            border-radius: 50% !important;
            border-top: 16px solid #303030;
            width: 150px;
            height: 150px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</div>
<script>
window.onload = function(){
  $('#carregando').hide();
}
</script>

<?php if(isset(ci()->no_index)):?>
<div class="alert alert-dismissible alert-warning">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Atenção!</h4>
  <p class="mb-0">O banco de dados principal é um banco provisório,
   as consultas atravez dele seram muito lentas,
    execute as instruçoes do link abaixo para criar um banco com indices para melhorar o desempenho do banco.</p>

  <a href="instrucoes" class="alert-link">Criar banco com indeces</a>
</div>

<?php elseif(file_exists(FCPATH.'/db/indices.txt')):?>

<div class="alert alert-dismissible alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h4 class="alert-heading">Tudo ok!</h4>
  <p class="mb-0">Delete a base provisória clicando no link abaixo</p>

  <a href="picpay/remove_tabela_provisoria" class="alert-link">Deletar base provisória</a>
</div>

<?php endif;?>





<nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="margin-bottom:10px;">
  <div class="navbar-brand" id="logo">
    <style>
       #logo {
        min-width: 100px;
        color:#fff;
    }
    </style>

  <svg xmlns="http://www.w3.org/2000/svg" id="svg" viewBox="0 0 129 44"><path class="logo" d="M28 34.3h5.8V17.4H28V34.3zM35.8 5.9h-3.9v3.9h3.9V5.9zM13.9 7.8H8.3v4.9h5.2c3.3 0 5.2 1.6 5.2 4.6 0 3-1.9 4.7-5.2 4.7H8.3v-9.2H2.5v21.5h5.8v-7.4h5.5c6.7 0 10.6-3.6 10.6-9.8C24.4 11.3 20.6 7.8 13.9 7.8zM39.7 2H28v11.7h11.7V2zM37.8 11.7H30V3.9h7.8V11.7zM71.8 7.8h-5.3v4.9h5c3.3 0 5.2 1.6 5.2 4.6 0 3-1.9 4.7-5.2 4.7h-5v-9.2h-5.8v21.5h5.8v-7.4h5.3c6.7 0 10.6-3.6 10.6-9.8C82.4 11.3 78.5 7.8 71.8 7.8zM120.5 14l-5 12.6 -5-12.6h-6l8 20.3 -3.1 7.7h6.1l11-28H120.5zM94.5 13.9c-3.5 0-6.2 0.8-9.2 2.3l1.8 4c2.1-1.2 4.2-1.8 6.1-1.8 2.8 0 4.2 1.2 4.2 3.4v0.4h-5.6c-5 0-7.7 2.3-7.7 6.1 0 3.7 2.6 6.3 7 6.3 2.8 0 4.8-1 6.4-2.7v2.2h5.7l0-13.2C103 16.6 99.9 13.9 94.5 13.9zM97.9 27.5c-0.6 1.7-2.3 3.1-4.7 3.1 -2 0-3.2-1-3.2-2.6 0-1.6 1.1-2.3 3.3-2.3h4.6V27.5zM48.6 29.9c-2.8 0-4.8-2.2-4.8-5.5 0-3.2 2-5.4 4.8-5.4 2 0 3.5 0.8 4.6 2.2l3.9-2.8c-1.8-2.7-4.9-4.3-8.8-4.3C42.2 14 38 18.2 38 24.4c0 6.2 4.2 10.3 10.3 10.3 4.2 0 7.3-1.7 9-4.5l-4-2.7C52.3 29.1 50.7 29.9 48.6 29.9z"></path></svg>

  </div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <?php include_once 'navbar/topo.php';?>
  </div>
</nav>

<?php 

include_once (APPPATH.'views/telas/'.ci()->tela.'.php');

?>


<script>
$(function(){
$('form').submit(function(){
  $('#carregando').show();
});
});
</script>
  </body>
</html>