<div class="container text-center" id="login">

    <?php echo validation_errors(); ?>

    <?php if (isset($msg)) echo $msg; ?>

    <?php echo form_open('login', 'role="form"'); ?>

    <h1><?php echo mb_strtoupper($_SESSION['log']['modulo']); ?></h1>

    <label class="sr-only">Usuário</label>
    <input type="text" id="inputText" class="form-control" placeholder="Usuário" autofocus name="usuario" value="<?php echo set_value('usuario'); ?>">
    <label class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" value="">
    <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">ENTRAR</button>

</form>

</div>
