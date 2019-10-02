@extends('adminlte::page')

@section('title', 'SGCOM')

@section('content_header')
    <h1>Painel de Gestão</h1>
@stop

@section('content')
  <div class="row">     
            
         <div class="col-xs-4">
             Homicídios do CPR: {{$homicidioCpr}}
         </div>     
        
         <div class="col-xs-4">
           Percentual de Homicídios da OPM:  {{number_format($phomicidioOpm,2)}} % 
         </div>     
        
        <div class="col-xs-4">
             Efetivo total da OPM:  {{$opmTotal}}
         </div>  
</div>
    
<div class="box-body" >
    <canvas id="grafico" height="230" width="680"></canvas>
  </div>

  <div class="row">     
            
    <div class="col-xs-8">
        <table id="tbEfetivo" class="table table-bordered table-striped">
            <caption>Efetivo</caption>
            <thead>
            <tr>
              
              <th>Grau Hierarquico</th>
              <th>Nome</th>
              <th>Matrícula</th>
          
            </tr>
            </thead>
            <tbody>
            @forelse($efetivos as $efetivo)
            <tr>
              <td>{{$efetivo->grauhierarquico->sigla}}</td>
              <td>{{$efetivo->nome}}</td>
              <td>{{$efetivo->matricula}}</td>
              <td>
                 
              </td>
            </tr>
            @empty
            @endforelse 
           </tbody>
            <tfoot>
            <tr>
              <th>Grau Hierarquico</th>
              <th>Nome</th>
              <th>Matrícula</th>
             <th></th>
            </tr>
            </tfoot>
          </table>
          <div >
            @if (isset($dataForm))
             {{ $efetivos->appends($dataForm)->links() }}
            @else
              {!! $efetivos->links()!!}
            @endif
        
        </div>
    </div>     
   
    <div class="col-xs-4">
        <table id="example1" class="table table-bordered table-striped">
            <caption>Viaturas</caption>
            <thead>
            <tr>             
              <th>Prefixo</th>
              <th>Modelo</th>
              <th>Situação</th>
            </tr>
            </thead>
            <tbody>
            @forelse($viaturas as $viatura)
            <tr>
              <td>{{$viatura->prefixo}}</td>
              <td>{{$viatura->modeloveiculo->descricao}}</td>
              <td>{{$viatura->situacaoviatura->descricao}}</td>
            </tr>
            @empty
            @endforelse 
           </tbody>
            <tfoot>
            <tr>
                  <th>Prefixo</th>
                  <th>Modelo</th>
                  <th>Situação</th>
            </tr>
            </tfoot>
          </table>
          <div >
            @if (isset($dataForm))
             {{ $viaturas->appends($dataForm)->links() }}
            @else
              {!! $viaturas->links()!!}
            
            
            @endif
        
        </div>
    </div>     
   
</div>

  
@stop

@section('js')
<script>
    var homicidiosCpr =  {{$vlhom_cpr}};
    var homicidiosOpm = {{$vlhom_opm}};
     let grafico = document.getElementById('grafico').getContext('2d');
     let chart = new Chart(grafico, {
      type: 'bar',
      data: {
      labels: ['CPR', 'OPM'],
                  
      datasets: [{
              label: 'Homicídios do CPR',
              data: homicidiosCpr,
              backgroundColor: "rgba(255, 0, 0, 0.9)",
              borderColor: "#0000ff"
          },
          {
              label: 'Homicídios da OPM',
              data: homicidiosOpm,
              backgroundColor: "rgba(0, 255, 0, 0.3)",
              borderColor: "#002200"
          }
      ]
  }
     });
 
</script> 
@stop