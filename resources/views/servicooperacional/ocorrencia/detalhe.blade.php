@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Serviço Operacional</h1>
    <ol class="breadcrumb">
        <li><a href="">Serviço Operacional</a></li>
        <li><a href="">Ocorrência Detalhe</a></li>
    </ol>
@stop

@section('content')

    <h2>Ocorrência Detalhe</h2>
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $ocorrencia->id or '' }}">
 <!--DADOS DA OCORRÊNCIA-->   

<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dados da Ocorrência</h3>
        </div><br>
            <table id="ocorrencia" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>OPM:</th>
                        <th>Coordenador Regional:</th>
                        <th>Supervisor Regional:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $ocorrencia->opm->opm_sigla }}</td>
                        <td> Não informado</td>
                        <td> Não informado</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Tipo de Ocorrência</th>
                    </tr>
                    <tr>
                        <td>{{$ocorrencia->data or '' }}</td>
                        <td>{{  $ocorrencia->hora or '' }}</td>
                        <td>{{$ocorrencia->tipoocorrencia->descricao}}</td>
                    </tr>
                    </tbody>
            </table>
    
            <table id="Localocorrencia" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Local da Ocorrência</th>
                    </tr>    
                </thead>
                <tbody>
                    <tr>
                        <td>{{  $ocorrencia->ocorrencia_local or '' }}</td>
                    </tr>
                </tbody>
            </table>
    
        
      
<!-- GUARNIÇÃO DE SERVIÇO -->

<div class="box box-solid box-primary">
          
        <div class="box-header with-border">
            <h3 class="box-title">Guarnição de Serviço</h3>
        </div><br>

        <table id="guarnicao" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Policial Militar</th>
                        <th>Função</th>
                        <th>Armamento</th>
                        <th>Viatura</th>
                    </tr>    
                </thead>
                <tbody>
                    <tr>
                        <td>Não informado</td>
                        <td>Não Informado</td>
                        <td>Não Informado</td>
                        <td>Não Informado</td>
                    </tr>
                </tbody>
        </table>
        
</div>

<!-- INICIO ENVOLVIDO FORM -->
<div class="box box-solid box-primary">
  <div class="box-header with-border">          
        <div class="box-title">Envolvidos</div>
    </div>
          <span id="success_result"></span>                      
              
              <div class="clearfix"></div>
              
        <table class="table table-bordered table-striped" id="envolvido-table" name="envolvido-table">
          <thead>
              <tr>
                  <th>Tipo de Envolvimento</th>
                  <th>Nome</th>
                  <th>RG</th>
                  <th>Idade</th>
                  <th>Sexo</th>                  
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
                <table id="descOcorre" class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td>
                            {{ $ocorrencia->ocorrencia_relatorio or ''  }}
                            </td>
                        </tr>
                    </tbody>    
                </table>
            
                <div class="box-header with-border">
                    <h3 class="box-title">Arquivos da Ocorrência</h3>
                </div>
            
                <table id="arquivosOcorrencia" class="table table-bordered table-striped">
                    
                    <thead>
                        <tr>
                            <th>Arquivo 1</th>
                            <th>Arquivo 2</th>
                            <th>Arquivo 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="cinqueterre.jpg" class="img-thumbnail" alt="Arquivo 1"></td>
                            <td><img src="cinqueterre.jpg" class="img-thumbnail" alt="Arquivo 2"></td>
                            <td><img src="cinqueterre.jpg" class="img-thumbnail" alt="Arquivo 3"></td>
                        </tr>
                    </tbody>    
                </table>              
             
        </div>
        
<!-- Boletim de Ocorrência -->

<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Boletim de Ocorrência</h3>
        </div><br>
    
    <table id="boletimOcorr" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Delegacia</th>
                        <th>Endereço da DP</th>
                        <th>AISP</th>                        
                    </tr>    
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $ocorrencia->delegacia->descricao or '' }}</td>
                        <td>{{ $ocorrencia->end_delegacia or '' }}</td>
                        <td>{{  $aisp->id or '' }}</td>                        
                    </tr>
                    <tr>
                        <th>Delegado</th>
                        <th>Número do Inquérito</th>
                        <th>Número do B.O.</th>
                    </tr>
                    <tr>
                        <td>{{  $ocorrencia->nome_delegado or ''  }}</td>
                        <td>{{  $ocorrencia->num_inquerito or '' }}</td>
                        <td>{{  $ocorrencia->num_boletim or ''}}</td>                        
                    </tr>
                </tbody>
        </table>        
                
        <br>

         <br>

      
       
      <!-- Produtividade da ocorrência -->

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Produtividade</h3>
          </div><br>
    
            <table id="produtividade" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Veiculos Recuperados</th>
                        <th>Armas de Fogo</th>
                        <th>Armas Brancas</th> 
                        <th>Armas Artesanais</th>
                    </tr>    
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $ocorrencia->veiculos_recuperados  or ''}}</td>
                        <td>{{ $ocorrencia->armas_apreendidas or ''}}</td>
                        <td>{{ $ocorrencia->armas_brancas or ''}}</td>
                        <td>{{ $ocorrencia->armas_artesanais or ''}}</td>
                    </tr>
                    <tr>
                        <th>Flagrantes</th>
                        <th>TCO</th>
                        <th>Menor Apreendido</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>{{  $ocorrencia->flagrantes or ''}}</td>
                        <td>{{  $ocorrencia->tco or ''}}</td>
                        <td>{{  $ocorrencia->menores_apreendidos or ''}}</td>                     
                        <td></td>
                    </tr>
                </tbody>
        </table>      
            

         


      <!-- INICIO DROGA FORM -->
<div class="box box-solid box-default">
    <div class="box-header with-border">          
          <div class="box-title">Drogas Apreendidas</div>
    </div>
          <table class="table m-0" id="drogas-table" name="drogas-table">
            <thead>
                <tr>
                    <th>Tipo de Droga</th>
                    <th>Quatidade</th>
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