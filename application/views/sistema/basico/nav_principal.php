<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="<?php echo base_url(); ?>usuario/pesquisar">
            <?php echo mb_strtoupper($_SESSION['log']['modulo']); ?>
        </a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <?php echo form_open(base_url(). 'usuario/pesquisar', 'class="form-inline my-2 my-lg-0 mr-lg-2"'); ?>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Pesquisar" name="Pesquisa" value="">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </li>

            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-warning">
                        <i class="fa fa-fw fa-user-circle-o"></i> <?php echo $_SESSION['log']['usuario']; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>login/sair" class="nav-link text-danger">
                        <i class="fa fa-fw fa-sign-out"></i> Sair
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<br />
