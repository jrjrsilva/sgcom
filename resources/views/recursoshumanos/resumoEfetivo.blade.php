@extends('adminlte::page')

@section('title', 'SGCOM | RH')

@section('content_header')
    <h1>QUADRO RESUMO DO EFETIVO OPERACIONAL E ADMINISTRATIVO</h1>
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
  </div>
 </div>

 <div class="col-md-4 col-sm-6 col-12">
  <div class="info-box bg-aqua">
  <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
      <div class="info-box-content">
      <span class="info-box-text">Efetivo Total por Sexo CPR</span>
      <span class="info-box-number">Efetivo Masculino: {{ $porSexoCpr[0]->M }}</span>
      <span class="info-box-number">Efetivo Feminino: {{ $porSexoCpr[0]->F }}</span>
    </div>
<!-- /.info-box-content -->
</div>
</div>
</div>
<div class="row">
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

<div class="col-md-4 col-sm-6 col-12">
  <div class="info-box bg-aqua">
  <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
      <div class="info-box-content">
      <span class="info-box-text">Efetivo Total por Sexo</span>
      <span class="info-box-number">Efetivo Masculino: {{ $porSexo[0]->M }}</span>
      <span class="info-box-number">Efetivo Feminino: {{ $porSexo[0]->F }}</span>
    </div>
<!-- /.info-box-content -->
</div>
</div>



</div> <!-- Fim CARDS-->
<!-- Quadro-->
<div class="row">
   <div class="col-md-4 col-sm-6 col-12">
          <div class="info-box bg-aqua">
          <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
              <div class="info-box-content">
              <span class="info-box-text">Efetivo Operacional</span>
              <span class="info-box-number">Guarda:        {{ $ferias }}</span>
              <span class="info-box-number">Sala de Meios: {{ $jms}}</span>
              <span class="info-box-number">Sala de Rádio: {{ $agregados}}</span>
              <span class="info-box-number">Viatura:       {{ $gestantes}}</span>
              <span class="info-box-number">Motociclista:  {{ $agregados}}</span>
              <span class="info-box-number">Base Móvel:    {{ $agregados}}</span>
              <span class="info-box-number">PO:                {{ $agregados}}</span>
              <span class="info-box-number">Outros:            {{ $agregados}}</span>
              <span class="info-box-number">Total Operacional: {{ $agregados}}</span>
            </div>
        <!-- /.info-box-content -->
        </div>
  </div>

  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box bg-aqua">
       <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
          <div class="info-box-content">
             <span class="info-box-text">Efetivo Administrativo</span>
             <span class="info-box-number">Com Restrição: {{ $adm_com}}</span>
             <span class="info-box-number">Sem Restrição: {{ $adm_sem}}</span>
             <span class="info-box-number">Total Administrativo: {{ $adm_com  + $adm_sem}}</span>
          </div>
     <!-- /.info-box-content -->
    </div>
  </div>

<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box bg-aqua">
       <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
           <div class="info-box-content">
             <span class="info-box-text">Efetivo Por Situação</span>
             @foreach ($efet_situacao as $st)
                <span class="info-box-number"><p>{{$st->nome.' : '. $st->total}}</p></span>
             @endforeach
           </div>
        <!-- /.info-box-content -->
        </div>
  </div>
  
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box bg-aqua">
       <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
           <div class="info-box-content">
             <span class="info-box-text">Efetivo Por Função</span>
             @foreach ($efet_funcao as $ef)
                <span class="info-box-number"><p>{{$ef->nome.' : '. $ef->total}}</p></span>
             @endforeach
           </div>
        <!-- /.info-box-content -->
        </div>
  </div>

</div>


<!-- Grafico-->
 <div class="container" style="display: block;">
        <h3 class="box-title">Gráficos OPM</h3>
        <div class="row">
          <div class="col-md-4 col-sm-6 col-12">
             <h3 class="box-title">Por Idade</h3>
              <canvas width="300" height="225" id="idadeopm" ></canvas>
          </div>
          <div class="col-md-4 col-sm-6 col-12">
             <h3 class="box-title">Tempo de Serviço</h3>
            <canvas width="300" height="225" id="tempoopm" ></canvas>
          </div>
          <div class="col-md-4 col-sm-6 col-12">
             <h3 class="box-title">Por GH</h3>
            <canvas width="300" height="225" id="graficoopm"></canvas>
          </div>
       </div>
</div>

 <div class="container" style="display: block;">
        <h3 class="box-title">Gráficos CPR</h3>
        <div class="row">
          <div class="col-md-4 col-sm-6 col-12">
             <h3 class="box-title">Por Idade</h3>
              <canvas width="300" height="225" id="idade" ></canvas>
          </div>
          <div class="col-md-4 col-sm-6 col-12">
             <h3 class="box-title">Tempo de Serviço</h3>
            <canvas width="300" height="225" id="tempo" ></canvas>
          </div>
          <div class="col-md-4 col-sm-6 col-12">
             <h3 class="box-title">Por GH</h3>
            <canvas id="myChart" width="400" height="400"></canvas>
          </div>
       </div>
</div>

{{$realEfetivoCpr}}

      <div class="box">
            <div class="box-header">
            <form action="{{route('rh.search')}}" method="POST" class="form form-inline">
              {!! csrf_field() !!}
              <input type="hidden" id="cprId" name="cprId" value="{{Auth::user()->efetivo->opm->cpr->id}}">
             <div class="row">
               <label for="pgh">Grau Hierarquico:</label>
                <select class="form form-control" id="pgh" name="pgh">
                  <option value="">Selecione o GH</option>
                  @foreach( $ghs as $gh )
                  <option value="{{ $gh->id }}" ><p> {{ $gh->sigla }} </p></option>
                  @endforeach
                </select>
             </div> <br>
             <div class="row">
                <label for="pregional">Comando Regional:</label>
                <select class="form form-control" id="pregional" name="pregional">
                  <option value="">Selecione o CPR</option>
                  @foreach( $cprs as $cpr )
                  <option value="{{ $cpr->id }}" ><p> {{ $cpr->sigla }} </p></option>
                  @endforeach
                </select>
                <label for="popm">OPM:</label>
                <select class="form form-control" id="opm" name="popm">
                  <option value="">Selecione a OPM</option>
                  @foreach( $opms as $opm )
                  <option value="{{ $opm->id }}" ><p> {{ $opm->opm_sigla }} </p></option>
                  @endforeach
                </select>
                <label for="pfuncao">Função:</label>
                <select class="form form-control" id="pfuncao" name="pfuncao">
                  <option value="">Selecione a Função</option>
                  @foreach( $funcoes as $funcao )
                  <option value="{{ $funcao->id }}" ><p> {{ $funcao->nome }} </p></option>
                  @endforeach
                </select>
              </div><br>
              <div class="row">
                <label for="psecao">Seção:</label>
                <select class="form form-control" id="psecao" name="psecao">
                  <option value="">Selecione a Seção</option>
                  @foreach( $secoes as $secao )
                  <option value="{{ $secao->id }}" ><p> {{ $secao->nome }} </p></option>
                  @endforeach
                </select>
                <label for="pcidade">Cidade:</label>
                <select class="form form-control" id="pcidade" name="pcidade">
                  <option value="">Selecione a Cidade</option>
                  @foreach( $cidades as $cidade )
                  <option value="{{ $cidade->cidade_estado }}" ><p> {{ $cidade->cidade_estado }} </p></option>
                  @endforeach
                </select>
                  <button id="btn-pesquisar"  type="submit" class="btn btn-primary" >Pesquisar</button>
              </form>
            </div>
          </div>
            
            <!-- /.box-header -->
            <div class="table-responsive">
            <div class="box-body">
  
         
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@stop

@section('js')


<script>


$("#btn-pesquisar").click(function(){
     var cont = 0;
     $("#form input").each(function(){
         if($(this).val() == "")
             {
               cont++;
             }
        });
     if(cont == 0)
         { 
        vlcprid = $("#cprId").val();
         $("#pregional").val(vlcprid);
             $("#form").submit();
         }
  });



$(document).ready(function(){
 new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: ['Até 35 Anos de idade', 'Entre 36 e 45 anos de idade', 'Entre 46 e 55 anos de idade', 'Acima de 56 anos de idade'],
      datasets: [{
        label: "",
        backgroundColor: [ 'rgba(255, 99, 132, 0.9)',
                    'rgba(54, 162, 235, 0.9)',
                    'rgba(255, 206, 86, 0.9)',
                    'rgba(75, 192, 192, 0.9)',
],
        data:  {{$agrupamentoIdade}}
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Distribuição do efetivo por idade'
      }
    }
});

});
</script>
<script>
    var ctx = document.getElementById('idadeopm').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ['Até 35 Anos de idade', 'Entre 36 e 45 anos de idade', 'Entre 46 e 55 anos de idade', 'Acima de 56 anos de idade'],
            datasets: [{
                label: 'Quantidade de policiais',
                data:  {{$agrupamentoIdadeOpm}},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('idade').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ['Até 35 Anos de idade', 'Entre 36 e 45 anos de idade', 'Entre 46 e 55 anos de idade', 'Acima de 56 anos de idade'],
            datasets: [{
                label: 'Quantidade de policiais',
                data:  {{$agrupamentoIdade}},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

<script>
    var ctx = document.getElementById('tempo').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ['Até 20 Anos', 'Entre 21 e 24 anos', 'Entre 25 e 29 anos', 'Acima de 30'],
            datasets: [{
                label: 'Quantidade de policiais',
                data:  {{$agrupamento}},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('tempoopm').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ['Até 20 Anos', 'Entre 21 e 24 anos', 'Entre 25 e 29 anos', 'Acima de 30'],
            datasets: [{
                label: 'Quantidade de policiais',
                data:  {{$agrupamentoOpm}},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>
 <script>  
      var dataPrevisto =  {{$previsao}};
      var dataRealEfetivo = {{$realEfetivo}}
       let grafico = document.getElementById('graficoopm').getContext('2d');
       let chart = new Chart(grafico, {
        type: 'bar',
        data: {
        labels: ['CEL', 'TEN CEL', 'MAJ', 'CAP', 'TEN', 'SUB TEN','SGT','CB','SD'],
                    
        datasets: [{
                label: 'Previsto',
                data: dataPrevisto,
                backgroundColor: "rgba(255, 0, 0, 0.5)",
                borderColor: "#f8767a"
            },
            {
                label: 'Disponível',
                data: dataRealEfetivo,
                backgroundColor: "rgba(0, 255, 0, 0.5)",
                borderColor: "#002200"
            }
        ]
    }
       });
   
 </script> 

 <script>  
      var dataPrevistoCpr =  {{$previsaoTotalCpr}};
      var dataRealEfetivoCpr =  {{$realEfetivoCpr}}
       let grafico = document.getElementById('grafico').getContext('2d');
       let chart = new Chart(grafico, {
        type: 'bar',
        data: {
        labels: ['CEL', 'TEN CEL', 'MAJ', 'CAP', 'TEN', 'SUB TEN','SGT','CB','SD'],
                    
        datasets: [{
                label: 'Previsto',
                data: dataPrevistoCpr,
                backgroundColor: "rgba(255, 0, 0, 0.9)",
                borderColor: "#0000ff"
            },
            {
                label: 'Disponível',
                data: dataRealEfetivoCpr,
                backgroundColor: "rgba(0, 255, 0, 0.3)",
                borderColor: "#002200"
            }
        ]
    }
       });
   
 </script>



<script>
   var dataRealEfetivoCpr =  {{$realEfetivoCpr}};
   var dataPrevistoCpr =  {{$realEfetivoCpr}};
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['CEL', 'TEN CEL', 'MAJ', 'CAP', 'TEN', 'SUB TEN','SGT','CB','SD'],
       datasets: [{
                label: 'Previsto',
                data: dataPrevistoCpr,
                backgroundColor: "rgba(255, 0, 0, 0.9)",
                borderColor: "#0000ff"
            },
            {
                label: 'Disponível',
                data: dataRealEfetivoCpr,
                backgroundColor: "rgba(0, 255, 0, 0.3)",
                borderColor: "#002200"
            }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
@stop

@section('style')
  
@endsection