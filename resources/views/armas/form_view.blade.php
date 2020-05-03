@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Armas</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('armas.lista')}}">Gestão de Armas</a></li>
        <li><a href="{{route('armas.edit.historico',$arma->id)}}">Adicionar Histórico</a></li>
    </ol>
@stop

@section('content')

    <h2>Cadastro</h2>
    @include('site.includes.alerts')
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('armas.salvar')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $arma->id or '' }}">
 <!--DADOS -->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <div class="row">
              <div class="col-xs-4"> 
                <label>Nº de Série</label>
                <p> 
                  {{$arma->numero_de_serie}}
                </p>
              </div> 

              <div class="col-xs-4">
                <label>Calibre</label>
              <p>{{$arma->calibre->nome}}</p>  
              </div>

              <div class="col-xs-4">
                <label>Especie:</label>
               <p>{{$arma->especiearma->nome}}</p>
        </div>
        </div> 

    <div class="row">
      <div class="col-xs-4"> 
        <label for="opm">OPM:</label>
       <p> {{ $arma->opm->opm_sigla }} </p>
      </div>
    <div class="col-xs-4">     
          <label>Situação:</label>
         <p> {{ $arma->situacaoarma->nome }} </p>
</div>
    </div>
      </div>
   <table id="tb3" class="table table-bordered table-striped">
       <caption>Histórico da Arma</caption>
      <thead>
      <tr>
        <th width="20%">Data</th>
        <th width="20%">Tipo</th>
        <th>Lançamento</th>        
      </tr>
      </thead>
      <tbody>
        @forelse($historicos as $historico)
        <tr>
          <td>{{\Carbon\Carbon::parse($historico->data)->format('d/m/Y')}}</td>
          <td>{{ $historico->nome}}</td>
          <td>{{ $historico->observacao}}</td>
        </tr>      
        @empty
        Sem lançamentos
        @endforelse 
     </tbody>
    </table>
  </div></form>
    </section>
@stop

@section('js')
<script>
 $(document).ready(function(){
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});

@stop