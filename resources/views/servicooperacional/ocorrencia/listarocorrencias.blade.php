@extends('adminlte::page')

@section('title', 'SGCOM | Admin')

@section('content_header')
    <h1>Ocorrências</h1>
    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Ocorrências</a></li>
    </ol>
@stop

@section('content')
     <div class="box">
      <div class="box-header">
        <form action="{{route('servico.ocorrencia.search')}}" method="POST" class="form form-inline">
          {!! csrf_field() !!}        
        <div class="col-xs-6"> 
          <div class="input-group">
          <label for="tipo_ocorr">Tipo de ocorrência:</label>
          <select class="form-control" id="tipo_ocorr" name="tipo_ocorr" >
            <option value="">Selecione o tipo da ocorrência</option>
            @foreach( $tiposocorrencias as $tipoocorrencia )
            <option value="{{ $tipoocorrencia->id or '' }}" >
              <p> {{ $tipoocorrencia->descricao }} </p></option>
            @endforeach
            </select>
         </div>
        </div>
        <div class="col-xs-6">
         <div class="input-group">
           <label for="opm">Opm:</label>
          <select class="form-control" id="opm" name="opm" >
            <option value="">Selecione a OPM</option>
            @foreach( $opms as $opm )
            <option value="{{ $opm->id or ''}}">
              <p> {{ $opm->opm_sigla }} </p></option>
            @endforeach
          </select>
         </div>
        </div>
         <div class="col-xs-12">
          <div class="input-group">
            <label for="data_inicio">Período Inicial</label>
                <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                 id="data_inicio" name="data_inicio" >
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
          </div> 
        
          <div class="input-group">
              <label for="data_fim">Período Final</label>
                <input type="date" class="form-control timepicker" placeholder="Selecione a Data"
                 id="data_fim" name="data_fim">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
          </div>  

        </div>
              <button  type="submit" class="btn btn-primary">Pesquisar</button>
          </form>
        </div>
            <div class="box-body">
              <table id="tb1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tipo de Ocorrência</th>
                  <th>OPM</th>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>CPR</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  @forelse($ocorrencias as $ocorrencia)
                  <tr>
                    <td>{{$ocorrencia->tipoocorrencia->descricao}}</td>
                    <td>{{$ocorrencia->opm->opm_sigla}}</td>
                    <td>{{ \Carbon\Carbon::parse($ocorrencia->data)->format('d/m/Y')}}</td>
                    <td>{{ \Carbon\Carbon::parse($ocorrencia->hora)->format('H:i')}}</td>
                    <td>{{$ocorrencia->opm->cpr->sigla}}</td>
                    <td>
                      <a href="{{route('servico.ocorrencia.edit',$ocorrencia->id)}}" class="btn btn-adn">Editar</a>
                      <a href="{{route('servico.ocorrencia.detalhe',$ocorrencia->id)}}" class="btn btn-primary">Detalhe</a>
                      <a href="{{route('servico.ocorrencia.excluir',$ocorrencia->id)}}" 
                        onclick="return confirmExcluirOcorrencia();"
                        class="btn btn-danger">Excluir</a>                    
                    </td>
                  </tr>
                  @empty
                  @endforelse 
               </tbody>
                <tfoot>
                <tr>
                  <th>Tipo de Ocorrência</th>
                  <th>OPM</th>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>CPR</th>
                  <th></th>
                </tr>
                <p>Total de registros retornados: {{ $ocorrencias->total() }}</p>
                </tfoot>
              </table>
              <div >
                {!! $ocorrencias->links()!!}
            </div>
              
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