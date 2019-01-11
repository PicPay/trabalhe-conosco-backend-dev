@extends('layouts.app')
@section('content')
    <div class="container-fluid" ng-app="picpay">
        <div class="row" ng-controller="usersController">
            <div class="container" ng-init="listar()">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Lista de Usuários</h1>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-inline">
                            <div class="form-group mx-sm-3">
                                <input class="form-control" type="text" placeholder="Buscar pelo nome ou login" ng-model="pesquisar">
                            </div>

                            <button type="button" class="btn btn-info btn-xs" ng-click="buscar(1,null)">Buscar</button>
                        </div>

                    </div>
                    <div class="col-md-6 text-right">
                        @if (Auth::check())
                            <button ype="button" class="btn btn-primary" onclick="jQuery('#userModal').modal('show')">Novo Usuário</button>
                        @endif
                    </div>

                </div>
                <hr>
                <div class="loading">
                    <img src="{{url('img/preloader.gif')}}" alt="Carregando dados" class="img-responsive d-block mx-auto">
                </div>
                <div class="row">
                    <div class="col-12 dados">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="user in users">
                                    <td><%user.id_hash%></td>
                                    <td><%user.nome%></td>
                                    <td><%user.username%></td>
                                    <td>
                                        @if (Auth::check())
                                            <button class="btn btn-info btn-xs" ng-click="editar(user)">Editar</button>
                                            <button class="btn btn-danger btn-xs" ng-click="excluir(user)">Excluir</button>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <ul id="paginacao" role="navigation" class="pagination justify-content-center">

                        </ul>
                        <p id="totalPage"></p>
                        <p id="totalItens"></p>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userModalLabel">Usuário</h5>
                                <button type="button" id="close-modal" class="close" data-dismiss="modal" aria-label="Close" ng-click="user = {}">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nome:</label>
                                        <input type="text" class="form-control" required ng-model="user.nome">
                                    </div>
                                    <div class="form-group">
                                        <label>Login:</label>
                                        <input type="text" class="form-control" required ng-model="user.username">
                                    </div>
                                    <div class="form-group">
                                        <label>Relevância:</label>
                                        <select type="text" class="form-control" ng-model="user.relevancia">
                                            <option ng-value="1">1</option>
                                            <option ng-value="2">2</option>
                                        </select>
                                        <%user.relevancia%>
                                    </div>
                                    <input type="hidden" ng-model="user.id_hash">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="user = {}">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" ng-click="salvar()">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
