@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>Gestão de Pessoal</h1>
    <ol class="breadcrumb">
    <li><a href="{{route('rh.policiais')}}">Pesquisar</a></li>
        <li><a href="">Efetivo</a></li>
    </ol>
@stop

@section('content')

    <h3>Incluir</h3>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('rh.incluirSalvarPolicial')}}" >
    {!! csrf_field() !!}
   
 <!--DADOS  DO POLICIAL-->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados do Policial</h3>
          @include('site.includes.alerts')
        </div><br>
        
        <div class="row">
        <div class="form-row">
            <div class="col-xs-2"> 
                <label for="gh">Grau Hierarquico</label>
              <select class="form-control" id="gh" name="gh" required >
                <option value="">Selecione</option>
                @foreach( $ghs as $gh )
                <option value="{{ $gh->id or ''}}" 
                  @isset($efetivo->grauhierarquico->id)
                    @if($efetivo->grauhierarquico->id == $gh->id)
                      selected 
                    @endif 
                  @endisset ><p> {{ $gh->sigla }} </p></option>
                @endforeach
              </select>
            </div> 

            <div class="col-xs-2"> 
              <label for="opm">OPM</label>
                <select class="form-control" id="opm" name="opm" required >
                  <option value="">Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id or ''}}" 
                    @isset($efetivo->opm->id)
                      @if($efetivo->opm->id == $opm->id)
                        selected 
                      @endif 
                    @endisset ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              </div> 

              <div class="col-xs-5">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" placeholder="Nome" required
              value="{{  $efetivo->nome or '' }}" id="nome" name="nome"> 
              </div>
      
        
            <div class="col-xs-2">
                <label for="matricula">Matrícula</label>
            <input type="number" class="form-control" placeholder="Informe a matricula" required
            value="{{  $efetivo->matricula or '' }}" id="matricula" name="matricula"> 
            </div>
        </div>
        </div>
        <br>
        </div>
        <!--FORMULÁRIO -->

    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                   <button type="submit" class="btn btn-success btn-lg">Salvar</button>
                 </div>
              </div>
    </form>
      <div class="box-footer">
        <div class="btn-toolbar pull-left">
           <button type="submit" class="btn btn-success btn-lg" id="btn-start">Start</button>
         </div>
      </div>
    

 <!-- loadingModal-->
 <div class="modal fade" data-backdrop="static" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal_label">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="loadingModal_label">
                  <span class="glyphicon glyphicon-refresh"></span>
                  Aguarde...
              </h5>
          </div>
          <div class="modal-body">
              <div class='alert' role='alert'>
                  <center>
                      <div class="loader" id="loader"></div><br>
                      <h4><b id="loadingModal_content"></b></h4>
                  </center>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- loadingModal-->

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
  $(function () {
  //Comportamento do botao de disparo
    $('#btn-start').click(function () {
        getResponse();
     });
    });
            /**
             * Dispara o modal e espera a resposta do script
             * @returns {void}
             */
   function getResponse() {
       $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
                //Preenche e mostra o modal
    $('#loadingModal_content').html('Carregando...');
    $('#loadingModal').modal('show');
    //Envia a requisicao e espera a resposta
    $.post("/admin/efetivo/atualizarPolicial")
          .done(function () {
                        //Se nao houver falha na resposta, preenche o modal
          $('#loader').removeClass('loader');
          $('#loader').addClass('glyphicon glyphicon-ok');
          $('#loadingModal_label').html('Sucesso!');
          $('#loadingModal_content').html('<br>Executada com sucesso!');
          resetModal();
          })
          .fail(function () {
                        //Se houver falha na resposta, mostra o alert
          $('#loader').removeClass('loader');
          $('#loader').addClass('glyphicon glyphicon-remove');
          $('#loadingModal_label').html('Falha!');
          $('#loadingModal_content').html('<br>Erro na execução!');
          resetModal();
          });
            }
          function resetModal(){
                //Aguarda 2 segundos ata restaurar e fechar o modal
            setTimeout(function() {
            $('#loader').removeClass();
            $('#loader').addClass('loader');
            $('#loadingModal_label').html('<span class="glyphicon glyphicon-refresh"></span>Aguarde...');
            $('#loadingModal').modal('hide');
            }, 2000);
            }
        </script>
@stop
@section('css')
<style>
            /*Regra para a animacao*/
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            /*Mudando o tamanho do icone de resposta*/
            div.glyphicon {
                color:#6B8E23;
                font-size: 38px;
            }
            /*Classe que mostra a animacao 'spin'*/
            .loader {
              border: 16px solid #f3f3f3;
              border-radius: 50%;
              border-top: 16px solid #3498db;
              width: 80px;
              height: 80px;
              -webkit-animation: spin 2s linear infinite;
              animation: spin 2s linear infinite;
            }
        </style>
@stop