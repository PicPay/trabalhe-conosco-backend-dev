<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>PicPay Test - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>public/css/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>

            <div class="card-body">
                <?php $error = $this->session->flashdata('error'); ?>
                <div class="alert alert-<?php echo ($error) ? 'danger' : 'primary'; ?>" role="alert">
                    <?php echo ($error) ? $error : 'Entre com suas credenciais'; ?>
                </div>

                <?php echo form_open('contas/entrar', 'role="form"'); ?>
                    <div class="form-group">
                        <label class="sr-only" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
                        <div class="error"><?php echo form_error('email'); ?></div>
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <div class="error"><?php echo form_error('password'); ?></div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <span>Login</span>
                    </button>
                <?php echo form_close(); ?>

                <div class="text-center">
                    <a class="d-block small mt-3" href="">Register an Account</a>
                    <a class="d-block small" href="">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/vendor/popper/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>