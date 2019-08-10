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
                <select class="form-control" id="opm" name="opm" required >
                  <option value="">Selecione a OPM</option>
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
                       id="data_ocorre" name="data_ocorre" value="{{$ocorrencia->data or '' }}" required>
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>  

              </div>

              <div class="col-xs-4">
                  <div class="input-group">
                      <input type="time" class="form-control timepicker" placeholder="Selecione a hora" 
                      value="{{  $ocorrencia->hora or '' }}" id="hora_ocorre" name="hora_ocorre" required>
                      <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                  </div>
              </div> 
                <div class="col-xs-4">
                    <select class="form-control" id="tipo_ocorr" name="tipo_ocorr" required>
                    <option value="">Selecione o tipo da ocorrência</option>
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
              <input type="text" class="form-control" placeholder="Informe o local da ocorrência" required
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
            <option value="">Selecione o policial</option>
          </select>
      </div>

      <div class="col-xs-3">
        <select class="form-control" id="funcao">
            <option value="">Selecione a função</option>
            <option>Comandante</option>
            <option>Motorista</option>
            <option>Patrulheiro</option>
          </select>
      </div>

      <div class="col-xs-2">
        <select class="form-control" id="arma">
          <option value="">Selecione o armamento</option>
        </select>
      </div>

      <div class="col-xs-2">
      <select class="form-control" id="vtr">
          <option value="">Selecione a viatura</option>
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

<!-- INICIO ENVOLVIDO FORM -->
<div class="box box-solid box-primary">
  <div class="box-header with-border">          
        <div class="box-title">Envolvidos</div>
    </div>
          <span id="success_result"></span>                      
              <div id="repeater">
                    <div class="repeater-heading">
                        <br><button type="button" class="btn btn-info repeater-add-btn">Adicionar Envolvido</button><br><br>
                    </div>
              <div class="clearfix"></div>
              <div class="items" >
                <div class="item-content">
                   <div class="form-group">
                    <div class="row">                           
                      <div class="col-xs-2">
                          <label></label>
                          <select class="form-control" data-skip-name="true" data-name="tipo_envolvimento[]" >
                            <option value="">Tipo de Envolvimento</option>
                            <option value="Autor">Autor</option>
                            <option value="Testemunha">Testemunha</option>
                            <option value="Vítima">Vítima</option>
                          </select>
                      </div>
                      <div class="col-xs-6"> 
                          <label></label>
                          <input type="text" data-skip-name="true" data-name="envolvido[]" 
                          id="name" class="form-control"   placeholder="Nome"/>
                      </div>
                      <div class="col-xs-2">
                          <label></label>
                          <input type="text" data-skip-name="true" data-name="rg[]" id="rg" class="form-control"  placeholder="RG" />
                      </div>  
                      <div class="col-xs-1"> 
                      <label></label>
                          <input type="text" data-skip-name="true" data-name="idade[]" id="idade" class="form-control" placeholder="Idade"  />
                      </div>
                      <div class="col-xs-1">   
                          <label></label>
                              <select data-skip-name="true" class="form-control" id="sexo" data-name="sexo[]">
                                <option value="">Sexo</option>
                                <option value="M">M</option>
                                <option value="F">F</option>
                                </select>
                      </div>
                      </div>
                       <div class="box-footer">
                           <button id="remove-btn" class="btn btn-danger pull-right" onclick="$(this).parents('.items').remove()"> excluir </button>
                       </div>
                </div>
            </div>
        </div>
        <table class="table m-0" id="envolvido-table" name="envolvido-table">
          <thead>
              <tr>
                  <th style="width: 17%">Tipo de Envolvimento</th>
                  <th style="width: 50%">Nome</th>
                  <th style="width: 13%">RG</th>
                  <th style="width: 10%">Idade</th>
                  <th style="width: 10%">Sexo</th>                  
              </tr>
          </thead>
          <tbody>
            @forelse($envolvidos as $envolvido)
            <tr>
              <td>
                {{$envolvido -> tipo_envol}}
              </td>
               <td>
                {{$envolvido -> nome}}
              </td>
              <td>
                {{$envolvido -> rg}}
              </td>
              <td>
                {{$envolvido -> idade}}
              </td>
              <td>
                {{$envolvido -> sexo}}
              </td>
              <td>
                  {{$envolvido -> id}}
                </td>
                <td>
                  <a href="{{route('servico.ocorrencia.excluirenv',$envolvido->id)}}" class="btn btn-primary">Excluir</a>
                </td>
            </tr>
            @empty
            @endforelse               
           </tbody>
        </table>
    </div>
 </div>
<!-- FIM ENVOLVIDO FORM -->


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
                  <option value="">Selecione a Delegacia</option>
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
                  <option value="">Selecione a AISP</option>
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

            <div class="col-xs-2">
              <label>Armas de Fogo</label>
              <input type="number" class="form-control" 
              value="{{  $ocorrencia->armas_apreendidas or ''}}" name="prod_armas_fogo" id="prod_armas_fogo">
            </div>

            <div class="col-xs-2">
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

            <div class="col-xs-2">
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


      <!-- INICIO DROGA FORM -->
<div class="box box-solid box-default">
    <div class="box-header with-border">          
          <div class="box-title">Drogas Apreendidas</div>
    </div>
            <span id="success_result"></span>                      
                <div id="repeaterDrogas">
                      <div class="repeater-heading">
                          <br>
                          <button type="button" class="btn btn-primary repeaterDrogas-add-btn">Adicionar Droga</button>
                          <br><br>
                      </div>
                <div class="clearfix"></div>
                <div class="items" >
                  <div class="item-content">
                     <div class="form-group">
                      <div class="row">                           
                        <div class="col-xs-2">
                            <label></label>
                            <select class="form-control" data-skip-name="true" data-name="tipo_droga[]"  id="tipo_droga" >
                              <option value="">Tipo de Droga</option>
                              <option value="Maconha">Maconha</option>
                              <option value="Cocaína">Cocaína</option>
                              <option value="Crack">Crack</option>
                              <option value="Outras">Outras</option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <label></label>
                            <input type="text" data-skip-name="true" data-name="qtd_drogas[]" id="qtd_drogas" class="form-control" placeholder="Quantidade"  />
                        </div> 
                        <div class="col-xs-4"> 
                            <label></label>
                            <input type="text" data-skip-name="true" data-name="desc_outras_drogas[]" 
                              id="desc_outras_drogas" class="form-control" placeholder="Descrição"/>
                        </div> 
                       </div>
                         <div class="box-footer"> 
                           <button id="remove-btn" class="btn btn-danger pull-right" onclick="$(this).parents('.items').remove()">Remover Droga</button>
                           
                        </div>
                  </div>
              </div>
             
          </div>
          <table class="table m-0" id="drogas-table" name="drogas-table">
            <thead>
                <tr>
                    <th>Tipo de Droga</th>
                    <th>Quantidade</th>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
              
              @forelse($drogas as $droga)
              <tr>
                <td>
                  {{$droga -> tipo_droga}}
                </td>
                 <td>
                  {{$droga -> quantidade_droga}}
                </td>
                <td>
                  {{$droga -> descricao_droga}}
                </td>
                <td>
                  <a href="{{route('servico.ocorrencia.excluirdroga',$droga->id)}}" class="btn btn-primary">Excluir</a>
                </td>
              </tr>
              @empty
              @endforelse 
                           
             </tbody>
          </table>
      </div>
   </div>
</div>
  <!-- FIM DROGA FORM -->
    


        <!--FORMULÁRIO -->

      
    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                  <button type="button" class="btn btn-danger btn-lg">Limpar</button>
                  <button type="submit" class="btn btn-success btn-lg">Adicionar</button>
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

$("#repeater").createRepeater();

$("#repeaterDrogas").createRepeaterDrogas();

});

  jQuery.fn.extend({
    createRepeater: function () {
        var addItem = function (items, key) {
            var itemContent = items;
            var group = itemContent.data("group");
            var item = itemContent;
            var input = item.find('input,select');
            input.each(function (index, el) {
                var attrEnvolvido = $(el).data('envolvido');
                var attrIdade = $(el).data('idade');
                var attrEnvolvimento = $(el).data('tipo_envolvimento');
                var attrSexo = $(el).data('sexo');
                var attrName = $(el).data('name');
                var attrRG = $(el).data('rg');
                var skipName = $(el).data('skip-name');
                if (skipName != true) {
                    $(el).attr("name", group + "[" + key + "]" + attrName);
                } else {
                    if (attrName != 'undefined') {
                        $(el).attr("name", attrName);
                    }
                }
            })
            var itemClone = items;

            /* Handling remove btn */
            var removeButton = itemClone.find('.remove-btn');

            if (key == 0) {
                removeButton.attr('disabled', true);
            } else {
                removeButton.attr('disabled', false);
            }

            $("<div class='items'>" + itemClone.html() + "<div/>").appendTo(repeater);
        };
        /* find elements */
        var repeater = this;
        var items = repeater.find(".items");
        var key = 0;
        var addButton = repeater.find('.repeater-add-btn');
        var newItem = items;

        if (key == 0) {
            items.remove();
            addItem(newItem, key);
        }

        /* handle click and add items */
        addButton.on("click", function () {
            key++;
            addItem(newItem, key);
        });
    }
});

jQuery.fn.extend({
    createRepeaterDrogas: function () {
        var addItem = function (items, key) {
            var itemContent = items;
            var group = itemContent.data("group");
            var item = itemContent;
            var input = item.find('input,select');
            input.each(function (index, el) {
                var attrTipoDroga = $(el).data('tipo_droga');
                var attrDescOutraDroga = $(el).data('desc_outras_droga');
                var attrQtdDroga = $(el).data('qtd_droga');               
                var attrName = $(el).data('name');  
                var skipName = $(el).data('skip-name');
                if (skipName != true) {
                    $(el).attr("name", group + "[" + key + "]" + attrName);
                } else {
                    if (attrName != 'undefined') {
                        $(el).attr("name", attrName);
                    }
                }
            })
            var itemClone = items;

            /* Handling remove btn */
            var removeButton = itemClone.find('.remove-btn');

            if (key == 0) {
                removeButton.attr('disabled', true);
            } else {
                removeButton.attr('disabled', false);
            }

            $("<div class='items'>" + itemClone.html() + "<div/>").appendTo(repeater);
        };
        /* find elements */
        var repeater = this;
        var items = repeater.find(".items");
        var key = 0;
        var addButton = repeater.find('.repeaterDrogas-add-btn');
        var newItem = items;

        if (key == 0) {
            items.remove();
            addItem(newItem, key);
        }

        /* handle click and add items */
        addButton.on("click", function () {
            key++;
            addItem(newItem, key);
        });
    }
});

  RemoveTableRow = function(handler) {
      var tr = $(handler).closest('tr');
      tr.fadeOut(400, function() {
          tr.remove();
      });
      return false;
  };
  


  </script>
@stop