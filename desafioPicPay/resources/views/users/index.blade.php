@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
    Usuários
    @parent
@stop
{{-- page level styles --}}
@section('header_styles')
    <!--Plugin styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/select2/css/select2.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/datatables/css/scroller.bootstrap.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/datatables/css/colReorder.bootstrap.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/datatables/css/dataTables.bootstrap.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/pages/dataTables.bootstrap.css')}}" />
    <!-- end of plugin styles -->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/pages/tables.css')}}" />
    <!--End of page level styles-->
    <!--  end of global styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/Buttons/css/buttons.min.css')}}"/>
    <!--End of global styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/pages/buttons.css')}}"/>
    <!--End of page level styles-->
@stop
@section('content')

    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-lg-6 col-md-4 col-sm-4">
                    <h4 class="nav_top_align">
                        <i class="fa fa-th"></i>
                        Usuarios
                    </h4>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-8">
                    <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                        <li class="breadcrumb-item">
                            <a href="/">
                                <i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row">
                <div class="col-12 data_tables">
                    <div class="card">
                        <div class="card-header bg-white">
                            <i class="fa fa-table"></i> Usuarios Cadastrados
                        </div>
                        @if(Session::has('success_message'))
                            <div class="control-group">
                                <div class="controls span6">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <div class="alert alert-success" role="alert">
                                        {!! Session::get('success_message') !!}
                                    </div>
                                </div>
                            </div>
                        @elseif(Session::has('error_message'))
                            <div class="control-group">
                                <div class="controls span6">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <div class="alert alert-danger" role="alert">
                                        {!! Session::get('error_message') !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-5 col-12 button_align_top_button_wrap">
                            <span class="button-wrap">
                                <a href="/users/create" class="button button-pill button-primary">Novo Usuário</a>
                            </span>
                        </div>
                        <div class="card-body m-t-35">
                            <div class="row justify-content-end">
                                <div class="col-12 col-md-10 col-lg-4">
                                    <form method="get" action="{{$users['path']}}">
                                        <div class="card-body row no-gutters align-items-center">
                                            {{--<div class="col-auto">--}}
                                                {{--<i class="fas fa-search h4 text-body"></i>--}}
                                            {{--</div>--}}
                                            <!--end of col-->
                                            <div class="col">
                                                <input class="form-control form-control-lg form-control-borderless" name="search" type="search" placeholder="buscar">
                                            </div>
                                            <!--end of col-->
                                            <div class="col-auto">
                                                <button class="btn btn-lg btn-success" type="submit">Pesquisar</button>
                                            </div>
                                            <!--end of col-->
                                        </div>
                                    </form>
                                </div>
                                <!--end of col-->
                            </div>
                            <table class="display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>UserName</th>
                                    <th>email</th>
                                    <th>Data cadastro</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users['data'] as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->nome}}</td>
                                        <td>{{ $user->username}}</td>
                                        <td>{{ $user->email}}</td>
                                        <td>{{ $user->created_at}}</td>
                                        <td><div class="col-xl-4 col-lg-12 col-sm-4">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-4 col-sm-2 col-6">
                                                        <div class="btn-group">
                                                            <a href="/users/{{ $user->id_auto }}/edit" class="btn btn-mint" title="Alterar">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tfoot>
                            </table>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item">
                                        <a id="previous" class="page-link" href="javascript:history.back()" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">{{ $users['current_page_number'] }}</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users['next_page_url'] }}">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.inner -->
    </div>
    <!-- /.outer -->
@stop
@section('footer_scripts')
    <!--plugin scripts-->
    <script type="text/javascript" src="{{asset('assets/vendors/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/jquery.dataTables.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/pluginjs/dataTables.tableTools.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/dataTables.colReorder.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/dataTables.bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/dataTables.responsive.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/dataTables.rowReorder.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/buttons.colVis.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendors/datatables/js/dataTables.scroller.min.js')}}"></script>
    <!-- end of plugin scripts -->
    <!--Page level scripts-->
    <script type="text/javascript" src="{{asset('assets/js/pages/simple_datatables.js')}}"></script>
    <!-- end of global scripts-->
    <script>
        $(document).ready(function() {
            var url = location.href;
            if(url.indexOf("page") == -1) {
                $(".page-item").first().addClass( "disabled" );
            } else {
                if(url.indexOf("page=0") != -1) {
                    $(".page-item").first().addClass( "disabled" );
                } else {
                    $(".page-item").first().removeClass( "disabled" );
                }
            }
        });
    </script>
@stop
