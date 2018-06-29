<?php
#versão antiga do controle de sessão
#if (!isset($_SESSION['log'])) redirect('login/sair');

#tempo de sessão = 5 horas
$tempo = 18000;
#$tempo = 5;

#controle de sessão
if ( (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempo)) || !isset($_SESSION['log'])) {
    redirect('login/sair/FALSE');
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="<?php echo $tempo+1; ?>;<?php echo base_url(); ?>login/sair/FALSE"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title><?php echo mb_strtoupper($_SESSION['log']['modulo']); ?></title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/bootstrap4/dist/css/bootstrap.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/temas/sb-admin/css/sb-admin.css">

        <!-- Custom Fonts -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/font-awesome/css/font-awesome.min.css" type="text/css">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/chosen-bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/chosen.min.new.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/bootstrap4/docs/4.0/examples/offcanvas/offcanvas.css">

        <!-- HUAP CSS Custom -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/app.css">

        <!-- CSS para impressão -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/app-print.css" media="print" />

        <!--
        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/bootstrap-select/dist/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/tempusdominus-bootstrap-4.min.css">
        -->

    </head>

    <body>
