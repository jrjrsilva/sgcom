@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Inteligência</h1>
    <ol class="breadcrumb">
        <li><a href="">Inteligência</a></li>
        <li><a href="{{route('inteligencia.criminosos')}}">criminosos</a></li>
    </ol>
@stop

@section('content')   
    <div class="box">
    <section class="content">
 <!--FORMULÁRIO -->                            
    <form role="form" method="POST" action="{{ route('inteligencia.crim.salvar')}}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $criminoso->id or '' }}">
<!-- Criminoso -->
<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Criminoso</h3>
        
        </div><br>
        <div class="row">
              <div class="col-md-3 col-12">
                   <label>Foto</label>
                   @if($criminoso->foto != null)
                   <img src="{{ url($criminoso->foto) }}" alt="{{ $criminoso->nome }}"
                   height="200" width="150" >                 
                  @else
                  <img src="{{url("fotos/sem_foto.jpg")}}" height="200" width="150">
                  @endif
                
              </div> 
              <br>
              <div class="col-md-6 col-12">
                <label>Nome*</label>
                <input type="text" class="form-control" placeholder="Nome"  readonly
                value="{{  $criminoso->nome or '' }}" id="nome" name="nome">
              </div> 
        </div>
        <br>
          <div class="row">
            <div class="col-md-2 col-12">
                <label>Apelido</label>
             <input type="text" class="form-control" placeholder="Apelido" readonly
             value="{{  $criminoso->apelido or '' }}" id="apelido" name="apelido">
           </div> 

           <div class="col-md-2">
            <label>RG</label>
         <input type="text" class="form-control" placeholder="rg" readonly
         value="{{  $criminoso->rg or '' }}" id="rg" name="rg">
        </div> 

        <div class="col-md-2">
            <label>CPF</label>
         <input type="cpf" class="form-control" placeholder="CPF" readonly
         value="{{  $criminoso->cpf or '' }}" id="cpf" name="cpf">
       </div> 
        <div class="col-md-2">
                   <label>Facção*</label>
              <input type="text" class="form-control" id="faccao" name="faccao" required readonly
                   value="{{ $criminoso->faccao->nome or ''}}"> 
              </div>

         
              <div class="col-md-2">
                <label>Posição*</label>
           <input type="text" class="form-control" id="posicao" name="posicao" required readonly
            value="{{ $criminoso->posicaofaccao->nome or '' }}">
           </div>
            
              </div>
              <br>
              <div class="row">
           <div class="col-md-6">
            <label>Área de atuação*</label>
             <textarea class="form-control" placeholder="area de atuacao" rows="2" readonly
             id="area_atuacao" name="area_atuacao">{{  $criminoso->area_atuacao or ''  }}</textarea>                        
         </div>
              
         <div class="col-md-2">
          <label>Tipo de Atuação</label>
     <input type="text" class="form-control" id="tipoatuacao" name="tipoatuacao" readonly
            value="{{$criminoso->tipoatuacao->nome or ''}}">
     </div>


     <div class="col-md-2">
       <label>Modus Operandi</label>
  <input type="text" class="form-control" id="modusoperandi" name="modusoperandi"  readonly
    value="{{$criminoso->modusoperandi->nome or ''}}">
  </div>
   

        </div> 

              <br>
              <div class="row">
                <div class="col-md-3">
                  <label>AISP*</label>
             <input type="text" class="form-control" id="aisp" name="aisp" required readonly
              value="{{ $criminoso->aisp->descricao }}">
             </div>
             <div class="col-md-2">
              <label>Baralho?</label>
         <input type="text" class="form-control" id="barralho" name="barralho" readonly
             value="{{$criminoso->barralho_crime}}"
             >
         </div>
              </div>
              <br>
        <div class="row">
        <div class="col-md-6">
                   <label>Endereço</label>
                    <input type="text" class="form-control" placeholder="Endereço" readonly
                    value="{{  $criminoso->endereco or ''  }}" id="endereco" name="endereco">                        
                </div>

                <div class="col-md-3">
                     <label>Bairro</label>
                    <input type="text" class="form-control" placeholder="Bairro" readonly
                    value="{{  $criminoso->bairro or '' }}"id="bairro" name="bairro">
                </div>
        </div> 
        <br>
        <div class="row">
            <div class="col-md-2">
                <label>Naturalidade</label>
                <input type="text" class="form-control" placeholder="Naturalidade" readonly
                value="{{  $criminoso->naturalidade or ''  }}" id="naturalidade" name="naturalidade">                        
        
           </div>
           <div class="col-md-2">
            <label>Sexo*</label>
       <input type="text" class="form-control" id="sexo" name="sexo" required readonly
           value="{{$criminoso->sexo or ''}}">
       </div>
      </div>
      <br>
        <div class="row">
           <div class="col-md-6">
                <label>Nome da Mãe</label>
             <input type="text" class="form-control" placeholder="Nome da Mãe" readonly
             value="{{  $criminoso->nome_mae or '' }}" id="nome_mae" name="nome_mae">
           </div>
           
           <div class="col-md-2">
            <label>Data de Nascimento</label>
            <input type="date" class="form-control" readonly
             value="{{  $criminoso->data_nascimento or '' }}" id="data_nascimento" name="data_nascimento">
            </div> 
        </div>
 <br>

   <!--FORMULÁRIO -->
    </div>
    </form>
    <div>
      <div class="box-footer">
        <div class="btn-toolbar pull-left">
            Registro Processual
         </div>
      </div>
    </div>


    <div class="table-responsive">

  <table id="tb1" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
          <th>Tipo</th>
          <th>Status</th>
          <th>Enquadramento</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
          @forelse($criminoso->historicosituacaoprocessual as $historico)
          <tr>
            <td>{{ $historico->situacaoprocessual->nome}}</td>
            <td>{{ $historico->statusprocessual->nome}}</td>
            <td>{{ $historico->enquadramento}}</td>
            <td>
          </td>
          </tr>
          @empty
          @endforelse 
       </tbody>
       
      </table>
    
    </div>
   
    <!-- /.box-body -->
  </div>

<!--galeria de fotos -->
  <main role="main"  style="<?php 
  if(!isset($criminoso->id)){ 
     echo 'display: none;'; }?>">
 <header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
     
        <strong>Album de fotos</strong>
      
  </div>
</header>
   <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          @foreach ($criminoso->galeriacriminoso as $galeria)
              <div class="col-md-4">
                <div  class="card mb-4 shadow-sm">
                  <img class="card-img-top figure-img img-fluid rounded " src="{{ url($galeria->foto) }}" width="100" height="100">
                  <div class="card-body">
                    
                    <div class="d-flex justify-content-between align-items-center ">
                      <div class="btn-group">
                        <p class="card-text">{{$galeria->descricao}}
                       <a type="button" class="btn btn-sm btn-secondary" href="{{route('inteligencia.album.download',$galeria->id)}}"><i class="fa fa-download fa-2x"></i></a>
                       </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
        </div>
       
      </div>
    </div>

  </main>

  <!-- Fim Galeria de fotos-->
  <!-- Inicio Documentos-->
  <main role="main"  style="<?php 
  if(!isset($criminoso->id)){ 
     echo 'display: none;'; }?>">
 <header>
  <div class="navbar navbar-dark bg-dark shadow-sm">
     
        <strong>Documentos</strong>
      
  </div>
</header>
   <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          @foreach ($criminoso->documentoscriminoso as $documento)
              <div class="col-md-4">
                <div  class="card mb-4 shadow-sm">
                   <div class="card-body">
                   
                    <div class="d-flex justify-content-between align-items-center ">
                      <div class="btn-group">
                        <p class="card-text">{{$documento->descricao}}
                        <a type="button" class="btn btn-sm btn-secondary" href="{{route('inteligencia.doc.download',$documento->id)}}"><i class="fa fa-download fa-2x"></i></a>
                      </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
        </div>
       
      </div>
    </div>

  </main>
  <!--Fim documentos -->
    <div class="clearfix"></div>
              </div>
          </div>
      </div>
  </div>
 </section>

@stop

@section('js')
<script src="{{ asset('js/jquery.mask.js') }}"></script>

<script>
 $(document).ready(function($){
    $('#cpf').mask("999.999.999-99");
 });

 $('#Modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
   var modal = $(this)
 
});


$('#situacao_processual').change(function () {
        var situacao_processual = $(this).val();
        $.get('/inteligencia/crim_status_processual/'+situacao_processual, function (status) {
            $('select[name=status_processual]').empty();
            $.each(status, function (key, value) {
                $('select[name=status_processual]').append('<option value=' + value.id + '>' + value.nome + '</option>');
            });
        });
    });

 function confirmExcluirHistorico() {
  if(!confirm("Confirma exclusão deste lançamento?"))
  event.preventDefault();
}

 </script> 
@stop
@section('css')
<style>
.table-striped > tbody > tr{
  background-color: #ccc;
}
.table-hover > tbody > tr:hover{
  background-color: #333;
  color: #fff;
}
  body { padding: 20px; }
       .navbar { margin-bottom: 20px; }
       :root { --jumbotron-padding-y: 10px; }
       .jumbotron {
         padding-top: var(--jumbotron-padding-y);
         padding-bottom: var(--jumbotron-padding-y);
         margin-bottom: 10;
         background-color: #fff;
       }
       @media (min-width: 768px) {
         .jumbotron {
           padding-top: calc(var(--jumbotron-padding-y) * 2);
           padding-bottom: calc(var(--jumbotron-padding-y) * 2);
         }
       }
       .jumbotron p:last-child { margin-bottom: 10; }
       .jumbotron-heading { font-weight: 300; }
       .jumbotron .container { max-width: 40rem; }
       .btn-card { margin: 4px; }
       .btn { margin-right: 5px; }
       footer { padding-top: 3rem; padding-bottom: 3rem; }
       footer p { margin-bottom: .25rem; }
   </style>
@endsection