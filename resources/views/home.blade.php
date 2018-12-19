@extends('layouts.app')

@section('content')

<div class="container-fluid">
<!-- Basic Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    FORMULÁRIO DE PESQUISA
                    <small>Busque pelo nome ou login no campo abaixo</small>
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="formBusca" name="formBusca" method="GET" action="pesquisar">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="query" value="{{ $query }}" required class="form-control">
                                            <label class="form-label">Digite o termo para a consulta...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <button type="submit" id="btEnviar" class="btn btn-block bg-light-green btn-lg m-l-15 waves-effect">PESQUISAR</button>
                                </div>
                            <input type="hidden" name="page" value="{{ $page }}">
                            <input type="hidden" name="m" value="0">
                        </form>
                    </div>
                    <div class="col-lg-12 text-center" id="loading" style="display: none">
                        <div class="preloader">
                            <div class="spinner-layer pl-green">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    @if(isset($result['total']))
                        @if($result['total'] > 0)
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed">
                                    <caption>
                                        <h4>Resultado da busca para: {{ $query }}</h4>            
                                        <small>Quantidade de registros encontrados: {{ $result['total'] }} </small>
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th>NOME</th>
                                            <th>LOGIN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($result['result'] as $r)
                                        <tr>
                                            <td>{{ utf8_encode($r['name']) }}</td>
                                            <td>{{ utf8_decode($r['login']) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 text-center">
                                <nav aria-label="Page navigation">
                                  <ul class="pagination">
                                      <li>
                                          <a href="pesquisar?query={{ $query }}&page=1&m=1" aria-label="Anterior">
                                        Primeira
                                      </a>
                                      </li>
                                      <li>
                                      @if($page != 1)
                                      <a href="pesquisar?query={{ $query }}&page={{ $page-1 }}&m=1" aria-label="Anterior">
                                        <span aria-hidden="true">&laquo;</span>
                                      </a>
                                      @endif
                                        </li>
                                      @php
                                      $page_ = $page;
                                      @endphp
                                      @for($i = 0; $i < 5; $i++)
                                        @if($page_ < $totalPaginas)
                                        <li @if($page_ == $page) class="active" @endif ><a href="pesquisar?query={{ $query }}&page={{ $page_ }}&m=1">{{ $page_++ }}</a></li>
                                        @endif
                                      @endfor

                                        <li>
                                      @if(($page+1) < $totalPaginas)
                                      <a href="pesquisar?query={{ $query }}&page={{ $page+1 }}&m=1" aria-label="Próximo">
                                        <span aria-hidden="true">&raquo;</span>
                                      </a>
                                      @endif
                                    </li>
                                    <li>
                                          <a href="pesquisar?query={{ $query }}&page={{ $totalPaginas-1 }}&m=1" aria-label="Anterior">
                                        Última
                                      </a>
                                  </ul>
                                </nav>

                            </div>
                        </div>
                        @else
                            @if($query != '')
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p><strong>Nenhum resultado encontrado para:</strong> {{ $query }}</p>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</div>
   
@endsection

@section('scripts')

<script type="text/javascript">
    $(function(){
        $("#formBusca").on('submit',function(e){
            e.preventDefault();
            $("#btEnviar").prop("disabled",true);
            $("#loading").show();
            document.formBusca.submit();
        })
    })
</script>

@endsection