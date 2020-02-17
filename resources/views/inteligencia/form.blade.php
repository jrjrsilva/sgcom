@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Inteligência</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inteligencia.index')}}">Inteligência</a></li>
        <li><a href="">criminosos</a></li>
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
              <div class="col-xs-3">
                   <label>Foto</label>
                   @if($criminoso->foto != null)
                   <img src="{{ url($criminoso->foto) }}" alt="{{ $criminoso->nome }}"
                   height="200" width="150" >                 
                  @else
                  <img src="{{url("fotos/sem_foto.jpg")}}" height="200" width="150">
                  @endif
                  <input type="file" class="custom-file-input" id="arquivo" name="arquivo" >
              </div> 

              <div class="col-xs-8">
                   <label>Nome</label>
                <input type="text" class="form-control" placeholder="Nome" 
                value="{{  $criminoso->nome or '' }}" id="nome" name="nome">
              </div> 
        </div>
        <br>
              <div class="row">
              <div class="col-xs-2">
                <label>Apelido</label>
             <input type="text" class="form-control" placeholder="Apelido" 
             value="{{  $criminoso->apelido or '' }}" id="apelido" name="apelido">
           </div> 

           <div class="col-xs-2">
            <label>RG</label>
         <input type="text" class="form-control" placeholder="rg" 
         value="{{  $criminoso->rg or '' }}" id="rg" name="rg">
        </div> 

        <div class="col-xs-2">
            <label>CPF</label>
         <input type="text" class="form-control" placeholder="CPF" 
         value="{{  $criminoso->cpf or '' }}" id="cpf" name="cpf">
       </div> 

              <div class="col-xs-2">
                   <label>Facção</label>
              <select class="form-control" id="faccao" name="faccao">
                  <option value="">Selecione a Facção</option>
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

        </div> 

              <br>

        <div class="row">
            <div class="col-xs-2">
                <label>Posição</label>
           <select class="form-control" id="posicao" name="posicao">
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
              <div class="col-xs-6">
                   <label>Endereço</label>
                    <input type="text" class="form-control" placeholder="Endereço" 
                    value="{{  $criminoso->endereco or ''  }}" id="endereco" name="endereco">                        
                </div>

                <div class="col-xs-3">
                     <label>Bairro</label>
                    <input type="text" class="form-control" placeholder="Bairro" 
                    value="{{  $criminoso->bairro or '' }}"id="bairro" name="bairro">
                    
                </div>
                
            

        </div> <br>

        <div class="row">
            <div class="col-xs-2">
                <label>Naturalidade</label>
                <input type="text" class="form-control" placeholder="Naturalidade" 
                value="{{  $criminoso->naturalidade or ''  }}" id="naturalidade" name="naturalidade">                        
        
           </div>
              <div class="col-xs-6">
                   <label>Área de atuação</label>
                    <input type="text" class="form-control" placeholder="area_atuacao" 
                    value="{{  $criminoso->area_atuacao or ''  }}" id="area_atuacao" name="area_atuacao">                        
                </div>

                <div class="col-xs-3">
                    <label>AISP</label>
               <select class="form-control" id="aisp" name="aisp">
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
            </div>

      <br>

        <div class="row">
            <div class="col-xs-2">
                    <label>Barralho do crime</label>
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
 <div class="box-footer">
   <div class="btn-toolbar pull-right">
    <button type="submit" class="btn btn-success btn-lg">Salvar</button>
   </div>
</div>
             <!--FORMULÁRIO -->

      
    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-left">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Registro Processual</button>
                 </div>
              </div>
    </form>

    <div class="box-body">
      <table id="tb1" class="table table-bordered table-striped">
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
                      onclick="return confirmExcluirHistorico();" class="btn btn-danger btn-flat"><i class="fa fa-trash-o"></i></a>
          </td>
          </tr>
          @empty
          @endforelse 
       </tbody>
       
      </table>
    
    </div>
   
    <!-- /.box-body -->
  </div>

    <div class="clearfix"></div>
              </div>
          </div>
      </div>
  </div>
 </section>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
                <label>Situação processual</label>
           <select class="form-control" id="situacao_processual" name="situacao_processual" required>
               <option value="">Selecione</option>
               @foreach( $situacoes as $situacao )
               <option value="{{ $situacao->id or '' }}">
                 <p> {{ $situacao->nome }} </p></option>
               @endforeach
             </select>
           </div>
            
           <div class="col-xs-4">
              <label>Status</label>
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
            <label for="enquadramento" class="control-label">Enquadramento</label>
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

 $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
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