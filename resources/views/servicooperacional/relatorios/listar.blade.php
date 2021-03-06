@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Relatórios</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Novo Relatório</a></li>
    </ol>
@stop

@section('content')
<div class="row">
     <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Total de Ocorrências</span>
                <span class="info-box-number">0{{ $ocorrencias->total() }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: {{ $ocorrencias->total() }}%"></div>
            </div>
            <span class="progress-description">
              20% das ocorrências de {{date('Y')}}
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-meh-o"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">CVLI</span>
                <span class="info-box-number">0{{ $cvli }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: {{$pcvli}}%"></div>
            </div>
            <span class="progress-description">
            {{number_format($pcvli,2)}}% de 257 em {{date('Y')}}
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-automobile"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">CVP</span>
                <span class="info-box-number">0{{ $cvp }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
              <div class="progress-bar" style="width: 00%"></div>
            </div>
            <span class="progress-description">
              {{number_format($pcvp,2)}}% em {{date('Y')}}
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Homicídios</span>
                <span class="info-box-number">0{{ $homicidio }}</span>
            <!-- The progress section is optional -->
            <div class="progress">
            <div class="progress-bar" style="width: {{$phomicidio}}%"></div>
            </div>
            <span class="progress-description">
            {{number_format($phomicidio,2)}}% dos homicidios de {{date('Y')}}
            </span>
            </div>
          <!-- /.info-box-content -->
       </div>
    </div>
    
    
    
</div>
     <div class="box">
         <div class="box-header">
         
             <form action="{{route('servico.ocorrencia.search')}}" method="POST" class="form form-inline">
          {!! csrf_field() !!}        
        
          
          <label for="tipo_ocorr">Tipo de Serviço:</label>
          <select class="form-control" id="tipo_ocorr" name="tipo_ocorr" >
            <option value="">Selecione o tipo da ocorrência</option>
            @foreach( $tiposocorrencias as $tipoocorrencia )
            <option value="{{ $tipoocorrencia->id or '' }}" >
              <p> {{ $tipoocorrencia->descricao }} </p></option>
            @endforeach
            </select>
     
     
        
         <label for="opm">OPM</label>
          <select class="form-control" id="opm" name="opm" >
            <option value="">Selecione a OPM</option>
            @foreach( $opms as $opm )
            <option value="{{ $opm->id or ''}}">
              <p> {{ $opm->opm_sigla }} </p></option>
            @endforeach
          </select>
         
   
                
            <label for="data_inicio">  Início</label>
                <input type="date" class="form-control timepicker" placeholder="Período Inicial"
                 id="data_inicio" name="data_inicio" >                
            <label for="data_fim">  Fim</label>
                <input type="date" class="form-control timepicker" placeholder="Período Final"
                 id="data_fim" name="data_fim">

            <button  type="submit" class="btn btn-primary">Pesquisar</button>     
          </form>
         
         
         </div>
        
        
            <div class="box-body">
              <table id="tb1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Policial</th>
                  <th>OPM</th>
                  <th>Data</th>
                  <th>Hora Início</th>
                  <th>Hora Término</th>
                  <th>CPR</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  @forelse($relatorios as $relatorio)
                  <tr>
                    <td><a href="">{{$relatorio->policial->nome}} - {{$relatorio->policial->grauhierarquico->sigla}}</a></td>
                    <td>{{$relatorio->opm->opm_sigla}}</td>
                    <td>{{ \Carbon\Carbon::parse($relatorio->data_servico)->format('d/m/Y')}}</td>
                    <td>{{ \Carbon\Carbon::parse($relatorio->hora_inicio)->format('H:i')}}</td>
                    <td>{{ \Carbon\Carbon::parse($relatorio->hora_termino)->format('H:i')}}</td>
                    <td>{{$relatorio->opm->cpr->sigla}}</td>
                    <td>
                          <a href="" class="btn btn-primary btn-flat"> <i class="fa fa-edit"></i></a>
                         
                        
                        
                    </td>
                  </tr>
                  @empty
                  @endforelse 
               </tbody>
                <tfoot>
                <tr>
                  <th>Policial</th>
                  <th>OPM</th>
                  <th>Data</th>
                  <th>Hora Início</th>
                  <th>Hora Término</th>
                  <th>CPR</>
                  <th></th>
                </tr>
                
                </tfoot>
              </table>
              <table id="tab2" class="table table-bordered">
                <tbody>
                  <tr>
                     <td> 
                      @if (isset($dataForm))
                      {{ $relatorios->appends($dataForm)->links() }}
                     @else
                       {!! $relatorios->links()!!}                  
                     @endif
                     </td>
                     <td align="right">Total de registros</td>
                     <td>{{ $relatorios->total() }}</td> 
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
  function confirmExcluirOcorrencia() {
  if(!confirm("Confirma exclusão desta ocorrência?"))
  event.preventDefault();
}
</script>

@stop