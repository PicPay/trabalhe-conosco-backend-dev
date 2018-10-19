@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-md-6">Dashboard</div>
                        <div class="col col-md-6">
                            <form>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $search }}" name="search" placeholder="Busca" aria-label="Busca" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Buscar</button>
                                    </div>
                                </div>
                            </form>
                            @if($search != '')
                                <p align="right"><a href="/home">Limpar busca</a></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($paginator['currentPage'] == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $paginator['url'].($paginator['currentPage']-1) }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="{{ $paginator['url'].($paginator['currentPage']) }}">{{$paginator['currentPage']}}</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $paginator['url'].($paginator['currentPage']+1) }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </p>
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th></th>
                        </tr>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->ident }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->user }}</td>
                                <td>
                                    @if($client->relevance == 2)
                                        <span style="color: #FFFFFF;" class="badge badge-success">1º Nível</span>
                                    @elseif($client->relevance == 1)
                                        <span style="color: #FFFFFF;" class="badge badge-primary">2º Nível</span>
                                    @else
                                        <span style="color: #FFFFFF;" class="badge badge-info">3º Nível</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <p>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($paginator['currentPage'] == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $paginator['url'].($paginator['currentPage']-1) }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="{{ $paginator['url'].($paginator['currentPage']) }}">{{$paginator['currentPage']}}</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $paginator['url'].($paginator['currentPage']+1) }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
