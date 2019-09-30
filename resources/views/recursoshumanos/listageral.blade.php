@extends('adminlte::page')

@section('title', 'SGCOM | RH')

@section('content_header')
    <h1>Recursos Humanos</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">RH</a></li>
    </ol>
@stop

@section('content')
<div class="row">
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
    <div class="progress-bar" style="width: {{ $previsao }}%"></div>
  </div>
  <span class="progress-description">
    {{$previsaoTotalOpm}} é o efetivo previsto para a OPM
  </span>
  </div>
<!-- /.info-box-content -->
</div>
</div>
 
</div>
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Gráfico</h3>
        <div class="box-tools pull-right">
          <!-- Collapse Button -->
          <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <canvas id="grafico"></canvas>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

      <div class="box">
            <div class="box-header">
            <form action="{{route('rh.searchMatricula')}}" method="POST" class="form form-inline">
              {!! csrf_field() !!}
              <label for="pnome">Nome:</label>    
              <input  type="text" name="pnome"  id="pnome" class="form-control"
               placeholder="Informe o nome"/>
               <label for="pmatricula">Matrícula:</label>    
              <input  type="number" pattern="[0-9]" maxlength=9 name="pmatricula"  id="pmatricula" class="form-control"
               placeholder="Informe a Matrícula"/>
                <label for="popm">OPM:</label>
                <select class="form form-control" id="opm" name="popm">
                  <option value="">Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id }}" ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
              
                  <button  type="submit" class="btn btn-primary">Pesquisar</button>
              </form>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                  <th>Grau Hierarquico</th>
                  <th>Nome</th>
                  <th>Matrícula</th>
                  <th>OPM</th>
                  <th>Tempo de Serviço</th>
                  <th>Sexo</th>
                  <th>Data de Admissão</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($efetivos as $efetivo)
                <tr>
                  <td>{{$efetivo->grauhierarquico->sigla}}</td>
                  <td>{{$efetivo->nome}}</td>
                  <td>{{$efetivo->matricula}}</td>
                  <td>{{$efetivo->opm->opm_sigla}}</td>
                  <td>{{$efetivo->tempoDecorrido($efetivo->dataadmissao)}}</td>
                  <td>{{$efetivo->sexo}}</td>
                  <td>{{ \Carbon\Carbon::parse($efetivo->dataadmissao)->format('d/m/Y')}}</td>
                  <td>
                    <a href="{{route('rh.edit',$efetivo->id)}}" class="btn btn-adn">Editar</a>
                   
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
                  <th>OPM</th>
                  <th>Tempo de Serviço</th>
                  <th>Sexo</th>
                  <th>Data de Admissão</th>
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
          <!-- /.box -->
        </div>
@stop

@section('js')
<script>

$(document).ready(function(){
 
});
</script>

 <script>

function renderChart(data, labels) {
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'This week',
                data: data,
            }]
        },
    });
}

$("#renderBtn").click(
    function () {
        data = [20000, 14000, 12000, 15000, 18000, 19000, 22000];
        labels =  ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
        renderChart(data, labels);
    }
);


console.log({{$previsao}});


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

@section('style')
<style>
  *{
    margin:0;
    padding:0;
  }
  #suadiv{
    position:relative;
    top:0;
    left:0;
    z-index:11;
    background-color:#fff;
    width:50%;
    height:50%;
  }
  </style>
  
@endsection