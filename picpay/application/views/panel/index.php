<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>picpay</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/vendor/font-awesome/css/font-awesome.min.css">
    <!-- DataTables Plugin CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/vendor/datatables/css/dataTables.bootstrap4.css">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/sb-admin.css">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <!-- Brand -->
        <a class="navbar-brand" href="<?php echo base_url('panel'); ?>">PicPay Test</a>

        <!-- Navbar Toggler -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <!-- Sidebar -->
            <ul class="navbar-nav navbar-sidenav" id="sidebarAccordion">
                <!-- Sidebar button -->
                <li class="sidebar-button" data-toggle="tooltip" data-placement="right" title="Abrir Chamado">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fa fa-plus"></i>
                        <span class="nav-link-text">Novo Usuário</span>
                    </a>
                </li>

                <!-- Sidebar links -->
                <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Home">
                    <a href="<?php echo base_url('panel'); ?>" class="nav-link">
                        <i class="fa fa-fw fa-home"></i>
                        <span class="nav-link-text">Usuários</span>
                    </a>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Relatórios">
                    <a href="#" class="nav-link">
                        <i class="fa fa-fw fa-area-chart"></i>
                        <span class="nav-link-text">Relatórios</span>
                    </a>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Cadastros">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents"
                        data-parent="#sidebarAccordion">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="nav-link-text">Cadastros</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseComponents">
                        <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 2</a></li>
                    </ul>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Configurações">
                    <a href="#" class="nav-link">
                        <i class="fa fa-fw fa-gears"></i>
                        <span class="nav-link-text">Configurações</span>
                    </a>
                </li>
            </ul>

            <!-- Sidebar Toggler -->
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>

            <!-- Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span><?php echo $this->session->userdata('user_name'); ?></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
                        <i class="fa fa-fw fa-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
            </ol>

            <!-- DataTables Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-users"></i> Usuários PicPay
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0" data-url="http://localhost/picpay/api/customers">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Apelido</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card-footer small text-muted">
                    Powered by DataTables
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright &copy; <a href="https://twitter.com/joaopauloasouza" target="_blank">@joaopauloasouza</a>
                    2018</small>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Pronto para Partir?</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Selecione "Logout" abaixo se você estiver pronto para terminar sua sessão atual.
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="<?php echo base_url('contas/sair'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/vendor/popper/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>public/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>public/vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>public/vendor/datatables/js/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for this template -->
    <script src="<?php echo base_url(); ?>public/js/sb-admin.js"></script>
    <script src="<?php echo base_url(); ?>public/js/dataTables.js"></script>
</body>
</html>