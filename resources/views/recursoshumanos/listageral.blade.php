@extends('adminlte::page')

@section('title', 'SGCOM | RH')

@section('content_header')
    <h1>Gestão de Pessoal</h1>
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

<div class="col-md-4 col-sm-6 col-12">
  <div class="info-box bg-aqua">
  <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
      <div class="info-box-content">
      <span class="info-box-text">Situação do Efetivo</span>
      <span class="info-box-number">Férias: {{ $ferias }}</span>
      <span class="info-box-number">Junta Médica: {{ $jms}}</span>
      <span class="info-box-number">Restrição operacional: {{ $restricoes}}</span>
      <span class="info-box-number">Licença gestante: {{ $gestantes}}</span>
      <span class="info-box-number">Agregado para reserva: {{ $agregados}}</span>
    </div>
<!-- /.info-box-content -->
</div>
</div>


</div>

<div class="box">
      <div class="box-header with-border" style="display: none;">
        <h3 class="box-title">Gráfico</h3>
        <div class="box-tools pull-right">
          <!-- Collapse Button -->
          <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      
      <!-- /.box-header -->
     <div class="box-body">
        <canvas id="idade" ></canvas>
        <canvas id="tempo" ></canvas>
        <canvas id="grafico"></canvas>
        <canvas id="pie-chart" width="800" height="450"></canvas>
      </div>
      <!-- /.box-body -->
    </div>
    </div>
    <!-- /.box -->

    

      <div class="box">
            <div class="box-header">
            <form action="{{route('rh.search')}}" method="POST" class="form form-inline">
              {!! csrf_field() !!}
              <input type="hidden" id="cprId" name="cprId" value="{{Auth::user()->efetivo->opm->cpr->id}}">
              <label for="pnome">Nome:</label>    
              <input  type="text" name="pnome"  id="pnome" class="form-control"
               placeholder="Informe o nome"/>
               <label for="pmatricula">Matrícula:</label>    
              <input  type="number" pattern="[0-9]" maxlength=9 name="pmatricula"  id="pmatricula" class="form-control"
               placeholder="Informe a Matrícula"/>
                <label for="pgh">Grau Hierarquico:</label>
                <select class="form form-control" id="pgh" name="pgh">
                  <option value="">Selecione o GH</option>
                  @foreach( $ghs as $gh )
                  <option value="{{ $gh->id }}" ><p> {{ $gh->sigla }} </p></option>
                  @endforeach
                </select>
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
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabl-1" class="table table-bordered table-striped">
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
                  <td>{{$efetivo->sigla}}</td>
                  <td>{{$efetivo->nome}}</td>
                  <td>{{$efetivo->matricula}}</td>
                  <td>{{$efetivo->opm_sigla}}</td>
                  <td>{{$efetivo->tempoDecorrido($efetivo->dataadmissao)}}</td>
                  <td>{{$efetivo->sexo}}</td>
                  <td>{{ \Carbon\Carbon::parse($efetivo->dataadmissao)->format('d/m/Y')}}</td>
                  <td>
                    <a href="{{route('rh.historico',$efetivo->id)}}" class="btn btn-primary">Histórico</a>
                    <a href="{{route('rh.edit',$efetivo->id)}}" class="btn btn-primary">Editar</a>
                    <a href="{{route('rh.removerDaOpm',$efetivo->id)}}" class="btn btn-danger">Remover da OPM</a>
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
          <table id="tab2" class="table table-bordered">
              <thead>
                 <tr>
                     <th></th>
                     <th></th>                         
                </tr>
              </thead>
              <tbody>
              <tr>
                 <td> 
                  @if (isset($dataForm))
                  {{ $efetivos->appends($dataForm)->links() }}
                 @else
                   {!! $efetivos->links()!!}                  
                 @endif
                 </td>
                 <td align="right">Total de registros</td>
                 <td>{{ $efetivos->total() }}</td> 
              </tr>
             </tbody>
        </table> 
            

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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

@section('style')
  
@endsection