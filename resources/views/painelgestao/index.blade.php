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
             teste2
         </div>     
        
        <div class="col-xs-4">
             Efetivo total da OPM:  {{$opmTotal}}
         </div>  
</div>
    
     <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
          <canvas id="grafico"></canvas>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
  
@stop

@section('js')
<script>
    var dataPrevisto =  {{$homicidioCpr}};
    var dataRealEfetivo = {{$homicidioOpm}};
     let grafico = document.getElementById('grafico').getContext('2d');
     let chart = new Chart(grafico, {
      type: 'bar',
      data: {
      labels: ['CPR', 'OPM'],
                  
      datasets: [{
              label: 'Homicídios do CPR',
              data: dataPrevisto,
              backgroundColor: "rgba(255, 0, 0, 0.9)",
              borderColor: "#0000ff"
          },
          {
              label: 'Homicídios da OPM',
              data: dataRealEfetivo,
              backgroundColor: "rgba(0, 255, 0, 0.3)",
              borderColor: "#002200"
          }
      ]
  }
     });
 
</script> 
@stop