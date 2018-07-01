<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="col-md-1"></div>
    <div class="col-md-10">

        <?php echo validation_errors(); ?>

        <div class="card">
            <div class="card-header bg-secondary text-light"><b><?php echo $titulo; ?></b></div>
            <div class="card-body">

                <h6 class="card-title">Informe <b>Nome ou Usuário:</b></h6>

                <?php echo form_open('usuario/pesquisar', 'role="form"'); ?>
                    <div class="container">
                        <div class="row">

                            <div class="input-group">
                                <input type="text" id="inputText" class="form-control"
                                    autofocus name="Pesquisa" value="<?php echo set_value('Pesquisa', $Pesquisa); ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-info" name="pesquisar" value="0" type="submit">Pesquisar</button>
                                </span>
                            </div>

                        </div>
                    </div>
                </form>

                <?php if (isset($lista)) echo $lista; ?>
            </div>
        </div>

    </div>
    <div class="col-md-auto"></div>

</div>
