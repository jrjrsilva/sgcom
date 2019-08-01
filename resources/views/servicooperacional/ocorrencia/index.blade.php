@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Serviço Operacional</h1>
    <ol class="breadcrumb">
        <li><a href="">Serviço Operacional</a></li>
        <li><a href="">Ocorrência</a></li>
    </ol>
@stop

@section('content')

    <h2>Ocorrência</h2>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('servico.ocorrencia.salvar')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $ocorrencia->id or '' }}">
 <!--DADOS DA OCORRÊNCIA-->   

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados da Ocorrência</h3>
        </div><br>

                
        <div class="row">
              <div class="col-xs-4"> 
                <select class="form-control" id="opm" name="opm">
                  <option>Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id or ''}}" 
                    @isset($ocorrencia->opm->id)
                      @if($ocorrencia->opm->id == $opm->id)
                        selected 
                      @endif 
                    @endisset ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              </div> 

              <div class="col-xs-4"> 
                <input type="text" class="form-control" placeholder="Coordenador Regional" id="coord_cprca">
              </div> 

              <div class="col-xs-4"> 
                <input type="text" class="form-control" placeholder="Supervisor Regional" id="superv_cprca">
              </div>
        </div> <br>

        <div class="row">

              <div class="col-xs-4">
                <div class="input-group">
                      <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                       id="data_ocorre" name="data_ocorre" value="{{$ocorrencia->data or '' }}">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>  

              </div>

              <div class="col-xs-4">
                  <div class="input-group">
                      <input type="time" class="form-control timepicker" placeholder="Selecione a hora" 
                      value="{{  $ocorrencia->hora or '' }}" id="hora_ocorre" name="hora_ocorre">
                      <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                  </div>
              </div> 
                <div class="col-xs-4">
                    <select class="form-control" id="tipo_ocorr" name="tipo_ocorr">
                    <option>Selecione o tipo da ocorrência</option>
                    @foreach( $tiposocorrencias as $tipoocorrencia )
                    <option value="{{ $tipoocorrencia->id or '' }}" 
                        @isset($ocorrencia->tipoocorrencia->id)
                        @if($ocorrencia->tipoocorrencia->id == $tipoocorrencia->id)
                        selected 
                      @endif 
                    @endisset
                      ><p> {{ $tipoocorrencia->descricao }} </p></option>
                    @endforeach
                    </select>
              </div>

        </div> <br>

        <div class="form-row">
              <div class="col">
              <input type="text" class="form-control" placeholder="Informe o local da ocorrência" 
              value="{{  $ocorrencia->ocorrencia_local or '' }}" id="local_ocorre" name="local_ocorre"> 
              </div>
        </div> <br>

<!-- GUARNIÇÃO DE SERVIÇO -->

<div class="box box-solid box-primary">
          
          <div class="box-header with-border">
            <h3 class="box-title">Guarnição de Serviço</h3>
        </div><br>

        <div class="row">

        <div class="col-xs-5">
          <select class="form-control" id="policial">
            <option>Selecione o policial</option>
          </select>
      </div>

      <div class="col-xs-3">
        <select class="form-control" id="funcao">
            <option>Selecione a função</option>
            <option>Comandante</option>
            <option>Motorista</option>
            <option>Patrulheiro</option>
          </select>
      </div>

      <div class="col-xs-2">
        <select class="form-control" id="arma">
          <option>Selecione o armamento</option>
        </select>
      </div>

      <div class="col-xs-2">
      <select class="form-control" id="vtr">
          <option>Selecione a viatura</option>
        </select>
      </div>
      
   </div>
          <div class="box-footer">
            <div class="btn-toolbar">
              <button type="button" class="btn btn-info pull-right">Adicionar</button>
              <button type="button" class="btn btn-danger pull-right">Excluir</button>
             </div>
          </div>
   </div>

<!-- ENVOLVIDOS -->

        <div class="box box-solid box-default">
          
              <div class="box-header with-border">
                <h3 class="box-title">Envolvidos na Ocorrência</h3>
            </div><br>

            <div class="row">

            <div class="col-xs-2">
              <select class="form-control" id="tipo_envol" name="tipo_envol">
                <option value="Autor">Autor</option>
                <option value="Testemunha">Testemunha</option>
                <option value="Vítima">Vítima</option>
                </option>
              </select>
          </div>

          <div class="col-xs-6">
            <input type="text" class="form-control" placeholder="Nome" id="envolvido" name="envolvido">
          </div>

          <div class="col-xs-2">
            <select class="form-control" id="sexo" name="sexo">
              <option value="">informe o sexo</option>
              <option value="M">Masculino</option>
              <option value="F">Feminino</option>
              <option value="O">Outro</option>
            </select>
          </div>

          <div class="col-xs-2">
              <input type="text" class="form-control" placeholder="idade" id="idade" name="idade">
          </div>
          
       </div>
              <div class="box-footer">
                <div class="btn-toolbar">
                  <button type="button" class="btn btn-info pull-right" onclick="adicionaEnvolvido();">Adicionar</button>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#envolvidoModal" data-whatever="@mdo">Open modal for @mdo</button>
    
                </div>
              </div>
              <table class="table m-0" id="envolvido-table" name="envolvido-table">
                <thead>
                    <tr>
                        <th>Envolvimento</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($envolvidos as $envolvido)
                    <tr></tr>
                      <td>
                        {{$envolvido -> id}}
                      </td>
                      <td>
                        {{$envolvido -> tipo_envolv}}
                      </td>
                       <td>
                        {{$envolvido -> nome}}
                      </td>
                      <td>
                          {{$envolvido -> sexo}}
                        </td>
                        <td>
                            {{$envolvido -> idade}}
                          </td>
                    </tr>
                    @empty
                    @endforelse               
                   </tbody>
            </table>
       </div>

<!-- DIV DESCRIÇÃO DA OCORRÊNCIA -->

        <div class="box box-warning">
                  
                  <div class="box-header with-border">
                    <h3 class="box-title">Descrição da Ocorrência</h3>
                </div><br>

                <div class="form-row">
                  <textarea class="form-control" rows="10" placeholder="Descreva a ocorrência" 
                 value="" id="desc_ocorrencia" 
                  name="desc_ocorrencia" >{{ $ocorrencia->ocorrencia_relatorio or ''  }}</textarea>
                </div><br>
                <div class="form-row">
                  <label for="arquivoOcorrencia">Anexar</label>
                  <input type="file" id="arquivoOcorrencia">
                  <p class="help-block">Anexar arquivos ou fotos à ocorrência</p>
                
                </div>
        </div>
        
<!-- Boletim de Ocorrência -->

<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Boletim de Ocorrência</h3>
        </div><br>

                
        <div class="row">
              <div class="col-xs-4"> 
                <select class="form-control" id="delegacia" name="delegacia" >
                  <option>Selecione a Delegacia</option>
                  @foreach( $delegacias as $delegacia )
                    <option value="{{ $delegacia->id or '' }}" 
                        @isset($ocorrencia->delegacia->id)
                        @if($ocorrencia->delegacia->id == $delegacia->id)
                        selected 
                      @endif 
                    @endisset>
                    <p>{{ $delegacia->descricao }} </p></option>
                    @endforeach
                  
                </select>
              </div> 

              <div class="col-xs-6"> 
                <input type="text" class="form-control" placeholder="Endereço" 
                value="{{  $ocorrencia->end_delegacia or '' }}" id="end_delegacia" name="end_delegacia">
              </div> 

              <div class="col-xs-2"> 
              <select class="form-control" id="aisp" name="aisp">
                  <option>Selecione a AISP</option>
                  @foreach( $aisps as $aisp )
                  <option value="{{ $aisp->id or '' }}" 
                      @isset($ocorrencia->aisp->id)
                      @if($ocorrencia->aisp->id == $aisp->id)
                      selected 
                    @endif 
                  @endisset
                    ><p> {{ $aisp->descricao }} </p></option>
                  @endforeach
                </select>
              </div>
        </div> <br>

        <div class="row">

              <div class="col-xs-6">
                    <input type="text" class="form-control" placeholder="Informe o nome do delegado" 
                    value="{{  $ocorrencia->nome_delegado or ''  }}" id="delegado" name="delegado">                        
                </div>

                <div class="col-xs-3">
                    <input type="text" class="form-control" placeholder="Informe o nº inquérito" 
                    value="{{  $ocorrencia->num_inquerito or '' }}"id="inq_policial" name="inq_policial">
                    
                </div>
                
                <div class="col-xs-3">
                   <input type="text" class="form-control" placeholder="Informe o nº do BO" 
                   value="{{  $ocorrencia->num_boletim or ''}}" id="bo" name="bo">
              </div>

        </div> <br>

      
       
      <!-- Produtividade da ocorrência -->

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Produtividade</h3>
          </div><br>

          <div class="row">

            <div class="col-xs-2">
              <label>Veículos Recuperados</label>
              <input type="number" class="form-control" 
              value="{{  $ocorrencia->veiculos_recuperados  or ''}}" id="prod_veiculos" name="prod_veiculos">
            </div>

            <div class="col-xs-1">
              <label>Armas de Fogo</label>
              <input type="number" class="form-control" 
              value="{{  $ocorrencia->armas_apreendidas or ''}}" name="prod_armas_fogo" id="prod_armas_fogo">
            </div>

            <div class="col-xs-1">
            <label>Armas Brancas</label>
              <input type="number" class="form-control" 
              value="{{  $ocorrencia->armas_brancas or ''}}" name="prod_armas_branca" id="prod_armas_branca">
            </div>

            <div class="col-xs-2">
            <label>Armas Artesanais</label>
              <input type="number" class="form-control" 
              value="{{ $ocorrencia->armas_artesanais or ''}}" name="prod_armas_artesanais" id="prod_armas_artesanais">
            </div>

            <div class="col-xs-2">
            <label>Flagrantes</label>
              <input type="number" class="form-control" 
              value="{{  $ocorrencia->flagrantes or ''}}" name="prod_flagrantes" id="prod_flagrantes">
            </div>

            <div class="col-xs-1">
            <label>TCO</label>
              <input type="number" class="form-control" 
              value="{{  $ocorrencia->tco or ''}}" name="prod_tcos" id="prod_tcos">
            </div>

            <div class="col-xs-2">
            <label>Menor Apreendido</label>
              <input type="number" class="form-control" 
              value="{{  $ocorrencia->menores_apreendidos or ''}}" name="prod_menores_apreend" id="prod_menores_apreend">
            </div>


          </div> <br>

          <div class="box box-solid box-info">
          
              <div class="box-header with-border">
                <h3 class="box-title">Drogas Apreendidas</h3>
            </div><br>

          <div class="row">

            <div class="col-xs-4">
              <select class="form-control" id="tipo_droga"  name="tipo_droga">
                <option>Selecione o tipo de droga</option>
                <option value="2">Maconha</option>
                <option value="3">Cocaína</option>
                <option value="4">Crack</option>
                <option value="1">Outra</option>
              </select>
            </div>

            <div class="col-xs-2">
              <input type="text" class="form-control" placeholder="Descrição de outra droga" id="desc_outra_droga" name="desc_outra_droga">
            </div>

            <div class="col-xs-2">
              <input type="text" class="form-control" placeholder="Quantidade de droga" id="qtd_droga" name="qtd_droga">
            </div>

                    
       </div>
              <div class="box-footer">
                <div class="btn-toolbar">
                  <button type="button" class="btn btn-info pull-right">Adicionar</button>
                  <button type="button" class="btn btn-danger pull-right">Excluir</button>
                 </div>
              </div>
       </div>
      </div>
    


        <!--FORMULÁRIO -->

      
    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                  <button type="button" class="btn btn-danger btn-lg">Limpar</button>
                  <button type="submit" class="btn btn-success btn-lg">Adicionar</button>
                 </div>
              </div>
    </form>
    
     
    <div class="modal fade" id="envolvidoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Envolvido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Tipo de envolvimento:</label>
                <div class="col-xs-4">
                    <select class="form-control" id="tipo_envol" name="tipo_envol">
                      <option value="Autor">Autor</option>
                      <option value="Testemunha">Testemunha</option>
                      <option value="Vítima">Vítima</option>
                      </option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Message:</label>
                <div class="col-xs-6">
                    <input type="text" class="form-control" placeholder="Nome" id="envolvido" name="envolvido">
                  </div>
              </div>
              <div class="form-group">
                  <label for="message-text" class="col-form-label">Sexo</label>
                  <div class="col-xs-2">
                      <select class="form-control" id="sexo" name="sexo">
                        <option value="">informe o sexo</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                      </select>
                    </div>
              </div>
            </form>
            <div class="row">

               
    
             
    
              
    
              <div class="col-xs-2">
                  <input type="text" class="form-control" placeholder="idade" id="idade" name="idade">
              </div>
              
           </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Send message</button>
          </div>
        </div>
      </div>
    </div>         

    </section>
@stop

@section('js')
<script>

$('#envolvidoModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})

  RemoveTableRow = function(handler) {
      var tr = $(handler).closest('tr');
      tr.fadeOut(400, function() {
          tr.remove();
      });
      return false;
  };
  
  

  AddTable = function() {
  $(document).ready(function() {  

      var idade_i = $('#idade').val();
     var envolvimento_i = $('#tipo_envol').val();
     var nome_i = $('#envolvido').val();
     var sexo_i = $('#sexo').val();
    
     
     var envolvidos = [];
      envolvidos.push(sexo_i);
      envolvidos.push(nome_i);
      envolvidos.push(envolvimento_i);
      alert(envolvidos)

     var valores = '<?=$envolvidos ?>';
      alert(valores);
    });
  };

  function adicionaEnvolvido(){
    if($("tipo_envolv").val() != '' && $("#envolvido").val() != '' && $("sexo").val() != ''){
      envolvidoAdd();

      formClear();

      $("tipo_envolv").focus();
    }
  }
  
  function envolvidoAdd(){
    if($("#envolvido-table tbody").length == 0){
      $("#envolvido-table tbody").append("<tbody></tbody>");
    }
    
    $("#envolvido-table tbody").append(
      "<tr>"+
      "<td><input type='text' readonly='readonly' name='envolvidos[tipo_envolv_t][]' value='"+ $('#tipo_envol').val() +"'/></td>" +
      "<td><input type='text' readonly='readonly' name='envolvidos[envolvido_t][]' value='"+ $('#envolvido').val() +"'/></td>" +
      "<td><input type='text' readonly='readonly' name='envolvidos[sexo_t][]' value='"+ $('#sexo').val() +"'/></td>" +
      "<td><input type='text' readonly='readonly' name='envolvidos[idade_t][]' value='"+ $('#idade').val() +"'/></td>" +
      "<td>"+
      "<button type='button' "+
        "onclick='deleteLinha(this);'"+
        "class='btn btn-default' >"+
        "<span class='glyphicon glyphicon-remove'></span>"+
      "</button>"+
      "</td>"+
      "</tr>"
      ); 
  }

  function formClear(){
    $('#idade').val("");
    $('#tipo_envol').val("");
    $('#envolvido').val("");
    $('#sexo').val("");
  }

  function deleteLinha(button_delete){
    $(button_delete).parents("tr").remove();
  }

  </script>
@stop