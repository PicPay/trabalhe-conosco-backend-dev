@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Fazendo o dump da base de Dados</div>

                    <div class="card-body">
                        {!! $html !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection