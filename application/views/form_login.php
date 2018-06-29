<div class="container text-center" id="login">

    <?php echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login', 'role="form"'); ?>

    <h1><?php echo mb_strtoupper($_SESSION['log']['modulo']); ?></h1>

    <!--<br><h1 class="form-signin-heading">EM MANUTENÇÃO</h1>-->


    <?php

    if (1==0) {
    ?>

    <br>
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
        <b>EM MANUTENÇÃO</b>
        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
    </div>

    <?php
    }
    else {
    ?>

    <label class="sr-only">Usuário</label>
    <input type="text" id="inputText" class="form-control" placeholder="Usuário" autofocus name="usuario" value="<?php echo set_value('usuario'); ?>">
    <label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" value="">
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">ENTRAR</button>

    <?php
    }
    ?>


</form>

</div>
