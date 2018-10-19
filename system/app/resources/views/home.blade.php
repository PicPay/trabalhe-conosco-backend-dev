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
                                <td>{{ $client->relevance }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <p>
                        {{ $clients->appends(request()->input())->links() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
