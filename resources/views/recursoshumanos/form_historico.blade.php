@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Pessoal</h1>
    <ol class="breadcrumb">
    <li><a href="{{route('rh.listar')}}">Dashboard</a></li>
        <li><a href="">Efetivo</a></li>
    </ol>
@stop

@section('content')

    <h2>Inserindo Histórico</h2>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('rh.salvarhistorico')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $efetivo->id or '' }}">
 <!--DADOS  DO POLICIAL-->   

      <div class="box box-primary">
        <div class="box-header with-border">
        
          @include('site.includes.alerts')
        </div><br>
        
        <div class="row">
        <div class="form-row">
            <div class="col-xs-2"> 
                <label for="gh">Grau Hierarquico</label>
                   
                    <input type="gh" class="form-control" readonly
              value="{{   $efetivo->grauhierarquico->sigla or '' }}" id="gh" name="gh"> 
            </div> 

              <div class="col-xs-5">
                  <label for="nome">Nome</label>
              <input type="text" class="form-control" placeholder="Nome" readonly
              value="{{  $efetivo->nome or '' }}" id="nome" name="nome"> 
              </div>
        </div>
        <div class="form-row">
            <div class="col-xs-2">
                <label for="matricula">Matrícula</label>
            <input type="number" pattern="[0-9]" maxlength=9 class="form-control" placeholder="Informe a matricula" readonly
            value="{{  $efetivo->matricula or '' }}" id="matricula" name="matricula"> 
            </div>
        </div>
        </div>
        <br>
       <br>

        <div class="row">
            <div class="col-xs-2">
                    <label for="tipo">Tipo de Lançamento:</label>
                    <select class="form form-control" id="tipo" name="tipo" required>
                      <option value="">Selecione </option>
                      @foreach( $tiposhistorico as $tipohistorico )
                      <option value="{{ $tipohistorico->id }}" ><p> {{ $tipohistorico->nome }} </p></option>
                      @endforeach
                    </select>
            </div>
              <div class="col-xs-2">
                <div class="input-group">
                        <label for="data_inicio">Data de Inicio</label>
                      <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                       id="data_inicio" name="data_inicio" 
                       
                       required>
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>  

              </div>

              <div class="col-xs-2">
                <div class="input-group">
                    <label for="data_fim">Data de Termino</label>
                      <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                       id="data_fim" name="data_fim" 
                       required
                       >
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
              </div>         
            <div class="col-xs-5">
                    <label for="obs">Observação</label>
                    <input type="text" class="form-control" placeholder="obs" 
                     id="obs" name="obs" required>  
            </div>
         
        </div> 
        <br>
<div class="row">
   

        </div>
        <!--FORMULÁRIO -->

    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                   <button type="submit" class="btn btn-success btn-lg">Salvar</button>
                 </div>
              </div>
    </form>


    <div class="clearfix"></div>
                    
                  </form>
              </div>
          </div>
      </div>
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

$("#data_inicio").blur(function(){
  var dt_fim = $("#data_inicio").val(); 
  $("#data_fim").val(dt_fim);
});

$("#data_fim").blur(function(){
  var dt_inicio = $("#data_inicio").val();
  var dt_fim = $("#data_fim").val(); 
  if(dt_fim < dt_inicio){
    alert("Data de fim não pode ser menor!");
    $("#data_inico").focus();
  }
});




  </script>
@stop