<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GetUser</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- styles-->
        <link type="text/css" rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{asset('/css/dataTables.bootstrap.min.css')}}"/>
        <style type="text/css">
            @font-face {
                font-family: 'Glyphicons Halflings';
                src: url("{{asset('/assets/fonts/glyphicons-halflings-regular.eot')}}");
                src: url("{{asset('/assets/fonts/glyphicons-halflings-regular.eot?#iefix')}}") format('embedded-opentype'),
                url("{{asset('/assets/fonts/glyphicons-halflings-regular.woff')}}") format('woff'),
                url("{{asset('/assets/fonts/glyphicons-halflings-regular.ttf')}}") format('truetype'),
                url("{{asset('/assets/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular')}}") format('svg');
        }
        </style>
        <!--end styles-->

    </head>
    <body class="container">
        @if($errors->any())
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-group row"></div>
                            <div class="form-group row">
                                <h4>{{$errors->first()}}</h4>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        @endif
            <div class="row">
                <div class="col-sm-4">
                    <form id="form" class="form-horizontal" method="POST" role="form" action="/search">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="form-group row"></div>
                            <div class="form-group row">
                            <label for="keyword">Usuário</label>
                                <input id="keyword" type="keyword" class="form-control" name="keyword" value="{!! \Session::get('keyword') !!}" required autofocus>
                            </div>
                            <div class="form-group row">
                                <input type="submit" class="btn-primary btn" value="Buscar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    @if((Count(\Session::get('users')) == 0) || (\Session::get('users') == null))
                        Nenhum registro encontrado
                    @else
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\Session::get('users') as $user)
                                @if(isset($user))
                                    <tr>
                                        <td>{{ isset($user->id) == true ? $user->id : '-'}}</td>
                                        <td>{{ isset($user->name) == true ? $user->name : '-'}}</td>
                                        <td>{{ isset($user->user_name) == true ? $user->user_name : '-'}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Username</th>
                            </tr>
                        </tfoot>
                    </table>
                    @endif
                </div>
            </div>

        <!--plugin scripts-->
        <script type="text/javascript" src="{{asset('/js/jquery-1.12.4.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/dataTables.bootstrap.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable({
                        "lengthMenu": [15,30,45,60],
                        "language": {
                            "lengthMenu": "Mostrando _MENU_ registros por página",
                            "zeroRecords": "Nenhum registro encontrado",
                            "info": "Mostrando página _PAGE_ de _PAGES_",
                            "infoEmpty": "Nenhum registro encontrado",
                            "infoFiltered": "(filtrado de _MAX_ registros totais)",
                            "search": "Buscar:",
                            "paginate": {
                                "first": "Primeiro",
                                "last": "Último",
                                "previous": "Anterior",
                                "next": "Próximo"
                            },
                            "aria": {
                                "sortAscending":  ": ativar para classificar coluna ascendente",
                                "sortDescending": ": ativar para classificar coluna descendente"
                            }
                        }
                    });
            });
        </script>
    </body>
</html>