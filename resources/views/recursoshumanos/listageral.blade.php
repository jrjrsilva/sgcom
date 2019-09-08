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
    <p>Gestão de Efetivo </p>
     <div>
      <canvas id="grafico"></canvas>
     </div>
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
       let grafico = document.getElementById('grafico').getContext('2d');
       let chart = new Chart(grafico, {
        type: 'bar',
        data: {
        labels: ['CEL', 'TEN CEL', 'MAJ', 'CAP', 'TEN', 'SUB TEN','SGT','CB','SD'],
                    
        datasets: [{
                label: 'Previsto',
                data: [0, 1, 1, 3, 11, 11, 30,25,100],
                backgroundColor: "rgba(255, 0, 0, 0.9)",
                borderColor: "#0000ff"
            },
            {
                label: 'Disponível',
                data: [0, 0, 1, 3, 9, 8, 15, 5, 85],
                backgroundColor: "rgba(0, 255, 0, 0.3)",
                borderColor: "#002200"
            }
        ]
    }
       });


       
 </script>   

@stop