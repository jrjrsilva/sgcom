@extends('adminlte::page')



@section('title', 'SGCOM | Admin')



@section('content_header')

    <h1>Dashboard</h1>

@stop

@section('content')
    <div class="col-md-4 col-sm-6 col-12">
         <div class="info-box bg-aqua">
         <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
             <div class="info-box-content">
             <span class="info-box-text">Efetivo Total do CPR</span>
             <span class="info-box-number">{{ $cprTotal }}</span>
         <!-- The progress section is optional -->
         <div class="progress">
           <div class="progress-bar" style="width: {{ $cprTotal }}%"></div>
         </div>
         <span class="progress-description">
          {{$previsaoTotalCpr}} é o efetivo previsto
         </span>
         </div>
       <!-- /.info-box-content -->
    </div>
 </div>


 <div class="col-md-4 col-sm-6 col-12">
  <div class="info-box bg-aqua">
  <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
      <div class="info-box-content">
      <span class="info-box-text">Efetivo Total da Undade</span>
      <span class="info-box-number">{{ $opmTotal }}</span>
  <!-- The progress section is optional -->
  <div class="progress">
    <div class="progress-bar" style="width: {{ $opmTotal }}%"></div>
  </div>
  <span class="progress-description">
    {{$previsaoTotalOpm}} é o efetivo previsto
  </span>
  </div>
<!-- /.info-box-content -->
</div>
</div>
<div class="box-body" >
  <canvas id="grafico" height="230" width="680"></canvas>
</div>

<div class="box-body">
  <table id="tbEfetivo" class="table table-bordered table-striped">
    <thead>
    <tr>
      
      <th>Grau Hierarquico</th>
      <th>Nome</th>
      <th>Matrícula</th>
     <th></th>
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
<!-- /.box-body -->
</div>
@stop

@section('js')
<script>

$(document).ready(function(){
 
});
</script>

 <script>

      var dataPrevisto =  {{$previsao}};
      var dataRealEfetivo = {{$realEfetivo}}
       let grafico = document.getElementById('grafico').getContext('2d');
       let chart = new Chart(grafico, {
        
        type: 'bar',
        data: {
        labels: ['CEL', 'TEN CEL', 'MAJ', 'CAP', 'TEN', 'SUB TEN','SGT','CB','SD'],
                    
        datasets: [{
                label: 'Previsto',
                data: dataPrevisto,
                backgroundColor: "rgba(255, 0, 0, 0.9)",
                borderColor: "#0000ff"
            },
            {
                label: 'Disponível',
                data: dataRealEfetivo,
                backgroundColor: "rgba(0, 255, 0, 0.3)",
                borderColor: "#002200"
            }
        ]
    }
       });
   
 </script>   


@stop