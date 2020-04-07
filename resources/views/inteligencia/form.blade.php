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
          @include('site.includes.alerts')
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
                  <input type="file" class="custom-file-input" id="arquivo" name="foto" >
              </div> 
              <br>
              <div class="col-md-6 col-12">
                <label>Nome*</label>
                <input type="text" class="form-control" placeholder="Nome" 
                value="{{  $criminoso->nome or '' }}" id="nome" name="nome">
              </div> 
        </div>
        <br>
          <div class="row">
            <div class="col-md-2 col-12">
                <label>Apelido</label>
             <input type="text" class="form-control" placeholder="Apelido" 
             value="{{  $criminoso->apelido or '' }}" id="apelido" name="apelido">
           </div> 

           <div class="col-md-2">
            <label>RG</label>
         <input type="text" class="form-control" placeholder="rg" 
         value="{{  $criminoso->rg or '' }}" id="rg" name="rg">
        </div> 

        <div class="col-md-2">
            <label>CPF</label>
         <input type="cpf" class="form-control" placeholder="CPF" 
         value="{{  $criminoso->cpf or '' }}" id="cpf" name="cpf">
       </div> 
        <div class="col-md-2">
                   <label>Facção*</label>
              <select class="form-control" id="faccao" name="faccao" required>
                  <option value="">Selecione</option>
                 @foreach( $faccoes as $faccao )
                  <option value="{{ $faccao->id or '' }}" 
                      @isset($criminoso->faccao->id)
                      @if($criminoso->faccao->id == $faccao->id)
                      selected 
                    @endif 
                  @endisset
                    ><p> {{ $faccao->nome }} </p></option>
                  @endforeach
                </select>
              </div>

         
              <div class="col-md-2">
                <label>Posição*</label>
           <select class="form-control" id="posicao" name="posicao" required>
               <option value="">Selecione a Posição</option>
               @foreach( $posicoes as $posicao )
               <option value="{{ $posicao->id or '' }}" 
                   @isset($criminoso->posicaofaccao->id)
                   @if($criminoso->posicaofaccao->id == $posicao->id)
                   selected 
                 @endif 
               @endisset
                 ><p> {{ $posicao->nome }} </p></option>
               @endforeach
             </select>
           </div>
            
              </div>
              <br>
              <div class="row">
           <div class="col-md-6">
            <label>Área de atuação*</label>
             <textarea class="form-control" placeholder="area de atuacao" rows="2"
             id="area_atuacao" name="area_atuacao">{{  $criminoso->area_atuacao or ''  }}</textarea>                        
         </div>
              
         <div class="col-md-2">
          <label>Tipo de Atuação</label>
     <select class="form-control" id="tipoatuacao" name="tipoatuacao" >
         <option value="">Selecione</option>
        @foreach( $tipoatuacoes as $tipoatuacao )
         <option value="{{ $tipoatuacao->id or '' }}" 
             @isset($criminoso->tipoatuacao->id)
             @if($criminoso->tipoatuacao->id == $tipoatuacao->id)
             selected 
           @endif 
         @endisset
           ><p> {{ $tipoatuacao->nome }} </p></option>
         @endforeach
       </select>
     </div>


     <div class="col-md-2">
       <label>Modus Operandi</label>
  <select class="form-control" id="modusoperandi" name="modusoperandi" >
      <option value="">Selecione</option>
      @foreach( $modusoperandis as $modusoperandi )
      <option value="{{ $modusoperandi->id or '' }}" 
          @isset($criminoso->modusoperandi->id)
          @if($criminoso->modusoperandi->id == $modusoperandi->id)
          selected 
        @endif 
      @endisset
        ><p> {{ $modusoperandi->nome }} </p></option>
      @endforeach
    </select>
  </div>
   

        </div> 

              <br>
              <div class="row">
                <div class="col-md-3">
                  <label>AISP*</label>
             <select class="form-control" id="aisp" name="aisp" required>
                 <option value="">Selecione a AISP</option>
                 @foreach( $aisps as $aisp )
                 <option value="{{ $aisp->id or '' }}" 
                     @isset($criminoso->aisp->id)
                     @if($criminoso->aisp->id == $aisp->id)
                     selected 
                   @endif 
                 @endisset
                   ><p> {{ $aisp->descricao }} </p></option>
                 @endforeach
               </select>
             </div>
             <div class="col-md-2">
              <label>Barralho?</label>
         <select class="form-control" id="barralho" name="barralho">
             <option value="Não"  @if($criminoso->barralho_crime == 'Não')
              selected 
            @endif >Não</option>
             <option value="Sim"  @if($criminoso->barralho_crime == 'Sim')
              selected 
            @endif >Sim</option>
           </select>
         </div>
              </div>
              <br>
        <div class="row">
        <div class="col-md-6">
                   <label>Endereço</label>
                    <input type="text" class="form-control" placeholder="Endereço" 
                    value="{{  $criminoso->endereco or ''  }}" id="endereco" name="endereco">                        
                </div>

                <div class="col-md-3">
                     <label>Bairro</label>
                    <input type="text" class="form-control" placeholder="Bairro" 
                    value="{{  $criminoso->bairro or '' }}"id="bairro" name="bairro">
                </div>
        </div> 
        <br>
        <div class="row">
            <div class="col-md-2">
                <label>Naturalidade</label>
                <input type="text" class="form-control" placeholder="Naturalidade" 
                value="{{  $criminoso->naturalidade or ''  }}" id="naturalidade" name="naturalidade">                        
        
           </div>
           <div class="col-md-2">
            <label>Sexo*</label>
       <select class="form-control" id="sexo" name="sexo" required>
           <option value="M"  @if($criminoso->sexo == 'M')
            selected 
          @endif >Masculino</option>
           <option value="F"  @if($criminoso->sexo == 'F')
            selected 
          @endif >Feminino</option>
         </select>
       </div>
      </div>
      <br>
        <div class="row">
           <div class="col-md-6">
                <label>Nome da Mãe</label>
             <input type="text" class="form-control" placeholder="Nome da Mãe"
             value="{{  $criminoso->nome_mae or '' }}" id="nome_mae" name="nome_mae">
           </div>
           
           <div class="col-md-2">
            <label>Data de Nascimento</label>
            <input type="date" class="form-control" 
             value="{{  $criminoso->data_nascimento or '' }}" id="data_nascimento" name="data_nascimento">
            </div> 
        </div>
 <br>
 <div class="box-footer">
   <div class="btn-toolbar pull-right">
    <button type="submit" class="btn btn-success btn-lg">Salvar</button>
   </div>
</div>
   <!--FORMULÁRIO -->
    </div>
    </form>
    <div>
      <div class="box-footer">
        <div class="btn-toolbar pull-left">
          <button type="button" class="btn btn-primary" 
          data-toggle="modal" data-target="#Modal" 
         
          style="<?php 
          if(!isset($criminoso->id)){ 
             echo 'display: none;';
           }?>"
          >Incluir Registro Processual</button>
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
              <a href="{{route('inteligencia.crim.hist.excluir',$historico->id)}}" 
                      onclick="return confirmExcluirHistorico();" 
                      class="btn btn-danger btn-flat"><i class="fa fa-trash-o"></i></a>
              <form action="{{route('inteligencia.hist.excluir')}}"
                method="POST">
                {!! csrf_field() !!}  
                <input name="_method" type="hidden" value="DELETE"> 
                <input type="hidden" name="id_excluir" value="{{$historico->id}}">             
                
              </form>
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
      <a href="#" class="navbar-brand d-flex align-items-center">
        <strong>Album de fotos</strong>
      </a>
  </div>




</header>
<section class="jumbotron text-center" >
      <div class="container">
        <form method="POST" action="{{route('inteligencia.album.salvar')}}" enctype="multipart/form-data">
         <div class="form-group text-left">
          {!! csrf_field() !!}
          <input type="hidden" name="crimi_id" id="crimi_id" value="{{ $criminoso->id or '' }}" >
            <label for="descricao_img">Descrição da imagem*</label>
            <input class="form-control" id="descricao_img" name="descricao_img" required>
          </div>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="foto_da_galeria" name="foto_da_galeria" required>
            <label class="custom-file-label" for="foto_da_galeria">Escolha um arquivo</label>
          </div>
          <p>
            <button type="submit" class="btn btn-primary my-2">Enviar</button>
            <button type="reset" class="btn btn-secondary my-2">Cancelar</button>
          </p>
        </form>
      </div>
    </section>

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
                       <form method="post" action="{{route('inteligencia.album.delete')}}">
                          {!! csrf_field() !!}
                          <input type="hidden" name="_method" value="delete">
                          <input type="hidden" name="galeria_id" value="{{$galeria->id}}" >
                          <button type="submit" class="btn btn-sm btn-danger">Apagar</button>
                        </form>
                      </p>
                      </div>
                     
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
        </div>
        <br>
      </div>
    </div>
  </main>
     <!-- Início Documentos-->
     <main role="main"  style="<?php 
     if(!isset($criminoso->id)){ 
        echo 'display: none;'; }?>">
    <header>
     <div class="navbar navbar-dark bg-dark shadow-sm">
         <a href="#" class="navbar-brand d-flex align-items-center">
           <strong>Documentos</strong>
         </a>
     </div>
   </header>
       <section class="jumbotron text-center" >
         <div class="container">
           <form method="POST" action="{{route('inteligencia.doc.salvar')}}" enctype="multipart/form-data">
            <div class="form-group text-left">
             {!! csrf_field() !!}
             <input type="hidden" name="crimi_id" id="crimi_id" value="{{ $criminoso->id or '' }}" >
               <label for="descricao_documento">Descrição do documento*</label>
               <input class="form-control" id="descricao_documento" name="descricao_documento" required>
             </div>
             <div class="custom-file">
               <input type="file" class="custom-file-input" id="documento" name="documento" required>
               <label class="custom-file-label" for="documento">Escolha um arquivo</label>
             </div>
             <p>
               <button type="submit" class="btn btn-primary my-2">Enviar</button>
               <button type="reset" class="btn btn-secondary my-2">Cancelar</button>
             </p>
           </form>
         </div>
       </section>
   
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
                         <form method="post" action="{{route('inteligencia.doc.delete')}}">
                             {!! csrf_field() !!}
                             <input type="hidden" name="_method" value="delete">
                             <input type="hidden" name="documento_id" value="{{$documento->id}}" >
                             <button type="submit" class="btn btn-sm btn-danger">Apagar</button>
                           </form></p>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
                 @endforeach
           </div>
          
         </div>
     <!-- Fim Documentos-->
  </main>
    <div class="clearfix"></div>
              </div>
          </div>
      </div>
  </div>
 </section>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Adicionando Registro Processual</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('inteligencia.crim.processual.salvar')}}" >
            {{ csrf_field() }}
            <input type="hidden" name="criminoso_id" value="{{$criminoso->id or '' }}">
            <div class="row">
            <div class="col-xs-4">
                <label>Situação processual*</label>
           <select class="form-control" id="situacao_processual" name="situacao_processual" required>
               <option value="">Selecione</option>
               @foreach( $situacoes as $situacao )
               <option value="{{ $situacao->id or '' }}">
                 <p> {{ $situacao->nome }} </p></option>
               @endforeach
             </select>
           </div>
            
           <div class="col-xs-4">
              <label>Status*</label>
                <select class="form-control" id="status_processual" name="status_processual" required>
                <option value="">Selecione</option>
                 </select>
           </div>               
          </div>
           <div class="row" style="display:none;">
             
            <div class="col-xs-8">
              <label>Unidade prisional</label>
               <input type="text" class="form-control" placeholder="unidade_prisional" 
               value="{{  $criminoso->unidade_prisional or ''  }}" id="unidade_prisional" name="unidade_prisional">                        
           </div>
           </div>

       <div class="row">
          <div class="col-xs-10">
            <label for="enquadramento" class="control-label">Enquadramento*</label>
            <textarea class="form-control" id="enquadramento" name="enquadramento" required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>
    </div>
  </div>
</div>
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