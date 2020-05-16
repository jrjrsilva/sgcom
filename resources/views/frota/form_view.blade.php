@extends('adminlte::page')

@section('title', 'SGCOM ')

@section('content_header')
    <h1>Gestão de Frota</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('frota.lista')}}">Gestão de frota</a></li>
        <li><a href="{{route('frota.index')}}">Cadastro</a></li>
    </ol>
@stop

@section('content')

    <h2>Detalhe</h2>
   
    <div class="box">

    <section class="content">


 <!--FORMULÁRIO -->                            

    <form role="form" >
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{ $viatura->id or '' }}">
    <input type="hidden" name="idmodelo" id="idmodelo" value="{{ $viatura->modelo_veiculo_id or '' }}">
 <!--DADOS -->   

      <div class="box box-primary">
         <div class="row">
              <div class="col-md-3"> 
                <label>OPM</label>  
               <p>{{$viatura->opm->opm_sigla}}</p>
         </div> 
            
             <div class="col-md-3"> 
                <label>Emprego</label>  
                <p>{{$viatura->emprego}}</p>
              </div> 
            
            <div class="col-md-3"> 
                <label>Propriedade da Viatura*</label>  
                <p>{{$viatura->propriedade}}</p>
              </div> 
            </div>
            <br>
              <div class="row">
              <div class="col-md-2"> 
                <label>Placa</label>
               <p>{{$viatura->placa}}</p>
                </div> 

              <div class="col-md-2">
                <label>Prefixo</label>
                <p>{{$viatura->prefixo}}</p>
                  </div>

              <div class="col-md-2"> 
                <label>Plotagem</label>  
                <p>{{$viatura->plotagem}}</p>
              </div> 

              <div class="col-md-2">
                <label>Cor</label>  
                    <p>{{$viatura->cor}}</p>
              </div>
        </div> <br>


    <div class="row">

      <div class="col-md-2">
              <label>Marca:
              </label>
              <p>{{$viatura->marcaveiculo->nome}}</p>
      </div>
     
    <div class="col-md-2">
     
          <label>Modelo:</label>
<p>          {{$viatura->modeloveiculo->id}}</p>
    </div>

    <div class="col-md-2">
            <label>KM:</label>
            <p>{{  $viatura->km}}</p>
    </div> 
    <div class="col-md-2">
          <label>CHASSI:</label>
          <p>{{  $viatura->chassi}}</p>
        </div>
    </div>
    <br>
    <div class="row">
    <div class="col-md-2">
        <label>Renavam:</label>
        <p>{{  $viatura->renavam }}</p>
</div> 
<div class="col-md-2">
      <label>Patrimônio:</label>
      <p>{{  $viatura->patrimonio  }} </p>
</div>


<div class="col-md-2">
    <label>Combustível:</label>  
    <p>{{$viatura->combustivel->descricao}} </p>
  </div>

  
  <div class="col-md-2">
    <label>Situação:</label>  
    <p>{{$viatura->situacaoviatura->descricao}}</p>
  </div>
</div>
<br>
<div class="row">
   <div class="col-md-2">
        <label>Ano Modelo:</label>
        <p>{{$viatura->ano_modelo }} </p>
    </div>
    <div class="col-md-2">
        <label>Ano Fabricação:</label>
        <p>{{$viatura->ano_fabricacao }}</p>
      </div>
      <div class="col-md-2">
                <label>Codigo dos Pneus:</label>  
                <p> {{ $viatura->tipopneu->descricao }} </p>
              </div>
             
            </div>
            <br>
            <div class="row">
              <div class="col-md-2">
                <label>Presídio:</label>  
                <p>{{$viatura->presidio }} </p>
              </div>
        <div class="col-md-2">
                <label>Bateria:</label>  
               <p> {{ $viatura->bateria->descricao }} </p>
              </div>
              <div class="col-md-2">
                <label>Revisão:
                   <p>{{$viatura->km_por_revisao}} KM</p></label>
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
@stop