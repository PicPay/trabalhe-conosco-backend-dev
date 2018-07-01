<?php
#controle de sessão
$tempo = 18000;
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

        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/bootstrap4/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/temas/sb-admin/css/sb-admin.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/font-awesome/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>arquivos/bootstrap4/docs/4.0/examples/offcanvas/offcanvas.css">

    </head>

    <body>
