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
            <caption>Aniversariantes</caption>
            <thead>
            <tr>              
              <th>OPM</th>
              <th>GH</th>
              <th>Nome</th>
              <th>Data</th>
          
            </tr>
            </thead>
            <tbody>
            @forelse($aniversarios as $efetivo)
            <tr>
              <td>{{$efetivo->opm_sigla}}</td>
              <td>{{$efetivo->sigla}}</td>
              <td>{{$efetivo->nome}}</td>
              <td>{{ \Carbon\Carbon::parse($efetivo->datanascimento)->format('d/m')}}</td>
              <td>
                 
              </td>
            </tr>
            @empty
            @endforelse 
            @forelse($aniversariosA as $efetivo)
            <tr>
              <td>{{$efetivo->opm_sigla}}</td>
              <td>{{$efetivo->sigla}}</td>
              <td>{{$efetivo->nome}}</td>
              <td>{{ \Carbon\Carbon::parse($efetivo->datanascimento)->format('d/m')}}</td>
              <td>
                 
              </td>
            </tr>
            @empty
            @endforelse 
            @forelse($aniversariosD as $efetivo)
            <tr>
              <td>{{$efetivo->opm_sigla}}</td>
              <td>{{$efetivo->sigla}}</td>
              <td>{{$efetivo->nome}}</td>
              <td>{{ \Carbon\Carbon::parse($efetivo->datanascimento)->format('d/m')}}</td>
              <td>
                 
              </td>
            </tr>
            @empty
            @endforelse 
           </tbody>
            <tfoot>
            <tr>
              <th>OPM</th>
              <th>GH</th>
              <th>Nome</th>
              <th>Data</th>
             <th></th>
            </tr>
            </tfoot>
          </table>
          <div >
            @if (isset($dataForm))
             {{ $aniversarios->appends($dataForm)->links() }}
            @else
              {!! $aniversarios->links()!!}
            @endif
        
        </div>
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