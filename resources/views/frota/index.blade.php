@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Frota</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('frota.lista')}}">Gestão de frota</a></li>
        <li><a href="">Cadastro</a></li>
    </ol>
@stop

@section('content')

    <h2>Cadastro</h2>
    @include('site.includes.alerts')
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" method="POST" action="{{ route('frota.salvar')}}" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $viatura->id or '' }}">
    <input type="hidden" name="idmodelo" id="idmodelo" value="{{ $viatura->modelo_veiculo_id or '' }}">
 <!--DADOS -->   

      <div class="box box-primary">
         <div class="row">
              <div class="col-md-3"> 
                <label>OPM</label>  
                <select class="form-control" id="opm" name="opm" required >
                  <option value="">Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id or ''}}" 
                    @isset($viatura->opm->id)
                      @if($viatura->opm->id == $opm->id)
                        selected 
                      @endif 
                    @endisset ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              </div> 
            
             <div class="col-md-3"> 
                <label>Emprego</label>  
                <select class="form-control" id="emprego" name="emprego" required >
                  <option value="">Selecione o Emprego</option>
                  @isset($viatura)
                   <option value="Administrativo"
                     @if($viatura->emprego == 'Administrativo') selected @endif
                     >Administrativo</option>
                   <option value="Operacional"
                     @if($viatura->emprego == "Operacional") selected @endif
                     >Operacional</option>
                   <option value="Inteligência"
                     @if($viatura->emprego == 'Inteligência') selected @endif
                     >Inteligência</option>
                   @endisset
                 
                </select>
              </div> 
            
            <div class="col-md-3"> 
                <label>Propriedade da Viatura</label>  
                <select class="form-control" id="propriedade" name="propriedade" required >
                  <option value="">Selecione a Propriedade</option>
                  @isset($viatura)
                   <option value="Patrimônio PM"
                     @if($viatura->propriedade == 'Patrimônio PM') selected @endif
                     >Patrimônio PM</option>
                   <option value="Alugada"
                     @if($viatura->propriedade == "Alugada") selected @endif
                     >Alugada</option>
                   <option value="Reserva Temporária"
                     @if($viatura->propriedade == 'Reserva Temporária') selected @endif
                     >Raserva Temporária</option>
                   @endisset
                 
                </select>
              </div> 
            </div>
            <br>
              <div class="row">
              <div class="col-md-2"> 
                <label>Placa</label>
                <input type="text" class="form-control" placeholder="Placa da VTR" 
                  id="placa" name="placa" required maxlength="8" value="{{$viatura->placa or ''}}"
                style="text-transform: uppercase;">
              </div> 

              <div class="col-md-2">
                <label>Prefixo</label>
                <input type="text" class="form-control" placeholder="Prefixo da VTR" value="{{$viatura->prefixo or ''}}"
                  id="prefixo" name="prefixo" maxlength="6" data-mask="0.0000" data-mask-selectonfocus="true">
              </div>

              <div class="col-md-2"> 
                <label>Plotagem</label>  
                <select class="form-control" id="plotagem" name="plotagem" required >
                  <option value="">Selecione o estado</option>
                  @isset($viatura)
                   <option value="BOA"
                     @if($viatura->plotagem == 'BOA') selected @endif
                     >BOA</option>
                   <option value="MÉDIA"
                     @if($viatura->plotagem == "MÉDIA") selected @endif
                     >MÉDIA</option>
                   <option value="RUÍM"
                     @if($viatura->plotagem == 'RUÍM') selected @endif
                     >RUÍM</option>
                   @endisset
                 
                </select>
              </div> 

              <div class="col-md-2">
                <label>Cor</label>  
                <select class="form-control" id="cor" required name="cor">
                    <option value="">Selecione a cor</option>
                   @isset($viatura)
                    <option value="Padrão PM"
                      @if($viatura->cor == 'Padrão PM') selected @endif
                      >Padrão PM</option>
                    <option value="CIPT"
                      @if($viatura->cor == "CIPT") selected @endif
                      >CIPT</option>
                    <option value="SOINT"
                      @if($viatura->cor == 'SOINT') selected @endif
                      >SOINT</option>
                    @endisset
                  </select>
              </div>
        </div> <br>


    <div class="row">

      <div class="col-md-2">
              <label>Marca:</label>
                 <select class="form-control" id="marcaveiculo" name="marcaveiculo" 
                  required class="marcaveiculo">
                    <option value="">Selecione</option>
                    @foreach( $marcaveiculos as $marcaveiculo )
                    <option value="{{$marcaveiculo->id or '' }}" 
                        @isset($viatura->marcaveiculo->id)
                          @if($viatura->marcaveiculo->id == $marcaveiculo->id)
                            selected 
                           @endif 
                     @endisset
                      ><p> {{ $marcaveiculo->descricao }} </p></option>
                    @endforeach
                    </select>
      </div>
     
    <div class="col-md-2">
     
          <label>Modelo:</label>
          <select class="form-control" id="modeloveiculo" 
          required name="modeloveiculo">
            <option value="">Selecione</option>
            @foreach( $modeloveiculos as $modeloveiculo )
            <option value="{{$modeloveiculo->id or '' }}" 
                @isset($viatura->modeloveiculo->id)
                @if($viatura->modeloveiculo->id == $modeloveiculo->id)
                selected 
              @endif 
            @endisset
              ><p> {{ $modeloveiculo->descricao }} </p></option>
            @endforeach
            </select>


    </div>

    <div class="col-md-2">
            <label>KM:</label>
            <input type="number" class="form-control " 
            required placeholder="KM da VTR" maxlength="6"
            value="{{  $viatura->km or '' }}" id="km" name="km" />
    </div> 
    <div class="col-md-2">
          <label>CHASSI:</label>
          <input type="text" class="form-control "  required
          style="text-transform: uppercase;"
            placeholder="Chassi" maxlength="15" 
            value="{{  $viatura->chassi or '' }}" id="chassi" name="chassi" />
       
    </div>
    </div>
    <br>
    <div class="row">
    <div class="col-md-2">
        <label>Renavam:</label>
        <input type="text"  class="form-control " 
        required placeholder="renavam do veículo" maxlength="10"
        value="{{  $viatura->renavam or '' }}" id="renavam" name="renavam" />
</div> 
<div class="col-md-2">
      <label>Patrimônio:</label>
      <input type="text" class="form-control " 
      required placeholder="tipo" maxlength="15" 
        value="{{  $viatura->patrimonio or '' }}" id="patrimonio" name="patrimonio" />
</div>


<div class="col-md-2">
    <label>Combustível</label>  
    <select class="form-control" id="combustivel" 
        required name="combustivel">
        <option value="">Selecione o Combustível</option>
        @foreach( $combustiveis as $combustivel )
        <option value="{{$combustivel->id or '' }}" 
            @isset($viatura->combustivel->id)
            @if($viatura->combustivel->id == $combustivel->id)
            selected 
          @endif 
        @endisset
          ><p> {{ $combustivel->descricao }} </p></option>
        @endforeach
      </select>
  </div>

  
  <div class="col-md-2">
    <label>Situação</label>  
    <select class="form-control" id="situacao" required name="situacao">
        <option value="">Selecione a Situação</option>
        @foreach( $situacaoviaturas as $situacaoviatura )
        <option value="{{$situacaoviatura->id or '' }}" 
            @isset($viatura->situacaoviatura->id)
            @if($viatura->situacaoviatura->id == $situacaoviatura->id)
            selected 
          @endif 
        @endisset
          ><p> {{ $situacaoviatura->descricao }} </p></option>
        @endforeach
      </select>
  </div>
</div>
<br>
<div class="row">
   <div class="col-md-2">
        <label>Ano Modelo</label>
        <input type="text" class="form-control" required
         maxlength="4" minlength="4" placeholder="Informe o ano do modelo" 
         value="{{$viatura->ano_modelo or '' }}"id="anomodelo" name="anomodelo">
    </div>
    <div class="col-md-2">
     <label>Ano Fabricação</label>
       <input type="text" class="form-control" required
        maxlength="4" minlength="4" placeholder="Informe o ano de fabricação" 
        value="{{$viatura->ano_fabricacao or ''}}" id="anofabricacao" name="anofabricacao">
      </div>
      <div class="col-md-2">
                <label>Codigo dos Pneus</label>  
                <select class="form-control" id="tipopneu" name="tipopneu" required>
                    <option value="">Selecione o tipo</option>
                    @foreach( $tipopneus as $tipopneu )
                    <option value="{{$tipopneu->id or '' }}" 
                        @isset($viatura->tipopneu->id)
                        @if($viatura->tipopneu->id == $tipopneu->id)
                        selected 
                      @endif 
                    @endisset
                      ><p> {{ $tipopneu->descricao }} </p></option>
                    @endforeach
                    
                  </select>
              </div>
             
            </div>
            <br>
            <div class="row">
              <div class="col-md-2">
                <label>Presídio</label>  
                <select class="form-control" id="presidio" required name="presidio">
                    <option value="">Selecione</option>
                   @isset($viatura)
                    <option value="COM PRESÍDIO"
                      @if($viatura->presidio == 'COM PRESÍDIO') selected @endif
                      >COM PRESÍDIO</option>
                    <option value="SEM PRESÍDIO"
                      @if($viatura->presidio == "SEM PRESÍDIO") selected @endif
                      >SEM PRESÍDIO</option>
                    @endisset
                  </select>
              </div>
        <div class="col-md-2">
                <label>Bateria</label>  
                <select class="form-control" id="bateria" name="bateria" required>
                    <option value="">Selecione</option>
                    @foreach( $baterias as $bateria )
                    <option value="{{$bateria->id or '' }}" 
                        @isset($viatura->bateria->id)
                        @if($viatura->bateria->id == $bateria->id)
                        selected 
                      @endif 
                    @endisset
                      ><p> {{ $bateria->descricao }} </p></option>
                    @endforeach

                  </select>
              </div>
              <div class="col-md-2">
                <label>Revisão</label>
                  A cada: <input type="number" class="form-control" required
                   maxlength="5" minlength="4" placeholder="Informe o valor" 
                   value="{{$viatura->km_por_revisao or ''}}" id="kmrevisao" name="kmrevisao">

                 <p>@if(isset($viatura->ultima_revisao_km)) Feita com {{number_format($viatura->ultima_revisao_km,0,'.','.')}} KM @endif <br>
                  @if(isset($viatura->ultima_revisao_data))Em Data de {{ \Carbon\Carbon::parse($viatura->ultima_revisao_data)->format('d/m/Y')}}@endif </p>
                <P>Revisão 
                  @if($viatura->ultima_revisao_km + $viatura->km_por_revisao < $viatura->km)
                      Atrasada
                      @elseif($viatura->ultima_revisao_km + $viatura->km_por_revisao > $viatura->km)
                      No Prazo
                  @endif
                </P>   
                </div>
        </div> <br>
        <!--FORMULÁRIO -->
    </div>
              <div class="box-footer">
                <div class="btn-toolbar pull-right">
                 
                  <button type="submit" class="btn btn-success btn-lg">Salvar</button>
                 </div>
              </div>
    
    <div class="clearfix"></div>
    </form>
   
    <div class="box-body">  
      <div class="row">
      <div class="col-md-6">
      <table id="tb2" class="table table-bordered table-striped w-auto">
        <caption>Revisões</caption>
      <thead>
      <tr>
        <th width="20%">Data Revisao</th>
        <th width="20%">KM</th>
        <th>Local</th>        
      </tr>
      </thead>
      <tbody>
        @forelse($revisoes as $revisao)
        <tr>
          <td>{{\Carbon\Carbon::parse($revisao->data)->format('d/m/Y')}}</td>
          <td>{{number_format($revisao->km,0,'.','.')}}</td>
          <td>{{ $revisao->local}}</td>
        </tr>
      
        @empty
        Sem lançamentos
        @endforelse 
     </tbody>
    </table>
      </div>
     <div class="col-md-6">
     <table id="tb3" class="table table-bordered table-striped">
       <caption>Histórico da viatura</caption>
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
     </div>
    </div>
    </div>
    
                </div>
          </div>
      </div>
  </div>

    </section>
@stop

@section('js')
<script>
 $(document).ready(function(){
  var id_marca = $('#marcaveiculo').val();
  recarregar(id_marca);
 
});

function recarregar(id){
 var id_modelo = $('#idmodelo').val();
        $.get('/admin/veiculo/modelos/'+id, function (modelos) {
            $('select[name=modeloveiculo]').empty();
            $.each(modelos, function (key, value) {
                $('select[name=modeloveiculo]').append('<option value=' + value.id + '>' + value.descricao + '</option>');
            });
            $('#modeloveiculo').val(id_modelo);
        });
};

$('#marcaveiculo').change(function () {
        var id_veiculo = $(this).val();
        $.get('/admin/veiculo/modelos/'+id_veiculo, function (modelos) {
            $('select[name=modeloveiculo]').empty();
            $.each(modelos, function (key, value) {
                $('select[name=modeloveiculo]').append('<option value=' + value.id + '>' + value.descricao + '</option>');
            });
        });
    });
    
</script>

@stop