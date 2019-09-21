@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Armas</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('armas.lista')}}">Gestão de Armas</a></li>
        <li><a href="">Cadastro</a></li>
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
        <select class="form-control" id="opm" name="opm" required >
          <option value="">Selecione a OPM</option>
          @foreach( $opms as $opm )
          <option value="{{ $opm->id or ''}}" 
            @isset($arma->opm->id)
              @if($arma->opm->id == $opm->id)
                selected 
              @endif 
            @endisset ><p> {{ $opm->opm_sigla }} </p></option>
          @endforeach
        </select>
      </div>
    <div class="col-xs-4">     
          <label>Situação:</label>
          <select class="form-control" id="opm" name="opm" required >
            <option value="">Selecione a Situacao</option>
            @foreach( $situacaoarmas as $situacaoarma )
            <option value="{{ $situacaoarma->id or ''}}" 
              @isset($arma->situacaoarma->id)
                @if($arma->situacaoarma->id == $situacaoarma->id)
                  selected 
                @endif 
              @endisset ><p> {{ $situacaoarma->nome }} </p></option>
            @endforeach
          </select>
</div>

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